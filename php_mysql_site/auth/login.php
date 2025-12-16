<?php
require_once __DIR__ . '/../config.php';

$pdo = get_pdo();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if($user && password_verify($password, $user['password_hash'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: /chat.php');
        exit;
    } else {
        $errors[] = 'Invalid credentials';
    }
}
?>
<?php include __DIR__.'/../templates/header.php'; ?>
<h2>Login</h2>
<?php if($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post">
  <div class="mb-3"><label>Email</label><input class="form-control" name="email" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password" required></div>
  <button class="btn btn-primary">Login</button>
</form>
<?php include __DIR__.'/../templates/footer.php'; ?>