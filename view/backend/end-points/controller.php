<?php 
include('../class.php');

$db = new global_class();


$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['requestType'] =='Adduser'){


        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB
        
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }
        
            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }
        
            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }
        
            if ($file['size'] > $maxFileSize) {
                return null;
            }
        
            $fileName = generateUniqueFilename($file);
            $destination = $uploadDir . $fileName;
        
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }
        
      
        $user_image = $_FILES['user_image']?? null;
        $user_employee_id_image = $_FILES['user_employee_id_image']?? null;

        //NEW FILE NAME 
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir) : null;
        $user_employee_id_imageName = $user_employee_id_image ? handleFileUpload($user_employee_id_image, $uploadDir) : null;

        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_nickname = htmlspecialchars(trim($_POST['user_nickname']));
        $user_email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
      

        $user_password = trim($_POST['user_password']);
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        $user_type = $_POST['user_type'];
        $user_designation = $_POST['user_designation'];



        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }
        $result = $db->Adduser($user_imageName, $user_employee_id_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "User successfully registered"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }
}
?>