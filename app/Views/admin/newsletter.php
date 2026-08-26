<?php use App\Helpers\Security; $rows = $db->query('SELECT * FROM newsletter ORDER BY id DESC')->fetchAll(); ?>
<div class="table-wrap"><table><tr><th>Email</th><th>Active</th><th>Date</th></tr>
<?php foreach ($rows as $row): ?><tr><td><?= Security::e($row['email']) ?></td><td><?= Security::e($row['is_active']) ?></td><td><?= Security::e($row['created_at']) ?></td></tr><?php endforeach; ?>
</table></div>
