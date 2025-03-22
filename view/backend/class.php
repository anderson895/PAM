<?php
include ('dbconnect.php');
date_default_timezone_set('Asia/Manila');
$getDateToday = date('Y-m-d H:i:s'); 


class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function AddAssets($assets_imageName, $assets_code, $assets_name,$assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status,$assets_description,$assets_price, $assets_qty){
        $query = $this->conn->prepare(
            "INSERT INTO `assets` (`asset_code`, `name`, `category_id`,`subcategory_id`,`office_id`,`price`, `condition_status`,`status`,`image`,`quantity`,`description`) VALUES (?,?,?,?,?,?,?,?,?,?,?)"
        );
        $query->bind_param("sssssssssss", $assets_code, $assets_name, $assets_category,$assets_subcategory,$assets_Office,$assets_price, $assets_condition,$assets_status,$assets_imageName,$assets_qty,$assets_description);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }





    public function UpdateAssets($assets_id, $assets_imageName, $assets_code, $assets_name, $assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status, $assets_description, $assets_price, $assets_qty) {
        // Start base query
        $sql = "UPDATE `assets` 
                SET `asset_code` = ?, `name` = ?, `category_id` = ?, `subcategory_id` = ?, `office_id` = ?, 
                    `price` = ?, `condition_status` = ?, `status` = ?, `quantity` = ?, `description` = ?";
    
        // Check if image is not empty, include in the query
        $params = [$assets_code, $assets_name, $assets_category, $assets_subcategory, $assets_Office, 
                   $assets_price, $assets_condition, $assets_status, $assets_qty, $assets_description];
        
        $types = "ssssssssss";
    
        if (!empty($assets_imageName)) {
            $sql .= ", `image` = ?";
            $params[] = $assets_imageName;
            $types .= "s";
        }
    
        // Add WHERE clause
        $sql .= " WHERE `id` = ?";
        $params[] = $assets_id;
        $types .= "i";
    
        // Prepare the query
        $query = $this->conn->prepare($sql);
        
        // Bind parameters dynamically
        $query->bind_param($types, ...$params);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


   public function UpdateMaintenance($system_logoName,$system_name) {
    // Start base query
    $sql = "UPDATE `system_maintenance` 
            SET `system_name` = ?";
    $params = [$system_name];
    
    $types = "s";

    if (!empty($system_logoName)) {
        $sql .= ", `system_image` = ?";
        $params[] = $system_logoName;
        $types .= "s";
    }
    $sql .= " WHERE `system_id` = ?";
    $params[] = 1;
    $types .= "i";
    $query = $this->conn->prepare($sql);
    $query->bind_param($types, ...$params);

    if ($query->execute()) {
        return 'success';
    } else {
        return 'Error: ' . $query->error;
    }
}


    public function fetch_maintenance() {
        $query = $this->conn->prepare("SELECT * FROM `system_maintenance` LIMIT 1");

        if ($query->execute()) {
            $result = $query->get_result();
            // Fetch a single row as an associative array
            $data = $result->fetch_assoc();
            
            // Return the single record
            return $data;
        } else {
            return false;
        }
    }


    
    
    public function fetch_all_office(){
        $query = $this->conn->prepare("SELECT * FROM `offices`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_assets(){
        $query = $this->conn->prepare("SELECT assets.*,categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id;

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetch_all_request() {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_user_id,
                request.request_assets_id,
                request.request_qty,
                request.request_date,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.generated_id,
                users.designation as user_designation,
                
                -- Asset Fields
                assets.id AS asset_id,
                assets.asset_code AS asset_code,
                assets.name AS asset_name,
                assets.category_id AS asset_category,
                assets.subcategory_id AS asset_subcategory,
                assets.price AS asset_price,
                assets.condition_status AS asset_condition,
                assets.status AS asset_status
                
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            LEFT JOIN assets ON assets.id = request.request_assets_id
            ORDER BY request.request_id DESC
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function UpdateReqStatus($request_id, $action) {
        // Fetch the asset and request details
        $query = $this->conn->prepare("
            SELECT request.request_qty, assets.id as asset_id, assets.quantity 
            FROM `request` 
            LEFT JOIN assets ON assets.id = request.request_assets_id 
            WHERE request.request_id = ?
        ");
        $query->bind_param("s", $request_id);
    
        if ($query->execute()) {
            $result = $query->get_result();
    
            // Check if we got a result for the request
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $request_qty = $row['request_qty'];
                $asset_id = $row['asset_id'];
                $current_quantity = $row['quantity'];
    
                // Check if the requested quantity is greater than the available quantity
                if ($request_qty > $current_quantity) {
                    return 'Requested quantity is not enough for the current stocks. Available stock: ' . $current_quantity;
                }
    
                // Check if action is "Delivered"
                if ($action === 'Delivered') {
                    // Deduct the requested quantity from the asset quantity
                    $new_quantity = $current_quantity - $request_qty;
    
                    // Check if asset is out of stock
                    if ($new_quantity < 0) {
                        $new_quantity = 0; // Set quantity to zero if it's less than 0
                    }
    
                    // Update asset quantity in the database
                    $updateAssetQuery = $this->conn->prepare("
                        UPDATE assets SET quantity = ? WHERE id = ?
                    ");
                    $updateAssetQuery->bind_param("ii", $new_quantity, $asset_id);
                    $updateAssetQuery->execute();
                }
    
                // Update the request status
                $updateStatusQuery = $this->conn->prepare(
                    "UPDATE `request` SET `request_status` = ? WHERE `request_id` = ?"
                );
                $updateStatusQuery->bind_param("ss", $action, $request_id);
    
                if ($updateStatusQuery->execute()) {
                    return 'success';
                } else {
                    return 'Error: ' . $updateStatusQuery->error;
                }
            } else {
                return 'Error: Request not found';
            }
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    
    
    



        // ✅ Add validation before inserting request
    public function CreateRequest($add_user_id, $cat_assets_id, $assets_quantity, $supplier_name, $supplier_company){
        // 1️⃣ Check available quantity in `assets` table
        $check_query = $this->conn->prepare("
            SELECT `quantity` FROM `assets` WHERE `id` = ?
        ");
        $check_query->bind_param("i", $cat_assets_id);
        $check_query->execute();
        $result = $check_query->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $available_quantity = $row['quantity'];

            // 2️⃣ Validate if requested quantity is available
            if ($assets_quantity <= $available_quantity) {
                // 3️⃣ Insert request if quantity is sufficient
                $query = $this->conn->prepare("
                    INSERT INTO `request` 
                    (`request_user_id`, `request_assets_id`, `request_qty`, `request_supplier_name`, `request_supplier_company`)
                    VALUES (?,?,?,?,?)
                ");
                $query->bind_param("iiiss", $add_user_id, $cat_assets_id, $assets_quantity, $supplier_name, $supplier_company);

                if ($query->execute()) {
                    // // 4️⃣ Optional: Deduct the quantity from assets after request
                    // $update_query = $this->conn->prepare("
                    //     UPDATE `assets` SET `quantity` = `quantity` - ? WHERE `id` = ?
                    // ");
                    // $update_query->bind_param("ii", $assets_quantity, $cat_assets_id);
                    // $update_query->execute();

                    return 'success';
                } else {
                    return 'Error: ' . $query->error;
                }
            } else {
                // 5️⃣ Return error if quantity is insufficient
                return 'Requested quantity exceeds available stock. Available: ' . $available_quantity;
            }
        } else {
            return 'Error: Asset not found!';
        }
    }




    public function fetch_all_subcategory(){
        $query = $this->conn->prepare("SELECT * FROM `subcategories`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    


    public function fetch_all_category(){
        $query = $this->conn->prepare("SELECT * FROM `categories`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `users` where `status`='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    
    



    public function Adduser($user_imageName, $user_employee_id_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation) {
        do {
            $userId = rand(10000, 99999); 
            $checkQuery = $this->conn->prepare("SELECT 1 FROM users WHERE id = ?");
            
            if ($checkQuery === false) {
                die("Prepare failed: " . $this->conn->error);
            }
            $checkQuery->bind_param("s", $userId);
            $checkQuery->execute();
            $checkQuery->store_result();
        } while ($checkQuery->num_rows > 0); 
        $checkQuery->close();
        // Hash password for security
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        // Insert Data into Database
        $sql = "INSERT INTO users (generated_id, email, password, fullname, nickname, role, designation, profile_picture, employee_id_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssss", $userId, $user_email, $hashed_password, $user_fullname, $user_nickname, $user_type, $user_designation, $user_imageName, $user_employee_id_imageName);
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }
    


  
    

   



    public function DeleteUser($userId) {
        $status = 0; 
        
        $query = $this->conn->prepare(
            "UPDATE `users` SET `status` = ? WHERE `id` = ?"
        );
        $query->bind_param("is", $status, $userId);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function deleteAssets($assets_id) {
        $query = $this->conn->prepare(
            "DELETE FROM `assets` WHERE `id` = ?"
        );
        $query->bind_param("i", $assets_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    








    








    public function updateUser($update_id, $user_imageName, $user_employee_id_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation) {
        // Start building the SQL query
        $sql = "UPDATE users SET email = ?, fullname = ?, nickname = ?, role = ?, designation = ?";
        $params = [$user_email, $user_fullname, $user_nickname, $user_type, $user_designation];
        $types = "sssss"; // Data types: string (s)
    
        // Check if profile picture is provided
        if (!empty($user_imageName)) {
            $sql .= ", profile_picture = ?";
            $params[] = $user_imageName;
            $types .= "s";
        }
    
        // Check if employee ID picture is provided
        if (!empty($user_employee_id_imageName)) {
            $sql .= ", employee_id_picture = ?";
            $params[] = $user_employee_id_imageName;
            $types .= "s";
        }
    
        // Check if password is provided (update only if not empty)
        if (!empty($user_password)) {
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $sql .= ", password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }
    
        // Add WHERE condition
        $sql .= " WHERE id = ?";
        $params[] = $update_id;
        $types .= "i"; // ID is an integer
    
        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
    
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }
    






    public function check_account($id) {
        $id = intval($id);
        $query = "SELECT * FROM users WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }
}
