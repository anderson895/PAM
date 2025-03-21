<?php 

$fetch_all_user = $db->fetch_all_user();
$count = 1; // Initialize count

if ($fetch_all_user->num_rows > 0): ?>
    <?php foreach ($fetch_all_user as $user): ?>
        <tr>
            <td class="p-2"><?php echo htmlspecialchars($user['generated_id']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['profile_picture']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['fullname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['nickname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['email']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['role']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['created_at']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['designation']); ?></td>
           
        <?php  if($On_Session[0]['role']=="Administrator"){?>
            <td class="p-2">
                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUserAdmin" 
                data-id="<?= htmlspecialchars($user['id']) ?>"
                data-fullname="<?= htmlspecialchars($user['fullname']) ?>"
                data-nickname="<?= htmlspecialchars($user['nickname']) ?>"
                data-role="<?= htmlspecialchars($user['role']) ?>"
                data-email="<?= htmlspecialchars($user['email']) ?>"
                data-designation="<?= htmlspecialchars($user['designation']) ?>"
                >Update</button>

                <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteUserAdmin" 
                data-id="<?= htmlspecialchars($user['id']) ?>">Remove</button>
            </td>
        <?php }?>

        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="p-2 text-center">No record found.</td>
    </tr>
<?php endif; ?>