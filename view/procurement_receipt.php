<?php 

include "components/header.php";

$request_id=$_GET['request_id'];
$fetch_request_receipt = $db->fetch_request_receipt($request_id);
$fetch_request_item = $db->fetch_request_item($fetch_request_receipt['request_id']);

?>
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg" id="printedArea">
    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold sm:text-2xl">Procurement Receipt</h1>
        <p class="text-sm text-gray-600 sm:text-base">List of Request</p>
    </div>

    <div class="mb-4 border-b pb-4">
        <p class="text-sm sm:text-base"><strong>Date:</strong> <?= date('M. d, Y', strtotime($fetch_request_receipt['request_date'])); ?></p>
        <p class="text-sm sm:text-base"><strong>Request By:</strong> <?=$fetch_request_receipt['user_fullname']?></p>
        <p class="text-sm sm:text-base"><strong>ID No:</strong> <?=$fetch_request_receipt['user_id']?></p>
        <p class="text-sm sm:text-base"><strong>Office Designation:</strong> <?=$fetch_request_receipt['request_designation']?></p>
        <p class="text-sm sm:text-base"><strong>Status:</strong> <?=ucfirst($fetch_request_receipt['request_status'])?></p>
    </div>
    
    <!-- Table -->
    <table class="w-full border-collapse border border-gray-300 text-sm text-gray-700 sm:text-base">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Request Item</th>
                <th class="border p-2">Variety</th>
                <th class="border p-2">Request Quantity</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Total</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($fetch_request_item)): 
            $count = 1;
            foreach ($fetch_request_item as $item): 
                $total_price = $item['r_item_price'] * $item['r_item_qty'];
            ?>
            <tr class="border">
                <td class="border p-2 text-center"><?= $item['name'] ?></td>
                <td class="border p-2 text-center"><?= $item['r_item_variety'] ?? 'N/A' ?></td> 
                <td class="border p-2 text-center"><?= $item['r_item_qty'] ?></td>
                <td class="border p-2 text-center">₱<?= number_format($item['r_item_price'], 2) ?></td>
                <td class="border p-2 text-center">₱<?= number_format($total_price, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">No records found.</td> <!-- Adjust colspan if necessary -->
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Print Button -->
<div class="text-center mt-4">
    <button id="printBtn" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Print Receipt</button>
</div>


<?php include "components/footer.php";?>

<script>
    $(document).ready(function() {
        $('#printBtn').click(function() {
            // Hide all other elements except #printedArea
            var printContent = $('#printedArea').html();
            var originalContent = $('body').html();

            $('body').html('<div id="printableArea">' + printContent + '</div>');

            // Trigger the print dialog for the new content
            window.print();

            // After printing, restore the original content
            $('body').html(originalContent);
        });
    });
</script>
