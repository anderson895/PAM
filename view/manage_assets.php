


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Assets</h2>
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
    <button id="addAssetsButton" class="bg-red-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-red-600 transition duration-300 mb-4">
        <span class="material-icons mr-2 text-base">add</span>
        Add Assets
    </button>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">QRcode</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Asset ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Subcategory</th>
                    <th class="p-3">Condition</th>
                    <th class="p-3">Office</th>
                    <th class="p-3">Purchase Date</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Status</th>
                    
                    
                    <?php if ($On_Session[0]['role'] == "Administrator") {
                        echo '<th class="p-3">Action</th>';
                    } ?>
                </tr>
            </thead>
            <tbody>
            <?php include "backend/end-points/assets_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>






<!-- Modal for Adding Promo -->
<div id="addAssetsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-[40rem] max-h-[80vh] overflow-y-auto p-6"> 
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Assets</h3>
        <form id="addAssetFrm" >
            
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            


            <div class="mb-4">
                <label for="add_assets_img" class="block text-sm font-medium text-gray-700">Assets Image</label>
                <input type="file" id="add_assets_img" name="assets_img" class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="add_assets_code" class="block text-sm font-medium text-gray-700">Asset ID</label>
                <input type="text" id="add_assets_code" name="assets_code" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="add_assets_name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="add_assets_name" name="assets_name" class="w-full p-2 border rounded-md" required>
            </div>

            
            <div class="mb-4">
                <label for="add_assets_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="add_assets_description" name="assets_description" class="w-full p-2 border rounded-md" rows="2"></textarea>
            </div>


            <div class="mb-4">
                <label for="add_assets_price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" id="add_assets_price" name="assets_price" class="w-full p-2 border rounded-md" required>
            </div>




            <div class="mb-4">
                <label for="add_assets_Office" class="block text-sm font-medium text-gray-700">Office</label>
                <select name="assets_Office" id="add_assets_Office" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Office</option>
                    <?php 
                        $fetch_all_subcategory = $db->fetch_all_office();
                        if ($fetch_all_subcategory->num_rows > 0): 
                            while ($subcategory = $fetch_all_subcategory->fetch_assoc()): 
                            ?>

                                <option value="<?=$subcategory['id']?>"><?=$subcategory['office_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_assets_category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="assets_category" id="add_assets_category" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Category</option>
                    <?php 
                        $fetch_all_category = $db->fetch_all_category();
                        if ($fetch_all_category->num_rows > 0): 
                            while ($category = $fetch_all_category->fetch_assoc()): 
                            ?>

                                <option value="<?=$category['id']?>"><?=$category['category_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_assets_subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
                <select name="assets_subcategory" id="add_assets_subcategory" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Subcategory</option>
                    <?php 
                        $fetch_all_subcategory = $db->fetch_all_subcategory();
                        if ($fetch_all_subcategory->num_rows > 0): 
                            while ($subcategory = $fetch_all_subcategory->fetch_assoc()): 
                            ?>

                                <option data-category_id="<?=$subcategory['category_id']?>" value="<?=$subcategory['id']?>"><?=$subcategory['subcategory_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_assets_condition" class="block text-sm font-medium text-gray-700">Condition</label>
                <select name="assets_condition" id="add_assets_condition" class="w-full p-2 border rounded-md" required>
                    <option value="New">New</option>
                    <option value="Good">Good</option>
                    <option value="Needs Repair">Needs Repair</option>
                    <option value="Damaged">Damaged</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_assets_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="assets_status" id="add_assets_status" class="w-full p-2 border rounded-md" required>
                    <option value="Available">Available</option>
                    <option value="Assigned">Assigned</option>
                    <option value="Under Maintenance">Under Maintenance</option>
                    <option value="Disposed">Disposed</option>
                </select>
            </div>

           


            <div class="mb-4">
                <label for="assets_variety_name" class="block text-sm font-medium text-gray-700">Variety Name</label>
                <input type="text" id="assets_variety_name" name="assets_variety_name" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="assets_variety_value" class="block text-sm font-medium text-gray-700">Variety Value</label>
                <div id="variety-values-container">
                    <input type="text" name="assets_variety_value[]" class="w-full p-2 mb-2 border rounded-md" required>
                </div>
                <button type="button" class="add-variety-value mt-2 text-blue-500">Add Another Variety Value</button>
            </div>



            <div class="flex justify-end gap-2">
                <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnAddAssets" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Add new</button>
            </div>
        </form>
    </div>
</div>





<!-- Modal for Updating Promo -->
<div id="updateAssetsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-[40rem] p-6"> <!-- Updated width -->
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Assets</h3>
        <form id="updateAssetFrm" >
            
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>


            <input hidden type="text" id="assets_id" name="assets_id">


            <div class="mb-4">
                <label for="update_assets_img" class="block text-sm font-medium text-gray-700">Assets Image</label>
                <input type="file" id="update_assets_img" name="assets_img" class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="update_assets_code" class="block text-sm font-medium text-gray-700">Asset ID</label>
                <input type="text" id="update_assets_code" name="assets_code" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_assets_name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="update_assets_name" name="assets_name" class="w-full p-2 border rounded-md" required>
            </div>

            
            <div class="mb-4">
                <label for="update_assets_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="update_assets_description" name="assets_description" class="w-full p-2 border rounded-md" rows="2"></textarea>
            </div>


            <div class="mb-4">
                <label for="update_assets_price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" id="update_assets_price" name="assets_price" class="w-full p-2 border rounded-md" required>
            </div>




            <div class="mb-4">
                <label for="update_assets_Office" class="block text-sm font-medium text-gray-700">Office</label>
                <select name="assets_Office" id="update_assets_Office" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Office</option>
                    <?php 
                        $fetch_all_subcategory = $db->fetch_all_office();
                        if ($fetch_all_subcategory->num_rows > 0): 
                            while ($subcategory = $fetch_all_subcategory->fetch_assoc()): 
                            ?>

                                <option value="<?=$subcategory['id']?>"><?=$subcategory['office_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="update_assets_category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="assets_category" id="update_assets_category" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Category</option>
                    <?php 
                        $fetch_all_category = $db->fetch_all_category();
                        if ($fetch_all_category->num_rows > 0): 
                            while ($category = $fetch_all_category->fetch_assoc()): 
                            ?>

                                <option value="<?=$category['id']?>"><?=$category['category_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="update_assets_subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
                <select name="assets_subcategory" id="update_assets_subcategory" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Subcategory</option>
                    <?php 
                        $fetch_all_subcategory = $db->fetch_all_subcategory();
                        if ($fetch_all_subcategory->num_rows > 0): 
                            while ($subcategory = $fetch_all_subcategory->fetch_assoc()): 
                            ?>

                                <option data-category_id="<?=$subcategory['category_id']?>" value="<?=$subcategory['id']?>"><?=$subcategory['subcategory_name']?></option>
                        
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No record found.</td>
                            </tr>
                        <?php endif; ?>
                </select>
            </div>


            <div class="mb-4">
                <label for="update_assets_condition" class="block text-sm font-medium text-gray-700">Condition</label>
                <select name="assets_condition" id="update_assets_condition" class="w-full p-2 border rounded-md" required>
                    <option value="New">New</option>
                    <option value="Good">Good</option>
                    <option value="Needs Repair">Needs Repair</option>
                    <option value="Damaged">Damaged</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="update_assets_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="assets_status" id="update_assets_status" class="w-full p-2 border rounded-md" required>
                    <option value="Available">Available</option>
                    <option value="Assigned">Assigned</option>
                    <option value="Under Maintenance">Under Maintenance</option>
                    <option value="Disposed">Disposed</option>
                </select>
            </div>


          <!-- Variety Section in the Form -->
            <div class="mb-4">
                <label for="update_assets_variety_name" class="block text-sm font-medium text-gray-700">Variety Name</label>
                <input type="text" id="update_assets_variety_name" name="assets_variety_name" class="w-full p-2 border rounded-md" readonly>
            </div>

            <div class="mb-4">
                <label for="update_assets_variety_values" class="block text-sm font-medium text-gray-700">Variety Values</label>
                <div id="update_assets_variety_values" class="update_assets_variety_values">
                    <!-- Existing variety values will be appended here -->
                </div>
                <button type="button" class="add-variety-value mt-2 p-2 bg-blue-500 text-white rounded-md">Add Variety</button>
            </div>




            <div class="flex justify-end gap-2">
                <button type="button" class="updateUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnUpdateAssets" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Update</button>
            </div>
        </form>
    </div>
</div>





<script>

$(document).ready(function () {

    $("#add_assets_category").change(function () {
        var selectedCategory = $(this).val(); 

        $("#add_assets_subcategory option").each(function () {
            var subcategoryCategoryId = $(this).data("category_id"); 

            if (!subcategoryCategoryId || subcategoryCategoryId == selectedCategory) {
                $(this).show(); 
            } else {
                $(this).hide(); 
            }
        });

        $("#add_assets_subcategory").val("");
    });
});


$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#userTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>







</div>



<?php include "components/footer.php";?>