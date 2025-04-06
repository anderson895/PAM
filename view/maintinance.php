<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Maintinance</h2>
    <div class="flex items-center space-x-3">
        <?php
        $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;
        ?>
        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
            <?php if ($userImage): ?>
                <img src="../uploads/images/<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
            <?php else: ?>
                <span class="material-icons text-3xl">account_circle</span>
            <?php endif; ?>
        </div>
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>

<!-- Form for logo, system name, and color theme -->
<div class="max-w-4xl mx-auto p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">System Settings</h2>
    <form id="frmMaintenance">
        <!-- Logo Upload -->
        <div class="mb-6">
            <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
            <input type="file" id="logo" name="system_logo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" />
        </div>

        <!-- System Name -->
        <div class="mb-6">
            <label for="system_name" class="block text-sm font-medium text-gray-700">System Name</label>
            <input type="text" id="system_name" name="system_name" value="<?=$maintenance['system_name']?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter system name" />
        </div>

        

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" id="BtnMaintenance" class="inline-flex items-center px-6 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Save Changes
            </button>
        </div>
    </form>
</div>




<!-- Search Input with Icon -->
<div class="relative mb-4 w-full max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
        <i class="material-icons text-lg">search</i>
    </span>
    <input type="text" id="searchInput" placeholder="Search users..." 
        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
</div>

<!-- User Table Card -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
  
    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Asset ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Subcategory</th>
                    <th class="p-3">Condition</th>
                    <th class="p-3">Office</th>
                    <th class="p-3">Purchase Date</th>
                    <th class="p-3">Status</th>
                    
                   
                </tr>
            </thead>
            <tbody>
            <?php include "backend/end-points/under_maintinance_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>





<script>


$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#userTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>


<?php include "components/footer.php";?>
