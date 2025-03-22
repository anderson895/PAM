<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Reports</h2>
    <div class="flex items-center space-x-3">
        <?php
        $userImage = !empty($On_Session[0]['profile_image']) ? $On_Session[0]['profile_image'] : null;
        ?>
        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
            <?php if ($userImage): ?>
                <img src="<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
            <?php else: ?>
                <span class="material-icons text-3xl">account_circle</span>
            <?php endif; ?>
        </div>
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>

<div class="flex justify-center">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Inventory Report</h3>
            <p class="text-gray-600 mb-4">Summary of student performance.</p>
            <button class="print-report-inv bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                Print Report
            </button>
        </div>

        <!-- Card 2 (Procurements Report) -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Procurements Report</h3>
            <p class="text-gray-600 mb-4">Detailed procurement overview.</p>
            <button class="print-report-procurements bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                Print Report
            </button>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div id="printSection" class="hidden"></div>

<script>
    $(document).ready(function () {
        // Print Inventory Report
        $(".print-report-inv").click(function () {
            $.ajax({
                url: "backend/end-points/print_inventory_report.php", 
                type: "GET",
                success: function (data) {
                    var printWindow = window.open('', '', 'width=900,height=700');
                    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">'); // Load Tailwind
                    printWindow.document.write(data);
                    printWindow.document.close();
                    printWindow.print();
                },
                error: function () {
                    alert("Failed to fetch the inventory report.");
                }
            });
        });

        // Print Procurements Report
        $(".print-report-procurements").click(function () {
            $.ajax({
                url: "backend/end-points/print_procurement_report.php", 
                type: "GET",
                success: function (data) {
                    var printWindow = window.open('', '', 'width=900,height=700');
                    printWindow.document.write(data);
                    printWindow.document.close();
                    printWindow.print();
                },
                error: function () {
                    alert("Failed to fetch the procurement report.");
                }
            });
        });
    });
</script>

<?php include "components/footer.php"; ?>
