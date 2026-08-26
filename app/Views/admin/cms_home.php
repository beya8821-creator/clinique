<?php
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

$defaults = [
    'hero' => ['label' => 'Hero', 'title' => 'Excellence en Soins de santé Donné avec plus compassions', 'subtitle' => '', 'body' => "une clinique humanitaire d'inspiration qui place la dignité humaine au cœur de son engagement. Elle offre des soins de santé accessibles, de qualité et empreints de compassion.", 'button_text' => 'Prendre rendez-vous', 'button_url' => 'appointment.html', 'image_path' => 'assets/img/health/staff-10.webp', 'video_url' => 'https://'],
    'about' => ['label' => 'Home About', 'title' => 'Soins Bienveillants,', 'subtitle' => 'Depuis un an, nous nous engageons à fournir des soins de santé exceptionnels qui Allie technologie médicale de pointe avec la touche personnelle que nos patients méritent.', 'body' => 'Notre équipe multidisciplinaire de spécialistes travaille en collaboration pour garantir que chaque patient reçoit des soins complets adaptés à leurs besoins spécifiques.', 'button_text' => 'Apprendre plus sur nous', 'button_url' => 'about.html', 'image_path' => 'assets/img/health/facilities-9.webp', 'video_url' => ''],
    'cta' => ['label' => 'CTA', 'title' => "L'excellence dans les soins, quotidien", 'subtitle' => '', 'body' => "Choisir notre établissement, c'est confier votre santé à une équipe de professionnels passionnés, guidés par la bienveillance, l'éthique et l'excellence médicale.", 'button_text' => 'Programmer une consultation', 'button_url' => 'contact.php', 'image_path' => 'assets/img/health/facilities-9.webp', 'video_url' => ''],
];
?>
<?php foreach ($defaults as $key => $fallback): $section = array_merge($fallback, CmsContentRepository::section('home', $key) ?? []); ?>
  <form method="post" action="<?= Security::e(Url::admin('action=save-cms-section')) ?>" enctype="multipart/form-data" class="border rounded p-3 mb-4">
    <?= Security::csrfField() ?>
    <input type="hidden" name="page_slug" value="home">
    <input type="hidden" name="section_key" value="<?= Security::e($key) ?>">
    <input type="hidden" name="label" value="<?= Security::e($fallback['label']) ?>">
    <h4><?= Security::e($fallback['label']) ?></h4>
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="<?= Security::e($section['title'] ?? '') ?>"></div>
    <div class="form-group"><label>Subtitle</label><textarea class="form-control" name="subtitle" rows="2"><?= Security::e($section['subtitle'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Description</label><textarea class="form-control" name="body" rows="4"><?= Security::e($section['body'] ?? '') ?></textarea></div>
    <div class="form-row">
      <div class="form-group col-md-6"><label>Button text</label><input class="form-control" name="button_text" value="<?= Security::e($section['button_text'] ?? '') ?>"></div>
      <div class="form-group col-md-6"><label>Button link</label><input class="form-control" name="button_url" value="<?= Security::e($section['button_url'] ?? '') ?>"></div>
    </div>
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
