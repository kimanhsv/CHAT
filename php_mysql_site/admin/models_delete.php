<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!check_csrf($_POST['csrf'] ?? '')){ die('Invalid CSRF'); }
    $id = intval($_POST['id'] ?? 0);
    $stmt = $pdo->prepare('DELETE FROM models WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: models.php');
exit;