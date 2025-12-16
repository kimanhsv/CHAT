<?php
require_once __DIR__ . '/../config.php';
$pdo = get_pdo();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name = trim($_POST['name'] ?? '');
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
    if(strlen($password) < 6) $errors[] = 'Password too short';
    if(!$errors){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (email, password_hash, name) VALUES (?, ?, ?)');
        try{
            $stmt->execute([$email, $hash, $name]);
            header('Location: /auth/login.php');
            exit;
        }catch(Exception $e){
            $errors[] = 'Email already in use';
        }
    }
}
?>
<?php include __DIR__.'/../templates/header.php'; ?>
<h2>Register</h2>
<?php if($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post">
  <div class="mb-3"><label>Name</label><input class="form-control" name="name"></div>
  <div class="mb-3"><label>Email</label><input class="form-control" name="email" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password" required></div>
  <button class="btn btn-primary">Register</button>
</form>
<?php include __DIR__.'/../templates/footer.php'; ?>