<?php
require_once __DIR__ . '/config.php';
require_login();
$pdo = get_pdo();
$user_id = $_SESSION['user_id'];

// Handle new message
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $message = trim($_POST['message'] ?? '');
    if($message !== ''){
        // For now, echo a simple automated response. In real app call AI/service.
        $response = 'Auto-reply: ' . substr($message, 0, 200);
        $stmt = $pdo->prepare('INSERT INTO chats (user_id, message, response) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $message, $response]);
    }
    header('Location: /chat.php');
    exit;
}

// Fetch last 50 messages for user
$stmt = $pdo->prepare('SELECT * FROM chats WHERE user_id = ? ORDER BY created_at DESC LIMIT 50');
$stmt->execute([$user_id]);
$rows = array_reverse($stmt->fetchAll());

include __DIR__ . '/templates/header.php';
?>
<h2>Chat</h2>
<div class="chat-box mb-3">
  <?php foreach($rows as $r): ?>
    <div class="message user"><strong>You:</strong> <?php echo htmlspecialchars($r['message']); ?><br><small class="text-muted"><?php echo $r['created_at']; ?></small></div>
    <div class="message bot"><strong>Bot:</strong> <?php echo nl2br(htmlspecialchars($r['response'])); ?></div>
  <?php endforeach; ?>
</div>
<form method="post">
  <div class="mb-3"><textarea class="form-control" name="message" rows="3" required></textarea></div>
  <button class="btn btn-primary">Send</button>
</form>

<?php include __DIR__ . '/templates/footer.php'; ?>