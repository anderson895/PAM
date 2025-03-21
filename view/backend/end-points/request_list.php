<?php 
                $fetch_all_user = $db->fetch_all_request();
                if ($fetch_all_user->num_rows > 0): 
                    $count=1;
                    while ($user = $fetch_all_user->fetch_assoc()): ?>
                        <tr>
                            <td class="p-2"><?php echo $count++; ?></td>
                        
                            <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['fullname'])); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['generated_id'])); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['designation']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_cat_item']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_date']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_supplier_name']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_supplier_company']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($user['request_status']); ?></td>
                           
                            <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                                <td class="p-2 text-center">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerRequest" 
                                        data-request_id="<?= htmlspecialchars($user['request_id']) ?>" 
                                        data-action="ApproveUser">
                                        Approve
                                    </button>
                                    <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerRequest" 
                                        data-request_id="<?= htmlspecialchars($user['request_id']) ?>" 
                                        data-action="DeclineUser">
                                        Decline
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