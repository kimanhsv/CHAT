<?php
require_once __DIR__ . '/../config.php';
require_login();
require_admin();
$pdo = get_pdo();
$errors = [];

function get_setting($pdo, $key){
    $stmt = $pdo->prepare('SELECT `value` FROM admin_settings WHERE `key` = ? LIMIT 1');
    $stmt->execute([$key]);
    return $stmt->fetchColumn();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!check_csrf($_POST['csrf'] ?? '')) $errors[] = 'Invalid CSRF';

    $data = [
        'system_language' => trim($_POST['system_language'] ?? ''),
        'timezone' => trim($_POST['timezone'] ?? ''),
        'website_name' => trim($_POST['website_name'] ?? ''),
        'char_limit' => intval($_POST['char_limit'] ?? 2000),
        'message_limit' => intval($_POST['message_limit'] ?? 50),
        'ai_model' => trim($_POST['ai_model'] ?? ''),
        'allow_registration' => isset($_POST['allow_registration']) ? '1' : '0',
        'require_verification' => isset($_POST['require_verification']) ? '1' : '0',
        'admin_notifications' => isset($_POST['admin_notifications']) ? '1' : '0',
        'content_filter' => trim($_POST['content_filter'] ?? 'Trung bình (Khuyên dùng)')
    ];

    if(!$errors){
        $stmt = $pdo->prepare('REPLACE INTO admin_settings (`key`, `value`) VALUES (?, ?)');
        foreach($data as $k => $v){
            $stmt->execute([$k, (string)$v]);
        }
        header('Location: settings.php'); exit;
    }
}

// Load current values
$system_language = get_setting($pdo, 'system_language') ?: 'Tiếng Việt';
$timezone = get_setting($pdo, 'timezone') ?: '(GMT+07:00) Bangkok, Hanoi, Jakarta';
$website_name = get_setting($pdo, 'website_name') ?: 'AI Chat Assistant Pro';
$char_limit = get_setting($pdo, 'char_limit') ?: '2000';
$message_limit = get_setting($pdo, 'message_limit') ?: '50';
$ai_model = get_setting($pdo, 'ai_model') ?: 'GPT-4o (Recommended)';
$allow_registration = get_setting($pdo, 'allow_registration') === '1' ? true : false;
$require_verification = get_setting($pdo, 'require_verification') === '1' ? true : false;
$admin_notifications = get_setting($pdo, 'admin_notifications') === '1' ? true : false;
$content_filter = get_setting($pdo, 'content_filter') ?: 'Trung bình (Khuyên dùng)';

