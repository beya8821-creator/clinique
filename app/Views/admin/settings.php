<?php
use App\Helpers\Security;
use App\Helpers\Url;
$settings = array_column($db->query('SELECT `key`, `value` FROM settings')->fetchAll(), 'value', 'key');
$seoRows = $db->query('SELECT * FROM seo ORDER BY page_slug')->fetchAll();
?>
<form method="post" action="<?= Security::e(Url::admin('action=save-settings')) ?>" class="stack">
  <?= Security::csrfField() ?>
  <section class="panel stack">
    <h2>Website Settings</h2>
    <?php foreach (['site_name','contact_email','contact_phone','address','footer_text','meta_title','meta_description','meta_keywords'] as $key): ?>
      <label><?= Security::e(ucwords(str_replace('_', ' ', $key))) ?><input name="settings[<?= Security::e($key) ?>]" value="<?= Security::e($settings[$key] ?? '') ?>"></label>
    <?php endforeach; ?>
  </section>
  <section class="panel stack">
    <h2>SEO</h2>
    <?php foreach ($seoRows as $seo): ?>
      <fieldset class="panel stack">
        <legend><?= Security::e($seo['page_slug']) ?></legend>
        <input name="seo[<?= Security::e($seo['page_slug']) ?>][meta_title]" value="<?= Security::e($seo['meta_title']) ?>" placeholder="Meta title">
        <textarea name="seo[<?= Security::e($seo['page_slug']) ?>][meta_description]" placeholder="Meta description"><?= Security::e($seo['meta_description']) ?></textarea>
        <input name="seo[<?= Security::e($seo['page_slug']) ?>][keywords]" value="<?= Security::e($seo['keywords']) ?>" placeholder="Keywords">
        <input name="seo[<?= Security::e($seo['page_slug']) ?>][robots]" value="<?= Security::e($seo['robots']) ?>" placeholder="Robots">
      </fieldset>
    <?php endforeach; ?>
  </section>
  <button>Save settings</button>
</form>
