<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
include __DIR__ . '/../templates/header.php';
?>
<h1>Admin Dashboard</h1>
<div class="row">
  <div class="col-md-4">
    <div class="card mb-3"><div class="card-body"><h5 class="card-title">Users</h5><p><a href="/trang_quản_lý_người_dùng_(admin_user_management_page)_/index.php" class="btn btn-sm btn-primary">Manage</a></p></div></div>
  </div>
  <div class="col-md-4">
    <div class="card mb-3"><div class="card-body"><h5 class="card-title">Models</h5><p><a href="/trang_quản_lý_model_ai/index.php" class="btn btn-sm btn-primary">Manage</a></p></div></div>
  </div>
  <div class="col-md-4">
    <div class="card mb-3"><div class="card-body"><h5 class="card-title">History</h5><p><a href="/trang_lịch_sử_trò_chuyện/index.php" class="btn btn-sm btn-primary">View</a></p></div></div>
  </div>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>