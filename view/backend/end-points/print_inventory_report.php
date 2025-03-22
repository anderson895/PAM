<?php 
include('../class.php');
$db = new global_class();
$fetch_all_user = $db->fetch_all_assets();

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

session_start();

if (isset($_SESSION['id'])) {
    $id = intval($_SESSION['id']);

   
    $On_Session = $db->check_account($id);

    // echo "<pre>";
    // print_r($On_Session);
    // echo "</pre>";
  

}

// Get today's date
$today = date('M. d, Y'); // Format: Jan. 30, 2025
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold">Inventory Report</h1>
            <p class="text-sm text-gray-600">List of Assets</p>
        </div>
        
        <!-- Employee Information -->
        <div class="mb-4 border-b pb-4">
            <p class="text-sm"><strong>Date:</strong> <?=$today?></p>
            <p class="text-sm"><strong>Full Name:</strong> <?=$On_Session[0]['fullname']?></p>
            <p class="text-sm"><strong>ID No:</strong> <?=$On_Session[0]['generated_id']?></p>
            <p class="text-sm"><strong>Office Designation:</strong> <?=$On_Session[0]['designation']?></p>
        </div>
        
        <!-- Table -->
        <table class="w-full border-collapse border border-gray-300 text-sm text-gray-700">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Quantity</th>
                    <th class="border p-2">Asset Code</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Item Description</th>
                    <th class="border p-2">Price</th>
                    <th class="border p-2">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($fetch_all_user->num_rows > 0): 
                    $count = 1;
                    while ($user = $fetch_all_user->fetch_assoc()):
                    $total_price=$user['price']*$user['quantity'];
                    ?>
                            <tr class="border">
                                <td class="border p-2 text-center"><?=$user['quantity']?></td>
                                <td class="border p-2 text-center"><?=$user['asset_code']?></td>
                                <td class="border p-2 text-center"><?=$user['name']?></td>
                                <td class="border p-2 text-center"><?=$user['description']?></td>
                                <td class="border p-2 text-center">₱<?=$user['price']?></td>
                                <td class="border p-2 text-center">₱<?=number_format($total_price,2)?></td>
                            </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        
    
        <!-- <div class="mt-4 text-right">
            <p class="text-sm"><strong>Subtotal:</strong> -</p>
            <p class="text-sm"><strong>12% Tax:</strong> -</p>
            <p class="text-sm font-bold"><strong>Total:</strong> -</p>
        </div> -->
    </div>
</body>
</html>
