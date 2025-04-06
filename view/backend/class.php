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




    public function all_user_request()
{
    $query = "
        SELECT 
            users.fullname,
            COUNT(*) AS totalRequest
        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        
        GROUP BY users.fullname
    ";

    $result = $this->conn->query($query);

    if ($result) {
        $requestData = [];

        while ($row = $result->fetch_assoc()) {
            // Append the data to the array
            $requestData[] = [
                'fullname' => $row['fullname'],
                'totalRequest' => $row['totalRequest']
            ];
        }

        // Return the data as JSON
        echo json_encode($requestData);
    } else {
        error_log('Database query failed: ' . $this->conn->error);
        echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
    }
}





public function all_item_request()
{
    $query = "
        SELECT 
            assets.name,
            COUNT(*) AS totalRequest
        FROM `request_item`
        LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
        
        GROUP BY assets.name
    ";

    $result = $this->conn->query($query);

    if ($result) {
        $requestData = [];

        while ($row = $result->fetch_assoc()) {
            // Append the data to the array
            $requestData[] = [
                'name' => $row['name'],
                'totalRequest' => $row['totalRequest']
            ];
        }

        // Return the data as JSON
        echo json_encode($requestData);
    } else {
        error_log('Database query failed: ' . $this->conn->error);
        echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
    }
}









    public function getDataAnalytics()
    {
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM `users` WHERE status='1') AS totalUser,
                (SELECT COUNT(*) FROM `request`) AS request,
                (SELECT COUNT(*) FROM `assets`) AS totalAssets
        ";
    
        $result = $this->conn->query($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }



    public function AddAssets($assets_imageName, $assets_code, $assets_name, $assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status, $assets_description, $assets_price, $variety_json) {
    
       
        $checkAssetCode = $this->conn->prepare("SELECT asset_code FROM assets WHERE asset_code = ?");
        $checkAssetCode->bind_param("s", $assets_code); 
        $checkAssetCode->execute();
        $checkAssetCodeResult = $checkAssetCode->get_result();
        
        if ($checkAssetCodeResult->num_rows > 0) {
            return "Asset code already exists. Please use a different code.";
        }

        $query = $this->conn->prepare(
            "INSERT INTO `assets` (`asset_code`, `name`, `category_id`, `subcategory_id`, `office_id`, `price`, `condition_status`, `status`, `image`, `description`, `variety`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $query->bind_param(
            "sssssssssss", 
            $assets_code, 
            $assets_name, 
            $assets_category, 
            $assets_subcategory, 
            $assets_Office, 
            $assets_price, 
            $assets_condition, 
            $assets_status, 
            $assets_imageName,
            $assets_description, 
            $variety_json  
        );
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    




    public function UpdateAssets($assets_id, $assets_imageName, $assets_code, $assets_name, $assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status, $assets_description, $assets_price,$variety_json) {
        // Start base query
        $sql = "UPDATE `assets` 
                SET `asset_code` = ?, `name` = ?, `category_id` = ?, `subcategory_id` = ?, `office_id` = ?, 
                    `price` = ?, `condition_status` = ?, `status` = ?, `description` = ?, `variety` = ?";
    
        // Check if image is not empty, include in the query
        $params = [$assets_code, $assets_name, $assets_category, $assets_subcategory, $assets_Office, 
                   $assets_price, $assets_condition, $assets_status, $assets_description,$variety_json];
        
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
        LEFT JOIN offices ON offices.id = assets.office_id

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function under_maintinance_list(){
        $query = $this->conn->prepare("SELECT assets.*,categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id
        where `status` = 'Under Maintenance'

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetch_all_assets_procurment(){
        $query = $this->conn->prepare("SELECT assets.*,categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id
        where (condition_status = 'New' OR condition_status = 'Good') AND(`status` = 'Available' OR `status` = 'Disposed')

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function AddCart($add_id,$asset_id,$qty,$variety) {
        // Check if the asset already exists in the cart
        $checkQuery = $this->conn->prepare("SELECT cart_qty FROM request_cart WHERE cart_user_id = ? AND cart_asset_id = ? AND cart_variety = ?");
        $checkQuery->bind_param("iis", $add_id, $asset_id,$variety);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
    
        if ($result->num_rows > 0) {
            // Item exists, update the quantity
            $updateQuery = $this->conn->prepare("UPDATE request_cart SET cart_qty = cart_qty + $qty WHERE cart_user_id = ? AND cart_asset_id = ? AND cart_variety = ?");
            $updateQuery->bind_param("iis", $add_id, $asset_id,$variety);
            return $updateQuery->execute();
        } else {
            // Item does not exist, insert a new row
            $insertQuery = $this->conn->prepare("INSERT INTO request_cart (cart_user_id, cart_asset_id, cart_qty, cart_variety) VALUES (?, ?, ?,?)");
            $insertQuery->bind_param("iiis", $add_id, $asset_id,$qty,$variety);
            return $insertQuery->execute();
        }
    }



    // public function confirmRequest($add_id,$supplier_name,$supplier_company,$designation) {
       
    //         // Item does not exist, insert a new row
    //         $insertQuery = $this->conn->prepare("INSERT INTO request (request_user_id, request_supplier_name, request_supplier_company,request_designation) VALUES (?,?,?,?)");
    //         $insertQuery->bind_param("isss", $add_id, $supplier_name,$supplier_company,$designation);
    //         return $insertQuery->execute();
        
    // }

    public function confirmRequest($add_id,$supplier_name,$supplier_company,$designation){
        // Generate a unique invoice number
        do {
            $request_invoice = 'REQ-' . time() . rand(1000, 9999);
            $checkQuery = $this->conn->prepare("SELECT COUNT(*) FROM `request` WHERE `request_invoice` = ?");
            $checkQuery->bind_param("s", $request_invoice);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();
        } while ($count > 0); // Repeat until a unique invoice is found
    
        // Prepare the insert query
        $query = $this->conn->prepare(
            "INSERT INTO `request` (`request_invoice`,`request_user_id`, `request_supplier_name`,`request_supplier_company`, `request_designation`) 
            VALUES ( ?, ?,?, ?, ?)"
        );
        $query->bind_param("sisss",$request_invoice, $add_id, $supplier_name,$supplier_company, $designation);
    
        if ($query->execute()) {
            return [
                'id' => $this->conn->insert_id, 
                'invoice' => $request_invoice,
                'request_user_id' => $add_id,
            ]; // Return both the inserted ID and the invoice number
        } else {
            return ['error' => 'Error: ' . $query->error];
        }
    }



    public function addpurchase_item($request_id,$add_id,$cart_id,$asset_id,$price, $cart_qty,$cart_variety) {
        // Insert purchase item
        $query = $this->conn->prepare("
            INSERT INTO `request_item` (`r_request_id`, `r_item_asset_id`, `r_item_qty`, `r_item_variety`, `r_item_price`) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $query->bind_param("iiisd", $request_id, $asset_id, $cart_qty, $cart_variety, $price);
        
        if (!$query->execute()) {
            return 'Error: ' . $query->error;
        }
        $query->close(); // Close statement
    
     
    
        // Fetch all cart items for the given product and branch
        $cartQuery = $this->conn->prepare("
            SELECT cart_id  
            FROM request_cart 
            WHERE cart_asset_id = ? AND cart_user_id = ?
        ");
        $cartQuery->bind_param("ii", $asset_id, $add_id);
        $cartQuery->execute();
        $result = $cartQuery->get_result();
        $cartQuery->close(); // Close statement after use
    
        if ($result->num_rows > 0) {
            // Delete each cart entry
            while ($row = $result->fetch_assoc()) {
                $deleteQuery = $this->conn->prepare("
                    DELETE FROM request_cart WHERE cart_id = ?
                ");
                $deleteQuery->bind_param("i", $row['cart_id']);
                $deleteQuery->execute();
                $deleteQuery->close(); // Close each delete query
            }
        }
    
        return 'success';
    }
    


    public function fetch_all_request_for_admin() {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation as user_designation
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.status='1'
            ORDER BY request.request_id DESC
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function fetch_all_request_report() {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation AS user_designation,
                
                -- Assets Fields
                assets.id AS assets_id,
                assets.name AS assets_name,
                assets.price AS assets_price,

                 -- Request item Fields
                request_item.r_item_qty AS request_qty,
                request_item.r_item_variety AS request_variety
                
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            LEFT JOIN request_item ON request_item.r_request_id = request.request_id 
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
            ORDER BY request.request_id DESC
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    


    public function fetch_all_request($userID) {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation as user_designation
               
                
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            where request.request_user_id=$userID AND request.status='1'
            ORDER BY request.request_id DESC
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    
    public function fetch_request_receipt($request_id) {
        $query = $this->conn->prepare("SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                -- User Fields
                users.id AS userid,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation as user_designation
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.request_id = ?
            ORDER BY request.request_id DESC
        ");
        
        $query->bind_param("i", $request_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                // Return the result as an associative array
                return $result->fetch_assoc();  // Fetching only the first row
            } else {
                return null;  // No records found
            }
        } else {
            return null;  // Query execution failed
        }
    }




    public function fetch_request_item($request_id) {
        $query = $this->conn->prepare("SELECT 
                -- User Fields
                request_item.r_request_id,
                request_item.r_item_qty,
                request_item.r_item_price,
                request_item.r_item_variety,
                request.request_status,
                assets.name
            FROM `request_item`
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
            LEFT JOIN request ON request.request_id = request_item.r_request_id
            WHERE request_item.r_request_id = ?
            ORDER BY request_item.r_request_id DESC
        ");
        
        $query->bind_param("i", $request_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                // Fetch all rows as an associative array
                return $result->fetch_all(MYSQLI_ASSOC);  
            } else {
                return null;  
            }
        } else {
            return null;  
        }
    }
    
    
    



    public function UpdateReqStatus($request_id, $action) {
    
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
    }
    
    
    
    



    



    public function fetch_all_subcategory(){
        $query = $this->conn->prepare("SELECT * FROM `subcategories`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    
    public function remove_from_cart($cart_id){
        $query = $this->conn->prepare("DELETE FROM `request_cart` WHERE cart_id = ?");
        
        $query->bind_param("i", $cart_id); 
        
        if ($query->execute()) {
            return true; 
        } else {
            return false;
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


    public function fetch_all_receive_logs(){
        $query = $this->conn->prepare("SELECT * FROM `recieved_logs`
        LEFT JOIN users ON users.id = recieved_logs.recieved_user_id
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function updateLogs($log_id, $received_by, $asset_name, $asset_description, $asset_supplier_name, $asset_supplier_company, $asset_qty) {
        $sql = "UPDATE recieved_logs 
                SET recieved_supplier_name = ?, 
                    recieved_supplier_company = ?, 
                    recieved_assets_name = ?, 
                    recieved_description = ?, 
                    recieved_assets_qty = ?, 
                    recieved_user_id = ? 
                WHERE recieved_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiii", $asset_supplier_name, $asset_supplier_company, $asset_name, $asset_description, $asset_qty, $received_by, $log_id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }
    
    
    public function Adduser($userId,$user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation) {
       
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        // Insert Data into Database
        $sql = "INSERT INTO users (user_id, email, password, fullname, nickname, role, designation, profile_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssss", $userId, $user_email, $hashed_password, $user_fullname, $user_nickname, $user_type, $user_designation, $user_imageName);
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }


    public function UpdatePassword($user_id, $password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Update password in the database
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error in preparing statement: ' . $this->conn->error;
        }
    
        $stmt->bind_param("ss", $hashed_password, $user_id);
    
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return 'success';
            } else {
                $stmt->close();
                return 'No rows updated  user_id might not exist or password is the same.';
            }
        }
        
    }
    



    public function recordLogs($received_by,$asset_name,$asset_description,$asset_supplier_name,$asset_supplier_company,$asset_qty) {
       
        $sql = "INSERT INTO recieved_logs (recieved_supplier_name, recieved_supplier_company, recieved_assets_name, recieved_description, recieved_assets_qty, recieved_user_id) 
                VALUES ( ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssii", $asset_supplier_name, $asset_supplier_company, $asset_name, $asset_description, $asset_qty, $received_by);
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }
    

    public function count_notification()
    {
        // Count pending requests
        $pendingQuery = $this->conn->prepare("
            SELECT  
            COUNT(CASE WHEN request.request_status = 'pending' THEN 1 END) AS PendingCounts
        FROM request
        LEFT JOIN users ON users.user_id = request.request_user_id
        WHERE request.status = '1'
        ");
        
        // Count assets under maintenance
        $maintenanceQuery = $this->conn->prepare("
            SELECT COUNT(*) AS UnderMaintenanceCounts 
            FROM assets 
            WHERE status = 'Under Maintenance'
        ");
    
        $pendingCount = 0;
        $maintenanceCount = 0;
    
        if ($pendingQuery->execute()) {
            $pendingResult = $pendingQuery->get_result()->fetch_assoc();
            $pendingCount = $pendingResult['PendingCounts'];
        }
    
        if ($maintenanceQuery->execute()) {
            $maintenanceResult = $maintenanceQuery->get_result()->fetch_assoc();
            $maintenanceCount = $maintenanceResult['UnderMaintenanceCounts'];
        }
    
        // Return combined result
        echo json_encode([
            'PendingCounts' => $pendingCount,
            'UnderMaintenanceCounts' => $maintenanceCount
        ]);
    }
    




    
    
    
    

  
    


  
    public function ArchiveRequest($request_id) {
        $status = 0; 
        
        $query = $this->conn->prepare(
            "UPDATE `request` SET `status` = ? WHERE `request_id` = ?"
        );
        $query->bind_param("is", $status, $request_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
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
    






    








    public function updateUser($userId,$update_id, $user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation) {
        // Start building the SQL query
        $sql = "UPDATE users SET user_id=?, email = ?, fullname = ?, nickname = ?, role = ?, designation = ?";
        $params = [$userId,$user_email, $user_fullname, $user_nickname, $user_type, $user_designation];
        $types = "ssssss"; // Data types: string (s)
    
        // Check if profile picture is provided
        if (!empty($user_imageName)) {
            $sql .= ", profile_picture = ?";
            $params[] = $user_imageName;
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
    


    public function fetch_all_cart($id) {
        $query = $this->conn->prepare("
            SELECT c.cart_id, 
                a.asset_code, 
                a.id as asset_id, 
                a.name, 
                a.price,
                c.cart_qty,
                c.cart_variety
            FROM request_cart c 
            JOIN assets a ON c.cart_asset_id = a.id
            WHERE c.cart_user_id = ?
        ");
        
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
    
        $cartItems = [];
    
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'cart_id' => $row['cart_id'], 
                'asset_id' => $row['asset_id'], 
                'asset_code ' => $row['asset_code'],
                'name' => ucfirst($row['name']),
                'price' => $row['price'],
                'cart_qty' => $row['cart_qty'],
                'cart_variety' => ucfirst($row['cart_variety'])
            ];
        }
    
        return $cartItems;
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
