<?php
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

$defaults = [
    'intro' => ['label' => 'Intro', 'title' => 'Compassionate Care for Every Family', 'subtitle' => 'For over two decades, we have been dedicated to providing exceptional healthcare services to our community.', 'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'button_text' => '', 'button_url' => '', 'image_path' => 'assets/img/health/facilities-6.webp', 'video_url' => ''],
    'values' => ['label' => 'Mission / Vision / Values', 'title' => 'Our Core Values', 'subtitle' => '', 'body' => 'These principles guide everything we do in our commitment to exceptional healthcare', 'button_text' => '', 'button_url' => '', 'image_path' => '', 'video_url' => ''],
];
?>
<?php foreach ($defaults as $key => $fallback): $section = array_merge($fallback, CmsContentRepository::section('about', $key) ?? []); ?>
  <form method="post" action="<?= Security::e(Url::admin('action=save-cms-section')) ?>" enctype="multipart/form-data" class="border rounded p-3 mb-4">
    <?= Security::csrfField() ?>
    <input type="hidden" name="page_slug" value="about">
    <input type="hidden" name="section_key" value="<?= Security::e($key) ?>">
    <input type="hidden" name="label" value="<?= Security::e($fallback['label']) ?>">
    <h4><?= Security::e($fallback['label']) ?></h4>
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="<?= Security::e($section['title'] ?? '') ?>"></div>
    <div class="form-group"><label>Mission / Lead text</label><textarea class="form-control" name="subtitle" rows="2"><?= Security::e($section['subtitle'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Description / Vision</label><textarea class="form-control" name="body" rows="4"><?= Security::e($section['body'] ?? '') ?></textarea></div>
    <div class="form-row">
      <div class="form-group col-md-6"><label>Image path</label><input class="form-control" name="image_path" value="<?= Security::e($section['image_path'] ?? '') ?>"></div>
      <div class="form-group col-md-6"><label>Video link</label><input class="form-control" name="video_url" value="<?= Security::e($section['video_url'] ?? '') ?>"></div>
    </div>
    <?php if (!empty($section['image_path'])): ?>
      <div class="mb-3"><img src="<?= Security::e(Url::asset((string) $section['image_path'])) ?>" alt="" style="max-width:160px;height:auto;border-radius:4px"></div>
    <?php endif; ?>
    <div class="form-row">
      <div class="form-group col-md-6"><label>Upload image</label><input class="form-control-file" type="file" name="image_file" accept=".jpg,.jpeg,.png,.gif,.svg,.webp"></div>
      <div class="form-group col-md-6"><label>Upload video</label><input class="form-control-file" type="file" name="video_file" accept=".mp4,.webm,.mov"></div>
    </div>
    <button class="btn btn-primary">Save <?= Security::e($fallback['label']) ?></button>
  </form>
<?php endforeach; ?>
