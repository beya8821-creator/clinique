<?php
use App\Helpers\Security;
use App\Helpers\Url;
$currentAction = $_GET['action'] ?? 'dashboard';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= Security::e($title) ?> - Global Hospitals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= Security::e(Url::asset('admin/assets/hms-style.css')) ?>">
</head>
<body style="padding-top: 70px; background: -webkit-linear-gradient(left, #3931af, #00c6ff); background-size: cover;">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="<?= Security::e(Url::admin()) ?>" style="font-family: 'IBM Plex Sans', sans-serif;">
      <h4><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp; GLOBAL HOSPITALS</h4>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-3">
          <form method="post" action="<?= Security::e(Url::admin('action=logout')) ?>" class="form-inline">
            <?= Security::csrfField() ?>
            <button type="submit" class="btn btn-outline-light">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid" style="margin-top:50px;">
  <div class="row">
    <div class="col-md-3" style="max-width:25%; margin-top: 3%">
      <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action<?= $currentAction === 'dashboard' ? ' active' : '' ?>" href="<?= Security::e(Url::admin()) ?>">Dashboard</a>
        <span class="list-group-item font-weight-bold">Content</span>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'cms-home' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=cms-home')) ?>">&nbsp;&nbsp;Home</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'hero-slider' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=hero-slider')) ?>">&nbsp;&nbsp;Hero Slider</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'cms-about' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=cms-about')) ?>">&nbsp;&nbsp;About</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'cms-services' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=cms-services')) ?>">&nbsp;&nbsp;Services</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'cms-contact' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=cms-contact')) ?>">&nbsp;&nbsp;Contact</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'media' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=media')) ?>">Media</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'settings' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=settings')) ?>">Settings</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'pages' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=pages')) ?>">Advanced HTML</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'messages' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=messages')) ?>">Messages</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'appointments' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=appointments')) ?>">Appointments</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'newsletter' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=newsletter')) ?>">Newsletter</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'users' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=users')) ?>">Users</a>
        <a class="list-group-item list-group-item-action<?= $currentAction === 'activity' ? ' active' : '' ?>" href="<?= Security::e(Url::admin('action=activity')) ?>">Activity logs</a>
      </div><br>
    </div>
    <div class="col-md-9" style="margin-top: 3%;">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title" style="font-family: 'IBM Plex Sans', sans-serif;"><?= Security::e($title) ?></h2>
          <?= $body ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
