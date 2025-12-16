<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$users = $pdo->query('SELECT id, email, name, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<h2>User Management</h2>
<table class="table">
  <thead><tr><th>ID</th><th>Email</th><th>Name</th><th>Role</th><th>Created</th><th>Actions</th></tr></thead>
  <tbody>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['email']); ?></td>
        <td><?php echo htmlspecialchars($u['name']); ?></td>
        <td><?php echo $u['role']; ?></td>
        <td><?php echo $u['created_at']; ?></td>
        <td>
          <form method="post" action="/admin/users_role.php" style="display:inline">
            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
            <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
            <?php if($u['role'] === 'admin'): ?>
              <input type="hidden" name="role" value="user"><button class="btn btn-sm btn-warning">Demote</button>
            <?php else: ?>
              <input type="hidden" name="role" value="admin"><button class="btn btn-sm btn-success">Promote</button>
            <?php endif; ?>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../templates/footer.php'; ?>