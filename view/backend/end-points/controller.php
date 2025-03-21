<?php 
include('../class.php');

$db = new global_class();


$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['requestType'] =='Adduser'){

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix) {
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

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $user_image = $_FILES['user_image'] ?? null;
        $user_employee_id_image = $_FILES['user_employee_id_image'] ?? null;

        // NEW FILE NAME with Prefix
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir, "Profile") : null;
        $user_employee_id_imageName = $user_employee_id_image ? handleFileUpload($user_employee_id_image, $uploadDir, "ID") : null;

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

    }else if($_POST['requestType'] =='UpdateUser'){

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix) {
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

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $user_image = $_FILES['user_image'] ?? null;
        $user_employee_id_image = $_FILES['user_employee_id_image'] ?? null;

        // NEW FILE NAME with Prefix
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir, "Profile") : null;
        $user_employee_id_imageName = $user_employee_id_image ? handleFileUpload($user_employee_id_image, $uploadDir, "ID") : null;

        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_nickname = htmlspecialchars(trim($_POST['user_nickname']));
        $user_email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);

        $user_password = trim($_POST['user_password']);
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        $user_type = $_POST['user_type'];
        $user_designation = $_POST['user_designation'];
        $update_id = $_POST['update_id'];

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }

        $result = $db->updateUser($update_id,$user_imageName, $user_employee_id_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "User successfully registered"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='DeleteUser'){


        $userId = $_POST['userId'];

        $result = $db->DeleteUser($userId);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }else if($_POST['requestType'] =='ApproveUser'){


        $request_id = $_POST['request_id'];

        $result = $db->ApproveUser($request_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Approved Successful"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }else if($_POST['requestType'] =='DeclineUser'){


        $request_id = $_POST['request_id'];

        $result = $db->DeclineUser($request_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Request Declined"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }else if($_POST['requestType'] =='CreateRequest'){

       
        $add_user_id = htmlspecialchars(trim($_POST['add_user_id']));
        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_designation = htmlspecialchars(trim($_POST['user_designation']));
        $cat_item = htmlspecialchars(trim($_POST['cat_item']));
        $material = htmlspecialchars(trim($_POST['material']));
        $supplier_name = htmlspecialchars(trim($_POST['supplier_name']));
        $supplier_company = htmlspecialchars(trim($_POST['supplier_company']));

        $result = $db->CreateRequest($add_user_id, $cat_item, $material,$supplier_name,$supplier_company);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }



    }else if($_POST['requestType'] =='AddAssets'){

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix) {
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

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $assets_image = $_FILES['assets_img'] ?? null;

        // NEW FILE NAME with Prefix
        $assets_imageName = $assets_image ? handleFileUpload($assets_image, $uploadDir, "Assets") : null;

        $assets_code = htmlspecialchars(trim($_POST['assets_code']));
        $assets_name = htmlspecialchars(trim($_POST['assets_name']));
        $assets_Office = htmlspecialchars(trim($_POST['assets_Office']));
        $assets_category = htmlspecialchars(trim($_POST['assets_category']));
        $assets_subcategory = htmlspecialchars(trim($_POST['assets_subcategory']));
        $assets_condition = htmlspecialchars(trim($_POST['assets_condition']));
        $assets_status = htmlspecialchars(trim($_POST['assets_status']));
        $assets_description = htmlspecialchars(trim($_POST['assets_description']));
        $assets_price = htmlspecialchars(trim($_POST['assets_price']));
        $assets_qty = htmlspecialchars(trim($_POST['assets_qty']));
    


        $result = $db->AddAssets($assets_imageName, $assets_code, $assets_name,$assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status,$assets_description,$assets_price, $assets_qty);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }

    }else if($_POST['requestType'] =='UpdateAssets'){

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix) {
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

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $assets_image = $_FILES['assets_img'] ?? null;

        // NEW FILE NAME with Prefix
        $assets_imageName = $assets_image ? handleFileUpload($assets_image, $uploadDir, "Assets") : null;

        $assets_id = htmlspecialchars(trim($_POST['assets_id']));
        $assets_code = htmlspecialchars(trim($_POST['assets_code']));
        $assets_name = htmlspecialchars(trim($_POST['assets_name']));
        $assets_Office = htmlspecialchars(trim($_POST['assets_Office']));
        $assets_category = htmlspecialchars(trim($_POST['assets_category']));
        $assets_subcategory = htmlspecialchars(trim($_POST['assets_subcategory']));
        $assets_condition = htmlspecialchars(trim($_POST['assets_condition']));
        $assets_status = htmlspecialchars(trim($_POST['assets_status']));
        $assets_description = htmlspecialchars(trim($_POST['assets_description']));
        $assets_price = htmlspecialchars(trim($_POST['assets_price']));
        $assets_qty = htmlspecialchars(trim($_POST['assets_qty']));
    


        $result = $db->UpdateAssets($assets_id,$assets_imageName, $assets_code, $assets_name,$assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status,$assets_description,$assets_price, $assets_qty);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }

    }else if($_POST['requestType'] =='DeleteAssets'){


        $assets_id = $_POST['assets_id'];

        $result = $db->DeleteAssets($assets_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }
}
?>