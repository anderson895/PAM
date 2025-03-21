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

    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `users` where `status`='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }




    public function Adduser($user_imageName, $user_employee_id_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation) {
    
        // Generate unique user ID
        do {
            $userId = rand(10000, 99999); 
            $checkQuery = $this->conn->prepare("SELECT 1 FROM users WHERE id = ?");
            
            if ($checkQuery === false) {
                die("Prepare failed: " . $this->conn->error);
            }
    
            $checkQuery->bind_param("s", $userId);
            $checkQuery->execute();
            $checkQuery->store_result();
        } while ($checkQuery->num_rows > 0); // Loop until a unique ID is found
        
        $checkQuery->close();
    
        // Hash password for security
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    
        // Insert Data into Database
        $sql = "INSERT INTO users (generated_id, email, password, fullname, nickname, role, designation, profile_picture, employee_id_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        // Bind parameters
        $stmt->bind_param("sssssssss", $userId, $user_email, $hashed_password, $user_fullname, $user_nickname, $user_type, $user_designation, $user_imageName, $user_employee_id_imageName);
    
        // Execute and check for success
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
