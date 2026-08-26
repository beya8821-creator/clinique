<?php
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

$slides = CmsContentRepository::heroSlides(false);
$edit = isset($_GET['id']) ? CmsContentRepository::heroSlide((int) $_GET['id']) : null;
$slide = $edit ?? [
    'id' => '',
    'image' => '',
    'title' => '',
    'subtitle' => '',
    'button_text' => '',
    'button_link' => '',
    'display_order' => count($slides) + 1,
    'status' => 1,
];
?>
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="alert alert-danger"><?= Security::e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
<?php endif; ?>

<form method="post" action="<?= Security::e(Url::admin('action=save-hero-slide')) ?>" enctype="multipart/form-data" class="border rounded p-3 mb-4">
  <?= Security::csrfField() ?>
  <input type="hidden" name="id" value="<?= Security::e($slide['id'] ?? '') ?>">
  <h4><?= $edit ? 'Edit hero slide' : 'Add hero slide' ?></h4>
  <div class="form-row">
    <div class="form-group col-md-8">
      <label>Image path</label>
      <input class="form-control" name="image" value="<?= Security::e($slide['image'] ?? '') ?>">
    </div>
    <div class="form-group col-md-4">
      <label>Order</label>
      <input class="form-control" type="number" name="display_order" value="<?= Security::e($slide['display_order'] ?? 0) ?>">
    </div>
  </div>
  <?php if (!empty($slide['image'])): ?>
    <div class="mb-3"><img src="<?= Security::e(Url::asset((string) $slide['image'])) ?>" alt="" style="max-width:220px;height:130px;object-fit:cover;border-radius:4px"></div>
  <?php endif; ?>
  <div class="form-group">
    <label>Upload image</label>
    <input class="form-control-file" type="file" name="image_file" accept=".jpg,.jpeg,.png,.gif,.svg,.webp">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6"><label>Optional title</label><input class="form-control" name="title" value="<?= Security::e($slide['title'] ?? '') ?>"></div>
    <div class="form-group col-md-6"><label>Optional subtitle</label><input class="form-control" name="subtitle" value="<?= Security::e($slide['subtitle'] ?? '') ?>"></div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6"><label>Optional button text</label><input class="form-control" name="button_text" value="<?= Security::e($slide['button_text'] ?? '') ?>"></div>
    <div class="form-group col-md-6"><label>Optional button link</label><input class="form-control" name="button_link" value="<?= Security::e($slide['button_link'] ?? '') ?>"></div>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="status" id="status" <?= (int) ($slide['status'] ?? 1) === 1 ? 'checked' : '' ?>>
    <label class="form-check-label" for="status">Active</label>
  </div>
  <button class="btn btn-primary">Save slide</button>
  <?php if ($edit): ?><a class="btn btn-secondary" href="<?= Security::e(Url::admin('action=hero-slider')) ?>">Cancel</a><?php endif; ?>
</form>

<form method="post" action="<?= Security::e(Url::admin('action=reorder-hero-slides')) ?>" id="hero-slider-order-form">
  <?= Security::csrfField() ?>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead><tr><th style="width:70px">Move</th><th>Preview</th><th>Image</th><th>Order</th><th>Status</th><th>Date added</th><th>Actions</th></tr></thead>
      <tbody id="hero-slider-rows">
        <?php foreach ($slides as $item): ?>
          <tr draggable="true" data-id="<?= Security::e($item['id']) ?>">
            <td><span class="btn btn-sm btn-light hero-drag-handle">Move</span></td>
            <td><img src="<?= Security::e(Url::asset((string) $item['image'])) ?>" alt="" style="width:90px;height:55px;object-fit:cover;border-radius:4px"></td>
            <td><input class="form-control form-control-sm" readonly value="<?= Security::e($item['image']) ?>"></td>
            <td><input class="form-control form-control-sm hero-order-input" type="number" name="orders[<?= Security::e($item['id']) ?>]" value="<?= Security::e($item['display_order']) ?>"></td>
            <td><?= ((int) $item['status'] === 1) ? 'Active' : 'Hidden' ?></td>
            <td><?= Security::e($item['created_at'] ?? '') ?></td>
            <td>
              <a class="btn btn-sm btn-primary" href="<?= Security::e(Url::admin('action=hero-slider&id=' . (int) $item['id'])) ?>">Edit</a>
              <form method="post" action="<?= Security::e(Url::admin('action=delete-hero-slide')) ?>" style="display:inline" onsubmit="return confirm('Delete this slide?')">
                <?= Security::csrfField() ?>
                <input type="hidden" name="id" value="<?= Security::e($item['id']) ?>">
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php if ($slides !== []): ?><button class="btn btn-secondary">Save order</button><?php endif; ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var tbody = document.getElementById('hero-slider-rows');
  if (!tbody) return;
  var dragged = null;
  tbody.querySelectorAll('tr[draggable="true"]').forEach(function (row) {
    row.addEventListener('dragstart', function () { dragged = row; });
    row.addEventListener('dragover', function (event) {
      event.preventDefault();
      if (!dragged || dragged === row) return;
      var rect = row.getBoundingClientRect();
      tbody.insertBefore(dragged, event.clientY - rect.top > rect.height / 2 ? row.nextSibling : row);
      tbody.querySelectorAll('.hero-order-input').forEach(function (input, index) { input.value = index + 1; });
    });
  });
});
</script>
