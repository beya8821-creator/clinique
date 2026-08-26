<?php
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

$services = CmsContentRepository::services(false);
$search = trim((string) ($_GET['q'] ?? ''));
if ($search !== '') {
    $services = array_values(array_filter($services, static fn (array $item): bool => stripos((string) $item['title'], $search) !== false || stripos((string) $item['description'], $search) !== false));
}
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$totalPages = max(1, (int) ceil(count($services) / $perPage));
$page = min($page, $totalPages);
$servicesPage = array_slice($services, ($page - 1) * $perPage, $perPage);
$edit = isset($_GET['id']) ? CmsContentRepository::service((int) $_GET['id']) : null;
$service = $edit ?? ['id' => '', 'title' => '', 'slug' => '', 'description' => '', 'image_path' => 'assets/img/health/cardiology-2.webp', 'icon_class' => 'fas fa-heartbeat', 'button_text' => 'Learn More', 'button_url' => 'service-details.html', 'features_text' => '', 'sort_order' => 0, 'is_active' => 1];
?>
<form method="post" action="<?= Security::e(Url::admin('action=save-service')) ?>" enctype="multipart/form-data" class="border rounded p-3 mb-4">
  <?= Security::csrfField() ?>
  <input type="hidden" name="id" value="<?= Security::e($service['id'] ?? '') ?>">
  <h4><?= $edit ? 'Edit service' : 'Add service' ?></h4>
  <div class="form-row">
    <div class="form-group col-md-6"><label>Title</label><input class="form-control" name="title" required value="<?= Security::e($service['title'] ?? '') ?>"></div>
    <div class="form-group col-md-6"><label>Slug</label><input class="form-control" name="slug" value="<?= Security::e($service['slug'] ?? '') ?>"></div>
  </div>
  <div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="3" required><?= Security::e($service['description'] ?? '') ?></textarea></div>
  <div class="form-row">
    <div class="form-group col-md-4"><label>Image path</label><input class="form-control" name="image_path" value="<?= Security::e($service['image_path'] ?? '') ?>"></div>
    <div class="form-group col-md-4"><label>Icon class</label><input class="form-control" name="icon_class" value="<?= Security::e($service['icon_class'] ?? '') ?>"></div>
    <div class="form-group col-md-4"><label>Order</label><input class="form-control" type="number" name="sort_order" value="<?= Security::e($service['sort_order'] ?? 0) ?>"></div>
  </div>
  <?php if (!empty($service['image_path'])): ?>
    <div class="mb-3"><img src="<?= Security::e(Url::asset((string) $service['image_path'])) ?>" alt="" style="max-width:160px;height:auto;border-radius:4px"></div>
  <?php endif; ?>
  <div class="form-group"><label>Upload image</label><input class="form-control-file" type="file" name="image_file" accept=".jpg,.jpeg,.png,.gif,.svg,.webp"></div>
  <div class="form-row">
    <div class="form-group col-md-6"><label>Button text</label><input class="form-control" name="button_text" value="<?= Security::e($service['button_text'] ?? '') ?>"></div>
    <div class="form-group col-md-6"><label>Button link</label><input class="form-control" name="button_url" value="<?= Security::e($service['button_url'] ?? '') ?>"></div>
  </div>
  <div class="form-group"><label>Features, one per line</label><textarea class="form-control" name="features_text" rows="3"><?= Security::e($service['features_text'] ?? '') ?></textarea></div>
  <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= (int) ($service['is_active'] ?? 1) === 1 ? 'checked' : '' ?>><label class="form-check-label" for="is_active">Active</label></div>
  <button class="btn btn-primary">Save service</button>
  <?php if ($edit): ?><a class="btn btn-secondary" href="<?= Security::e(Url::admin('action=cms-services')) ?>">Cancel</a><?php endif; ?>
</form>

<form method="get" class="form-inline mb-3">
  <input type="hidden" name="action" value="cms-services">
  <input class="form-control mr-2" name="q" value="<?= Security::e($search) ?>" placeholder="Search services">
  <button class="btn btn-secondary">Search</button>
</form>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead><tr><th>Order</th><th>Title</th><th>Image</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($servicesPage as $item): ?>
        <tr>
          <td><?= Security::e($item['sort_order']) ?></td>
          <td><?= Security::e($item['title']) ?></td>
          <td><?= Security::e($item['image_path']) ?></td>
          <td><?= ((int) $item['is_active'] === 1) ? 'Active' : 'Hidden' ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="<?= Security::e(Url::admin('action=cms-services&id=' . (int) $item['id'])) ?>">Edit</a>
            <form method="post" action="<?= Security::e(Url::admin('action=delete-service')) ?>" style="display:inline" onsubmit="return confirm('Delete this service?')">
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
<?php if ($totalPages > 1): ?>
  <nav>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item<?= $i === $page ? ' active' : '' ?>"><a class="page-link" href="<?= Security::e(Url::admin('action=cms-services&q=' . urlencode($search) . '&page=' . $i)) ?>"><?= $i ?></a></li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>
