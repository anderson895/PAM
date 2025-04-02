<?php 
                $fetch_all_user = $db->fetch_all_assets();
                if ($fetch_all_user->num_rows > 0): 
                    $count = 1;
                    while ($user = $fetch_all_user->fetch_assoc()): 
                    ?>


                    <tr>
                        <td class="p-2"><?php echo $count++ ?></td>
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
                        <td class="p-2"><?php echo htmlspecialchars($user['quantity']); ?></td>
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
                                    data-quantity="<?= htmlspecialchars($user['quantity']) ?>"
                                    data-status="<?= htmlspecialchars($user['status']) ?>"
                                    data-price="<?= htmlspecialchars($user['price']) ?>"
                                    data-description="<?= htmlspecialchars($user['description']) ?>"
                                    data-variety="<?= htmlspecialchars($user['variety']) ?>"
                                   >
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