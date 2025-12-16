<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!check_csrf($_POST['csrf'] ?? '')){ $errors[] = 'Invalid CSRF'; }
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $config = $_POST['config'] ?? '';
    if(!$name) $errors[] = 'Name required';
    if(!$errors){
        $stmt = $pdo->prepare('INSERT INTO models (name, description, config) VALUES (?, ?, ?)');
        $stmt->execute([$name, $description, $config ?: null]);
        header('Location: models.php'); exit;
    }
}
include __DIR__ . '/../templates/header.php';
?>
<h2>Create Model</h2>
<?php if($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <div class="mb-3"><label>Name</label><input class="form-control" name="name" required></div>
  <div class="mb-3"><label>Description</label><textarea class="form-control" name="description"></textarea></div>
  <div class="mb-3"><label>Config (JSON)</label><textarea class="form-control" name="config"></textarea></div>
  <button class="btn btn-primary">Create</button>
</form>
<?php include __DIR__ . '/../templates/footer.php'; ?>