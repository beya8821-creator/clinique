<?php
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

$contact = CmsContentRepository::contact();
$fields = [
    'address_title' => 'Address title',
    'address' => 'Address',
    'phone' => 'Phone',
    'email_title' => 'Email title',
    'email_primary' => 'Primary email',
    'email_secondary' => 'Secondary email',
    'hours_title' => 'Hours title',
    'hours_primary' => 'Hours line 1',
    'hours_secondary' => 'Hours line 2',
    'form_title' => 'Form title',
    'form_intro' => 'Form intro',
    'map_embed_url' => 'Google Maps embed URL',
    'facebook_url' => 'Facebook',
    'instagram_url' => 'Instagram',
    'linkedin_url' => 'LinkedIn',
    'whatsapp_url' => 'WhatsApp',
];
?>
<form method="post" action="<?= Security::e(Url::admin('action=save-contact')) ?>" class="border rounded p-3">
  <?= Security::csrfField() ?>
  <div class="form-row">
    <?php foreach ($fields as $key => $label): ?>
      <div class="form-group <?= in_array($key, ['address', 'form_intro', 'map_embed_url'], true) ? 'col-md-12' : 'col-md-6' ?>">
        <label><?= Security::e($label) ?></label>
        <?php if (in_array($key, ['address', 'form_intro', 'map_embed_url'], true)): ?>
          <textarea class="form-control" name="contact[<?= Security::e($key) ?>]" rows="<?= $key === 'map_embed_url' ? '3' : '2' ?>"><?= Security::e($contact[$key] ?? '') ?></textarea>
        <?php else: ?>
          <input class="form-control" name="contact[<?= Security::e($key) ?>]" value="<?= Security::e($contact[$key] ?? '') ?>">
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-primary">Save contact</button>
</form>
