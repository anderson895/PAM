<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function Login($email, $password)
    {
        $query = $this->conn->prepare("SELECT * FROM `users` WHERE `email` = ? AND `status` = '1'");
        $query->bind_param("s", $email);
        
        // Execute the query
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password'])) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    session_regenerate_id(true);
                    
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];

                    $query->close();

                    return $user;
                }
            }
        }
        $query->close();
        return false;
    }
}