include __DIR__ . '/../templates/header.php';
?>
<!-- Breadcrumb and page title are rendered by header.php template area -->
<div class="bg-white rounded-lg shadow-sm p-8" data-purpose="settings-form-card">
  <h1 class="text-2xl font-bold text-gray-900 mb-8">Cài đặt chung hệ thống</h1>
  <?php if($errors): ?>
    <div class="text-red-600 mb-4"><?php echo implode('<br>', $errors); ?></div>
  <?php endif; ?>
  <form action="" method="POST">
    <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">

    <!-- System & Language -->
    <section class="border-b pb-8 mb-8">
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Hệ thống &amp; Ngôn ngữ</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="system-language">Ngôn ngữ mặc định hệ thống</label>
          <select id="system-language" name="system_language" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="Tiếng Việt" <?php echo $system_language === 'Tiếng Việt' ? 'selected' : ''; ?>>Tiếng Việt</option>
            <option value="English" <?php echo $system_language === 'English' ? 'selected' : ''; ?>>English</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="timezone">Múi giờ</label>
          <select id="timezone" name="timezone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="(GMT+07:00) Bangkok, Hanoi, Jakarta" <?php echo $timezone === '(GMT+07:00) Bangkok, Hanoi, Jakarta' ? 'selected' : ''; ?>>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
            <option value="(GMT-05:00) Eastern Time (US & Canada)" <?php echo $timezone === '(GMT-05:00) Eastern Time (US & Canada)' ? 'selected' : ''; ?>>(GMT-05:00) Eastern Time (US & Canada)</option>
            <option value="(GMT+01:00) Central European Time" <?php echo $timezone === '(GMT+01:00) Central European Time' ? 'selected' : ''; ?>>(GMT+01:00) Central European Time</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1" for="website-name">Tên hiển thị website</label>
          <input id="website-name" name="website_name" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="<?php echo htmlspecialchars($website_name); ?>" />
        </div>
      </div>
    </section>

    <!-- Chat Configuration -->
    <section class="border-b pb-8 mb-8">
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Cấu hình Chat</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="char-limit">Giới hạn ký tự mỗi tin nhắn</label>
          <div class="relative">
            <input id="char-limit" name="char_limit" type="number" value="<?php echo htmlspecialchars($char_limit); ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 text-right" />
          </div>
          <p class="text-xs text-gray-500 mt-1">Số lượng ký tự tối đa người dùng có thể gửi.</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="message-limit">Giới hạn tin nhắn mỗi phiên</label>
          <div class="relative">
            <input id="message-limit" name="message_limit" type="number" value="<?php echo htmlspecialchars($message_limit); ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 text-right" />
          </div>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1" for="ai-model">Mô hình AI mặc định cho khách</label>
          <select id="ai-model" name="ai_model" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="GPT-3.5 Turbo" <?php echo $ai_model === 'GPT-3.5 Turbo' ? 'selected' : ''; ?>>GPT-3.5 Turbo</option>
            <option value="GPT-4o (Recommended)" <?php echo $ai_model === 'GPT-4o (Recommended)' ? 'selected' : ''; ?>>GPT-4o (Recommended)</option>
          </select>
        </div>
      </div>
    </section>

    <!-- Security & Notifications -->
    <section>
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Bảo mật &amp; Thông báo</h2>
      <div class="space-y-6">
        <div class="flex justify-between items-center">
          <label class="text-sm font-medium text-gray-700" for="allow-registration">Cho phép đăng ký người dùng mới</label>
          <div class="flex items-center">
            <button aria-checked="<?php echo $allow_registration ? 'true' : 'false'; ?>" data-input="allow_registration_input" role="switch" type="button" id="allow-registration" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out <?php echo $allow_registration ? 'bg-green-500' : 'bg-gray-200'; ?>">
              <span class="sr-only">Allow new user registration</span>
              <span aria-hidden="true" class="<?php echo $allow_registration ? 'translate-x-5' : 'translate-x-0'; ?> pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
            <input type="hidden" id="allow_registration_input" name="allow_registration" value="<?php echo $allow_registration ? '1' : '0'; ?>">
          </div>
        </div>
        <div class="flex justify-between items-center">
          <label class="text-sm font-medium text-gray-700" for="require-verification">Yêu cầu xác thực email</label>
          <div class="flex items-center">
            <button aria-checked="<?php echo $require_verification ? 'true' : 'false'; ?>" data-input="require_verification_input" role="switch" type="button" id="require-verification" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out <?php echo $require_verification ? 'bg-green-500' : 'bg-gray-200'; ?>">
              <span class="sr-only">Require email verification</span>
              <span aria-hidden="true" class="<?php echo $require_verification ? 'translate-x-5' : 'translate-x-0'; ?> pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
            <input type="hidden" id="require_verification_input" name="require_verification" value="<?php echo $require_verification ? '1' : '0'; ?>">
          </div>
        </div>
        <div class="flex justify-between items-center">
          <label class="text-sm font-medium text-gray-700" for="admin-notifications">Thông báo lỗi hệ thống qua email admin</label>
          <div class="flex items-center">
            <button aria-checked="<?php echo $admin_notifications ? 'true' : 'false'; ?>" data-input="admin_notifications_input" role="switch" type="button" id="admin-notifications" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out <?php echo $admin_notifications ? 'bg-green-500' : 'bg-gray-200'; ?>">
              <span class="sr-only">Notify system errors via admin email</span>
              <span aria-hidden="true" class="<?php echo $admin_notifications ? 'translate-x-5' : 'translate-x-0'; ?> pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
            <input type="hidden" id="admin_notifications_input" name="admin_notifications" value="<?php echo $admin_notifications ? '1' : '0'; ?>">
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 items-center">
          <label class="text-sm font-medium text-gray-700" for="content-filter">Cấp độ lọc nội dung</label>
          <select id="content-filter" name="content_filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="Thấp" <?php echo $content_filter === 'Thấp' ? 'selected' : ''; ?>>Thấp</option>
            <option value="Trung bình (Khuyên dùng)" <?php echo $content_filter === 'Trung bình (Khuyên dùng)' ? 'selected' : ''; ?>>Trung bình (Khuyên dùng)</option>
            <option value="Cao" <?php echo $content_filter === 'Cao' ? 'selected' : ''; ?>>Cao</option>
          </select>
        </div>
      </div>
    </section>

    <!-- Actions -->
    <div class="flex justify-end items-center mt-6">
      <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Hủy</button>
      <button type="submit" class="ml-3 px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">Lưu thay đổi</button>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>