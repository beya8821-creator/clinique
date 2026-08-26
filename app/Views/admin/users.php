<?php use App\Helpers\Security; use App\Helpers\Url; $users = $db->query('SELECT users.*, roles.name role_name FROM users JOIN roles ON roles.id = users.role_id ORDER BY users.id DESC')->fetchAll(); ?>
<form method="post" action="<?= Security::e(Url::admin('action=save-user')) ?>" class="panel stack">
  <?= Security::csrfField() ?>
  <input name="name" required placeholder="Name">
  <input name="email" type="email" required placeholder="Email">
  <input name="password" type="password" required placeholder="Password">
  <select name="role_id"><option value="1">Admin</option><option value="2">Editor</option></select>
  <button>Create user</button>
</form>
<div class="table-wrap" style="margin-top:16px"><table><?php foreach ($users as $row): ?><tr><td><?= Security::e($row['name']) ?></td><td><?= Security::e($row['email']) ?></td><td><?= Security::e($row['role_name']) ?></td></tr><?php endforeach; ?></table></div>
