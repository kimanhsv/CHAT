<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$rows = $pdo->query('SELECT c.*, u.email FROM chats c LEFT JOIN users u ON u.id = c.user_id ORDER BY c.created_at DESC LIMIT 500')->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<h2>Chat History</h2>
<table class="table table-sm">
  <thead><tr><th>ID</th><th>User</th><th>Message</th><th>Response</th><th>Model</th><th>When</th></tr></thead>
  <tbody>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?php echo $r['id']; ?></td>
        <td><?php echo htmlspecialchars($r['email']); ?></td>
        <td><?php echo htmlspecialchars(substr($r['message'],0,200)); ?></td>
        <td><?php echo htmlspecialchars(substr($r['response'],0,200)); ?></td>
        <td><?php echo $r['model_id']; ?></td>
        <td><?php echo $r['created_at']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../templates/footer.php'; ?>