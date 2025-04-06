<?php 
include('../class.php');
$db = new global_class();
$fetch_all_user = $db->fetch_all_request_report();
$maintenance = $db->fetch_maintenance();

date_default_timezone_set('Asia/Manila');
session_start();

if (isset($_SESSION['id'])) {
    $id = intval($_SESSION['id']);
    $On_Session = $db->check_account($id);
}

$today = date('M. d, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Procurement Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black p-8">
    <!-- Header -->
    <div class="text-center mb-6">
        <img src="../assets/logo/<?=$maintenance['system_image']?>" alt="School Logo" class="mx-auto w-20 mb-2"> <!-- Optional -->
        <h1 class="text-xl font-bold uppercase text-red-700">Westmead International School</h1>
        <p class="text-sm">122 Gulod Labac, Batangas City, Batangas</p><?=$maintenance['system_image']?>
        <p class="text-sm">Email: westmead@gmail.com | Phone: (043) 425-7608</p>
        <h2 class="mt-4 text-lg font-semibold underline">Procurement Report</h2>
    </div>

    <!-- Report Metadata -->
    <div class="mb-6 text-sm">
        <p><strong>Date:</strong> <?=$today?></p>
        <p><strong>Full Name:</strong> <?=$On_Session[0]['fullname']?></p>
        <p><strong>ID No:</strong> <?=$On_Session[0]['user_id']?></p>
        <p><strong>Office Designation:</strong> <?=$On_Session[0]['designation']?></p>
    </div>

    <!-- Table -->
    <table class="w-full text-sm border border-gray-500 border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-400 p-2">Request Date</th>
                <th class="border border-gray-400 p-2">Request Item</th>
                <th class="border border-gray-400 p-2">Request Quantity</th>
                <th class="border border-gray-400 p-2">Request By</th>
                <th class="border border-gray-400 p-2">Price</th>
                <th class="border border-gray-400 p-2">Total</th>
                <th class="border border-gray-400 p-2">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($fetch_all_user->num_rows > 0): 
                while ($user = $fetch_all_user->fetch_assoc()):
                $total_price = $user['assets_price'] * $user['request_qty'];
                $request_date = date('M. d, Y', strtotime($user['request_date']));
        ?>
            <tr class="border">
                <td class="border border-gray-300 p-2 text-center"><?=$request_date?></td>
                <td class="border border-gray-300 p-2 text-center"><?=htmlspecialchars($user['assets_name'])?> <i>(<?=htmlspecialchars($user['request_variety'])?>)</i></td>
                <td class="border border-gray-300 p-2 text-center"><?=$user['request_qty']?></td>
                <td class="border border-gray-300 p-2 text-center"><?=htmlspecialchars($user['user_fullname'])?></td>
                <td class="border border-gray-300 p-2 text-center">₱<?=number_format($user['assets_price'],2)?></td>
                <td class="border border-gray-300 p-2 text-center">₱<?=number_format($total_price,2)?></td>
                <td class="border border-gray-300 p-2 text-center"><?=htmlspecialchars($user['request_status'])?></td>
            </tr>
        <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center text-gray-500 py-4">No records found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer Signatures -->
    <div class="mt-12 grid grid-cols-3 gap-4 text-center text-sm">
        <div>
            <p class="border-t border-gray-600 pt-2">Prepared by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Noted by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Approved by</p>
        </div>
    </div>
</body>
</html>
