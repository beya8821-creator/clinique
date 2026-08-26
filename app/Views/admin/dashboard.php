<?php
use App\Helpers\Security;
use App\Helpers\Url;

$stats = [
    'Pages' => $db->query('SELECT COUNT(*) FROM pages')->fetchColumn(),
    'Messages' => $db->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn(),
    'Appointments' => $db->query('SELECT COUNT(*) FROM appointments')->fetchColumn(),
    'Media' => $db->query('SELECT COUNT(*) FROM media_library')->fetchColumn(),
];
$userName = current_admin_user()['name'] ?? 'Administrator';
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <h3>Welcome back, <?= Security::e($userName) ?></h3>
      <p>Manage pages, media, messages, appointments, newsletter and users from the Global Hospitals admin experience.</p>
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card text-center h-100 shadow-sm">
            <div class="card-body">
              <i class="fa fa-calendar fa-2x text-primary"></i>
              <h5 class="mt-3">Appointments</h5>
              <p class="display-4 mb-0"><?= Security::e($stats['Appointments']) ?></p>
              <a href="<?= Security::e(Url::admin('action=appointments')) ?>" class="btn btn-link">View</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card text-center h-100 shadow-sm">
            <div class="card-body">
              <i class="fa fa-file-text fa-2x text-primary"></i>
              <h5 class="mt-3">Pages</h5>
              <p class="display-4 mb-0"><?= Security::e($stats['Pages']) ?></p>
              <a href="<?= Security::e(Url::admin('action=pages')) ?>" class="btn btn-link">Edit</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card text-center h-100 shadow-sm">
            <div class="card-body">
              <i class="fa fa-image fa-2x text-primary"></i>
              <h5 class="mt-3">Media</h5>
              <p class="display-4 mb-0"><?= Security::e($stats['Media']) ?></p>
              <a href="<?= Security::e(Url::admin('action=media')) ?>" class="btn btn-link">Upload</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">
          Quick actions
        </div>
        <div class="card-body">
          <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
            <a href="<?= Security::e(Url::admin('action=pages')) ?>" class="btn btn-primary flex-fill">Edit pages</a>
            <a href="<?= Security::e(Url::admin('action=media')) ?>" class="btn btn-primary flex-fill">Upload media</a>
            <a href="<?= Security::e(Url::admin('action=settings')) ?>" class="btn btn-primary flex-fill">Settings</a>
          </div>
        </div>
      </div>
      <div class="card shadow-sm mt-3">
        <div class="card-header">System notes</div>
        <div class="card-body">
          <p>Use phpMyAdmin or mysqldump with the `.env` credentials to export the database.</p>
          <p>Session and login are managed by the existing Polyclinique Yetu CMS admin flow.</p>
        </div>
      </div>
    </div>
  </div>
</div>
