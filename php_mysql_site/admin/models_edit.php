<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM models WHERE id = ?');
$stmt->execute([$id]);
$model = $stmt->fetch();
if(!$model){ header('Location: models.php'); exit; }
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!check_csrf($_POST['csrf'] ?? '')){ $errors[] = 'Invalid CSRF'; }
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $config = $_POST['config'] ?? '';
    if(!$name) $errors[] = 'Name required';
    if(!$errors){
        $stmt = $pdo->prepare('UPDATE models SET name = ?, description = ?, config = ? WHERE id = ?');
        $stmt->execute([$name, $description, $config ?: null, $id]);
        header('Location: models.php'); exit;
    }
}
include __DIR__ . '/../templates/header.php';
?>
<h2>Edit Model</h2>
<?php if($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <div class="mb-3"><label>Name</label><input class="form-control" name="name" value="<?php echo htmlspecialchars($model['name']); ?>" required></div>
  <div class="mb-3"><label>Description</label><textarea class="form-control" name="description"><?php echo htmlspecialchars($model['description']); ?></textarea></div>
  <div class="mb-3"><label>Config (JSON)</label><textarea class="form-control" name="config"><?php echo htmlspecialchars($model['config']); ?></textarea></div>
  <button class="btn btn-primary">Save</button>
</form>
<?php include __DIR__ . '/../templates/footer.php'; ?>