<?php use App\Helpers\Security; $rows = $db->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll(); ?>
<div class="table-wrap"><table><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr>
<?php foreach ($rows as $row): ?><tr><td><?= Security::e($row['name']) ?></td><td><?= Security::e($row['email']) ?></td><td><?= Security::e($row['subject']) ?></td><td><?= Security::e($row['message']) ?></td><td><?= Security::e($row['created_at']) ?></td></tr><?php endforeach; ?>
</table></div>
