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
        $query = $this->conn->prepare(
            "UPDATE `assets` 
             SET `asset_code` = ?, `name` = ?, `category_id` = ?, `subcategory_id` = ?, `office_id` = ?, 
                 `price` = ?, `condition_status` = ?, `status` = ?, `image` = ?, `quantity` = ?, `description` = ?
             WHERE `id` = ?"
        );
        
        $query->bind_param("sssssssssssi", $assets_code, $assets_name, $assets_category, $assets_subcategory, $assets_Office, 
                                        $assets_price, $assets_condition, $assets_status, $assets_imageName, $assets_qty, 
                                        $assets_description, $assets_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
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


    public function fetch_all_request(){
        $query = $this->conn->prepare("SELECT * FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        ORDER BY `request_id` DESC
        ");

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
    


    public function CreateRequest($add_user_id, $cat_item, $material,$supplier_name,$supplier_company) {
        $query = $this->conn->prepare(
            "INSERT INTO `request` (`request_user_id`, `request_cat_item`, `request_material`,`request_supplier_name`, `request_supplier_company`) VALUES (?,?,?,?,?)"
        );
        $query->bind_param("issss", $add_user_id, $cat_item, $material,$supplier_name, $supplier_company);
    
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
    








    public function ApproveUser($request_id){
        $status = "Approve"; 
        
        $query = $this->conn->prepare(
            "UPDATE `request` SET `request_status` = ? WHERE `request_id` = ?"
        );
        $query->bind_param("ss", $status, $request_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }



    public function DeclineUser($request_id){
        $status = "Decline"; 
        
        $query = $this->conn->prepare(
            "UPDATE `request` SET `request_status` = ? WHERE `request_id` = ?"
        );
        $query->bind_param("ss", $status, $request_id);
        
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
