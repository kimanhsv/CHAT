<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$models = $pdo->query('SELECT * FROM models ORDER BY created_at DESC')->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<h2>Model Management</h2>
<p><a class="btn btn-sm btn-success" href="/admin/models_create.php">Create new model</a></p>
<table class="table">
  <thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Created</th><th>Actions</th></tr></thead>
  <tbody>
    <?php foreach($models as $m): ?>
      <tr>
        <td><?php echo $m['id']; ?></td>
        <td><?php echo htmlspecialchars($m['name']); ?></td>
        <td><?php echo htmlspecialchars($m['description']); ?></td>
        <td><?php echo $m['created_at']; ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="/admin/models_edit.php?id=<?php echo $m['id']; ?>">Edit</a>
          <form method="post" action="/admin/models_delete.php" style="display:inline" onsubmit="return confirm('Delete model?');">
            <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
            <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../templates/footer.php'; ?>