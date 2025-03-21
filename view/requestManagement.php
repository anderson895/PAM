


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Supply Request</h2>
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
    <button id="CreateRequestButton" class="bg-red-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-red-600 transition duration-300 mb-4">
        <span class="material-icons mr-2 text-base">description</span>
        Create Request
    </button>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Full Name</th>
                    <th class="p-3">Employee ID</th>
                    <th class="p-3">Office Designation</th>
                    <th class="p-3">Item</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Supplier Name</th>
                    <th class="p-3">Supplier Company</th>
                    <th class="p-3">Status</th>
                    
                    <?php if ($On_Session[0]['role'] == "Administrator") {
                        echo '<th class="p-3 text-center">Action</th>';
                    } ?>
                </tr>
            </thead>
            <tbody>
            <?php 
                include "backend/end-points/request_list.php"; 
            ?>
            </tbody>
        </table>
    </div>
</div>





<!-- Modal for Create Request -->
<div id="CreateRequestModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-[40rem] p-6"> 
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Create Request</h3>
        <form id="createRequestFrm" >
            
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            <input hidden type="text" id="add_user_id" name="add_user_id">
            <div class="mb-4 relative">
                <label for="search_user_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="search_user_fullname" name="user_fullname" class="w-full p-2 border rounded-md" required>
                <div id="employeeSuggestions" class="absolute left-0 bg-white border border-gray-300 rounded-md shadow-md w-full hidden mt-1 z-50"></div>
            </div>


            <div class="mb-4">
                <label for="add_user_generated_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                <input readonly type="text" id="add_user_generated_id" name="user_generated_id" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="add_user_designation" class="block text-sm font-medium text-gray-700">Office Designation</label>
                <input readonly type="text" id="add_user_designation" name="user_designation" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="add_cat_item" class="block text-sm font-medium text-gray-700">Category Item</label>
                <select name="cat_item" id="add_cat_item" class="w-full p-2 border rounded-md" required>
                    <option value="" disabled="" selected="">Select Item</option>
                    <option value="writingtools">Writing Tools</option>
                    <option value="paperproducts">Paper Products</option>
                    <option value="organizationtools">Organization Tools</option>
                    <option value="storagecontainer">Storage Containers</option>
                    <option value="cutting&amp;gluingtools">Cutting &amp; Gluing Tools</option>
                    <option value="technologysupplies">Technology Supplies</option>
                    <option value="office/schoolequipment">Office/School Equipment</option>
                    <option value="miscellaneoussupplies">Miscellaneous Supplies</option>
                    <option value="health&amp;safety">Health &amp; Safety</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_material" class="block text-sm font-medium text-gray-700">Material</label>
                <select name="material" id="add_material" class="w-full p-2 border rounded-md" required>
                    <option value="Registrar's Office">Auto Selected Based on selected  category</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="add_material" class="block text-sm font-medium text-gray-700">Variety</label>
                <select name="material" id="add_variety" class="w-full p-2 border rounded-md" required>
                    <option value="Registrar's Office">Auto Selected Based on selected  material</option>
                </select>
            </div>



            <div class="mb-4">
                <label for="add_supplier_name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                <input type="text" id="add_supplier_name" name="supplier_name" class="w-full p-2 border rounded-md" required>
            </div>

        
            <div class="mb-4">
                <label for="add_supplier_company" class="block text-sm font-medium text-gray-700">Supplier Company</label>
                <input type="text" id="add_supplier_company" name="supplier_company" class="w-full p-2 border rounded-md" required>
            </div>

          

            <div class="flex justify-end gap-2">
                <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel Request</button>
                <button id="btnCreateRequest" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Submit Request</button>
            </div>
        </form>
    </div>
</div>



<script>

$(document).ready(function () {
    function fetchSuggestions(query) {
    if (query.length >= 1) { 
        $.ajax({
            url: "backend/end-points/employee_list.php",
            type: "POST",
            dataType: "json",
            data: { query: query },
            success: function(data) {
                if (!Array.isArray(data) || data.length === 0) {
                    $("#employeeSuggestions").hide();
                    return;
                }

                console.log("Received Data:", data);
                let suggestions = data.map(user => `
                    <div class='suggestion-item p-2 hover:bg-gray-200 cursor-pointer' 
                         data-id='${user.id}' 
                         data-generated_id='${user.generated_id}' 
                         data-designation='${user.designation}' 
                         data-fullname='${user.fullname}'>
                         ${user.fullname} - ${user.designation}
                    </div>`).join("");

                $("#employeeSuggestions").html(suggestions).show();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#employeeSuggestions").hide();
            }
        });
    } else {
        $("#employeeSuggestions").hide();
    }
}

$("#search_user_fullname").on("input", function() {
    let query = $(this).val().trim(); // Trim whitespace
    console.log("User Input:", query);
    fetchSuggestions(query);
});


$(document).on("click", ".suggestion-item", function() {
    let id = $(this).data("id");
    let generated_id = $(this).data("generated_id");
    let selectedfullname = $(this).data("fullname");
    let selectedgenerated_id = $(this).data("generated_id");
    let selecteddesignation = $(this).data("designation");

    $("#search_user_fullname").val(selectedfullname);
    $("#add_user_id").val(id);
    $("#add_user_generated_id").val(selectedgenerated_id);
    $("#add_user_designation").val(selecteddesignation);
    $("#employeeSuggestions").hide();
});


$(document).click(function(e) {
    if (!$(e.target).closest("#stock_in_prod_code, #employeeSuggestions").length) {
        $("#employeeSuggestions").hide();
    }
});





    // SEARCH FUNTIONALITIES
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#userTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>


<?php include "components/footer.php";?>
<script src="assets/js/category_generated.js"></script>