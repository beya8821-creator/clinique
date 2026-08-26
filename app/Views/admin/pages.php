<?php
use App\Helpers\Security;
use App\Helpers\Url;
$pages = $db->query('SELECT slug, title FROM pages ORDER BY title')->fetchAll();
$slug = $_GET['slug'] ?? ($pages[0]['slug'] ?? 'index');
$stmt = $db->prepare('SELECT * FROM pages WHERE slug = ? LIMIT 1');
$stmt->execute([$slug]);
$page = $stmt->fetch();
?>
<div class="grid">
  <section class="panel">
    <h2>Pages</h2>
    <div class="stack">
      <?php foreach ($pages as $item): ?>
        <a href="<?= Security::e(Url::admin('action=pages&slug=' . urlencode((string) $item['slug']))) ?>"><?= Security::e($item['title']) ?></a>
      <?php endforeach; ?>
    </div>
  </section>
  <section class="panel">
    <h2>Edit <?= Security::e($page['title'] ?? $slug) ?></h2>
    <form method="post" action="<?= Security::e(Url::admin('action=save-page')) ?>" class="stack">
      <?= Security::csrfField() ?>
      <input type="hidden" name="slug" value="<?= Security::e($slug) ?>">
      <textarea name="html_content"><?= Security::e($page['html_content'] ?? '') ?></textarea>
      <button>Save page HTML</button>
    </form>
  </section>
</div>
