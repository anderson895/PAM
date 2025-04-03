<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<?php 
$fetch_all_user = $db->fetch_all_assets();
if ($fetch_all_user->num_rows > 0): 
    $count = 1;
    while ($user = $fetch_all_user->fetch_assoc()): 
?>

<tr>
    <td class="p-2"><?php echo $count++ ?></td>
    <td class="p-2">
        <div id="qrcode-<?php echo $user['id']; ?>" 
             class="qr-container relative group cursor-pointer" 
             data-asset-details="<?php echo htmlspecialchars($user['asset_code']) . ' | ' . htmlspecialchars($user['name']) . ' | ' . htmlspecialchars($user['category_name']); ?>">
            <!-- Hover effect to scale QR Code -->
            <div class="absolute inset-0 flex items-center justify-center bg-gray-500 opacity-0 group-hover:opacity-50 transition-opacity">
                <span class="text-white">Click to View Larger QR</span>
            </div>
        </div>
    </td>
    <td class="p-2">
        <div class="flex items-center justify-center w-12 h-12">
            <?php if (!empty($user['image'])): ?>
                <img src="../uploads/images/<?php echo htmlspecialchars($user['image']); ?>" 
                    alt="Profile Picture" 
                    class="w-10 h-10 rounded-full">
            <?php else: ?>
                <i class="material-icons text-gray-500" style="font-size: 3rem;">image</i>
            <?php endif; ?>
        </div>
    </td>
  
    <td class="p-2"><?php echo htmlspecialchars($user['asset_code']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['description']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['category_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['subcategory_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['condition_status']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['office_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['purchase_date']); ?></td>
    <td class="p-2">₱<?php echo htmlspecialchars(number_format($user['price'],2)); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['status']); ?></td>

    <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
        <td class="p-2">
            <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateAssets" 
                data-id="<?= htmlspecialchars($user['id']) ?>"
                data-asset_code="<?= htmlspecialchars($user['asset_code']) ?>"
                data-name="<?= htmlspecialchars($user['name']) ?>"
                data-category_id="<?= htmlspecialchars($user['category_id']) ?>"
                data-subcategory_id="<?= htmlspecialchars($user['subcategory_id']) ?>"
                data-condition_status="<?= htmlspecialchars($user['condition_status']) ?>"
                data-office_id="<?= htmlspecialchars($user['office_id']) ?>"
                data-purchase_date="<?= htmlspecialchars($user['purchase_date']) ?>"
                data-status="<?= htmlspecialchars($user['status']) ?>"
                data-price="<?= htmlspecialchars($user['price']) ?>"
                data-description="<?= htmlspecialchars($user['description']) ?>"
                data-variety="<?= htmlspecialchars($user['variety']) ?>">
                Update 
            </button>

            <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteAssets" 
                data-id="<?= htmlspecialchars($user['id']) ?>">
                Remove
            </button>
        </td>
    <?php } ?>
</tr>

<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="9" class="p-2 text-center">No record found.</td>
</tr>
<?php endif; ?>


<!-- Modal for displaying large QR Code -->
<div id="qr-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white p-5 rounded-md w-96">
        <div class="flex justify-end">
            <button id="close-modal" class="text-red-500 text-xl">&times;</button>
        </div>
        <div id="large-qr-container" class="flex justify-center items-center">
            <!-- The larger QR code will be injected here -->
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
    // Generate QR Codes
    <?php 
    $fetch_all_user = $db->fetch_all_assets();
    while ($user = $fetch_all_user->fetch_assoc()): 
    ?>
        var assetDetails = "<?php echo htmlspecialchars($user['asset_code']); ?> | <?php echo htmlspecialchars($user['name']); ?> | <?php echo htmlspecialchars($user['category_name']); ?>";

        new QRCode(document.getElementById("qrcode-<?php echo $user['id']; ?>"), {
            text: assetDetails,
            width: 80,
            height: 80
        });
    <?php endwhile; ?>

    // Click event to open modal with large QR code
    $('.qr-container').click(function() {
        var assetDetails = $(this).data('asset-details');  // Get asset details dynamically from the clicked QR container

        var largeQRCode = new QRCode(document.createElement("div"), {
            text: assetDetails,
            width: 200,
            height: 200
        });

        $('#large-qr-container').html(largeQRCode._oDrawing._el);  // Inject the larger QR code
        $('#qr-modal').fadeIn();  // Show the modal
    });

    // Close modal
    $('#close-modal').click(function() {
        $('#qr-modal').fadeOut();  // Hide the modal
    });
       // Close Modal when clicking outside the modal content
    $("#qr-modal").click(function(event) {
            if ($(event.target).is("#qr-modal")) {
                $("#qr-modal").fadeOut();
            }
    });

});
</script>