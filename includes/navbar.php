<?php
$currentPage = $currentPage ?? '';
$links = [
    ['label' => 'Home', 'url' => 'index.php', 'slug' => 'index'],
    ['label' => 'About', 'url' => 'about.php', 'slug' => 'about'],
    ['label' => 'Services', 'url' => 'services.php', 'slug' => 'services'],
    ['label' => 'Contact', 'url' => 'contact.php', 'slug' => 'contact'],
];
?>
<nav id="navmenu" class="navmenu">
  <ul>
    <?php foreach ($links as $link): ?>
      <li><a href="<?= $link['url'] ?>" class="<?= $currentPage === $link['slug'] ? 'active' : '' ?>"><?= $link['label'] ?></a></li>
    <?php endforeach; ?>
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
