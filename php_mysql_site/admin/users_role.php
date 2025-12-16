<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!check_csrf($_POST['csrf'] ?? '')){ die('Invalid CSRF'); }
    $id = intval($_POST['id'] ?? 0);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
    $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
    $stmt->execute([$role, $id]);
}
header('Location: users.php');
exit;