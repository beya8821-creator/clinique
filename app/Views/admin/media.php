<?php use App\Helpers\Security; use App\Helpers\Url; $media = $db->query('SELECT * FROM media_library ORDER BY id DESC')->fetchAll(); ?>
<form method="post" action="<?= Security::e(Url::admin('action=upload-media')) ?>" enctype="multipart/form-data" class="border rounded p-3 mb-4">
  <?= Security::csrfField() ?>
  <div class="form-group">
    <label>Upload files</label>
    <input class="form-control-file" type="file" name="media[]" multiple accept=".jpg,.jpeg,.png,.gif,.svg,.webp,.pdf,.mp4,.webm,.mov">
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="add_to_hero_slider" id="add_to_hero_slider" checked>
    <label class="form-check-label" for="add_to_hero_slider">Add uploaded images to Hero Slider</label>
  </div>
  <button class="btn btn-primary">Upload media</button>
</form>
<div class="row">
  <?php foreach ($media as $item): ?>
    <div class="col-md-4 mb-4">
      <article class="border rounded p-3 h-100">
        <?php if (str_starts_with((string) $item['mime_type'], 'image/')): ?>
          <img src="<?= Security::e(Url::asset((string) $item['path'])) ?>" alt="<?= Security::e($item['original_name']) ?>" style="max-width:100%;height:140px;object-fit:cover;border-radius:4px">
        <?php else: ?>
          <p><strong><?= Security::e($item['mime_type']) ?></strong></p>
        <?php endif; ?>
        <p class="mt-2 mb-1"><?= Security::e($item['original_name']) ?></p>
        <input class="form-control form-control-sm mb-2" readonly value="<?= Security::e($item['path']) ?>">
        <form method="post" action="<?= Security::e(Url::admin('action=delete-media')) ?>" onsubmit="return confirm('Delete this media?')">
          <?= Security::csrfField() ?>
          <input type="hidden" name="id" value="<?= Security::e($item['id']) ?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </article>
    </div>
  <?php endforeach; ?>
</div>
