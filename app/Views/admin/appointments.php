<?php use App\Helpers\Security; $rows = $db->query('SELECT * FROM appointments ORDER BY id DESC')->fetchAll(); ?>
<div class="table-wrap"><table><tr><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Department</th><th>Doctor</th><th>Message</th></tr>
<?php foreach ($rows as $row): ?><tr><td><?= Security::e($row['name']) ?></td><td><?= Security::e($row['email']) ?></td><td><?= Security::e($row['phone']) ?></td><td><?= Security::e($row['appointment_date']) ?></td><td><?= Security::e($row['appointment_time']) ?></td><td><?= Security::e($row['department']) ?></td><td><?= Security::e($row['doctor']) ?></td><td><?= Security::e($row['message']) ?></td></tr><?php endforeach; ?>
</table></div>
