<?php 
                $fetch_all_user = $db->fetch_all_request();
                if ($fetch_all_user->num_rows > 0): 
                    $count=1;
                    while ($user = $fetch_all_user->fetch_assoc()): ?>
                        <tr>
                            <td class="p-2"><?php echo $count++; ?></td>
                        
                            <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['user_fullname'])); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['generated_id'])); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['user_designation']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['asset_name']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_qty']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_date']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_supplier_name']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_supplier_company']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_status']); ?></td>
                           
                            <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                                <td class="p-2 text-center">
                                    <select class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
                                            data-request_id="<?= htmlspecialchars($user['request_id']) ?>"
                                            aria-label="Select User Status">
                                        <!-- Only show Pending if status is not Delivered -->
                                        <?php if ($user['request_status'] != 'Delivered') { ?>
                                            <option value="" <?= !$user['request_status'] ? 'selected' : '' ?>>Pending</option>
                                        <?php } ?>
                                        <!-- Only show Approve if status is not Delivered -->
                                        <?php if ($user['request_status'] != 'Delivered') { ?>
                                            <option value="Approve" <?= $user['request_status'] == 'Approve' ? 'selected' : '' ?>>Approve</option>
                                        <?php } ?>
                                        <!-- Only show Ongoing if status is not Delivered -->
                                        <?php if ($user['request_status'] != 'Delivered') { ?>
                                            <option value="Ongoing" <?= $user['request_status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                        <?php } ?>
                                        <!-- Always show Delivered -->
                                        <option value="Delivered" <?= $user['request_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                        <!-- Only show Decline if status is not Delivered -->
                                        <?php if ($user['request_status'] != 'Delivered') { ?>
                                            <option value="Decline" class="text-red-500" <?= $user['request_status'] == 'Decline' ? 'selected' : '' ?>>Decline</option>
                                        <?php } ?>
                                    </select>
                                </td>
                            <?php } ?>



                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>