<?php use App\Helpers\Security; $rows = $db->query('SELECT * FROM activity_logs ORDER BY id DESC LIMIT 200')->fetchAll(); ?>
<div class="table-wrap"><table><tr><th>Action</th><th>Description</th><th>IP</th><th>Date</th></tr>
<?php foreach ($rows as $row): ?><tr><td><?= Security::e($row['action']) ?></td><td><?= Security::e($row['description']) ?></td><td><?= Security::e($row['ip_address']) ?></td><td><?= Security::e($row['created_at']) ?></td></tr><?php endforeach; ?>
</table></div>
