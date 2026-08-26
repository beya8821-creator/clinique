<?php
use App\Helpers\Security;
use App\Helpers\Url;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Global Hospitals Admin Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= Security::e(Url::asset('admin/assets/hms-style.css')) ?>">
</head>
<body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff); background-size: cover;">
  <div class="container-fluid" style="margin-top:60px;margin-bottom:60px;color:#34495E;">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card" style="font-family: 'IBM Plex Sans', sans-serif;">
          <div class="card-body">
            <div class="text-center mb-4">
              <i class="fa fa-hospital-o fa-3x" aria-hidden="true" style="color:#0062cc"></i>
              <h3 class="mt-3">Admin Login</h3>
            </div>
            <?php if (!empty($_SESSION['flash'])): ?>
              <div class="alert alert-danger" role="alert"><?= Security::e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
            <?php endif; ?>
            <form method="post" action="<?= Security::e(Url::admin('action=login')) ?>">
              <?= Security::csrfField() ?>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
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
