<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'Login') {
                // Sanitize input
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                    // Check for empty fields
                    if (empty($email) || empty($password)) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Please enter both username and password.'
                        ]);
                        exit;
                    }

                    // Attempt login
                    $user = $db->Login($email, $password);

                    if ($user) {
                        // Start session securely
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        session_regenerate_id(true);

                        // Determine the redirect path based on user_type
                        $redirectPath = '';
                        if ($user['role'] === 'administrator') {
                            $redirectPath = 'view/dashboard';
                        } else {
                            $redirectPath = 'view/home';
                        }

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Login successful',
                            'redirect' => $redirectPath // Send the redirect path
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Invalid username or password.'
                        ]);
                    }


        } else {
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>