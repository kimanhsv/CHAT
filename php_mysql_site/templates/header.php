<?php
// header.php - Tailwind admin layout adapted from code.html
// Assumes session started and config.php already included by caller
$current = $_SERVER['REQUEST_URI'] ?? '/';
function is_active($path){
    $cur = $_SERVER['REQUEST_URI'] ?? '';
    return strpos($cur, $path) !== false;
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AI Chat Admin</title>
  <!-- Tailwind CSS v3 with plugins -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; background-color:#f7f8fa; }
    input[type='number']::-webkit-inner-spin-button, input[type='number']::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type='number'] { -moz-appearance: textfield; }
  </style>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'sidebar-bg': '#1a3666',
            'sidebar-active': '#334d7c',
            'content-bg': '#f7f8fa',
            'primary-blue': '#4a69e2',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-content-bg text-gray-800">
<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-sidebar-bg text-white flex flex-col flex-shrink-0">
    <div class="h-16 flex items-center px-6">
      <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V4H8"></path><rect height="16" rx="2" width="16" x="4" y="4"></rect><path d="M12 12h4"></path><path d="M12 16h4"></path><path d="M8 12h.01"></path><path d="M8 16h.01"></path></svg>
      <span class="text-xl font-bold">AI Chat Admin</span>
    </div>
    <nav class="flex-grow px-4 py-4">
      <ul class="space-y-2">
        <li>
          <a class="flex items-center p-3 rounded-lg hover:bg-sidebar-active transition-colors duration-200 <?php echo is_active('/admin/index.php') ? 'bg-sidebar-active font-semibold' : ''; ?>" href="/admin/index.php">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><line x1="12" x2="12" y1="20" y2="10"></line><line x1="18" x2="18" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="16"></line></svg>
            <span>Tổng quan</span>
          </a>
        </li>
        <li>
          <a class="flex items-center p-3 rounded-lg hover:bg-sidebar-active transition-colors duration-200 <?php echo is_active('/admin/users.php') ? 'bg-sidebar-active font-semibold' : ''; ?>" href="/admin/users.php">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Người dùng</span>
          </a>
        </li>
        <li>
          <a class="flex items-center p-3 rounded-lg hover:bg-sidebar-active transition-colors duration-200 <?php echo is_active('/admin/history.php') ? 'bg-sidebar-active font-semibold' : ''; ?>" href="/admin/history.php">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
            <span>Lịch sử Chat</span>
          </a>
        </li>
        <li>
          <a aria-current="page" class="flex items-center p-3 rounded-lg <?php echo is_active('/admin/settings.php') ? 'bg-sidebar-active font-semibold' : ''; ?> transition-colors duration-200" href="/admin/settings.php">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 0 2.2l-.15.1a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.38a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1 0-2.2l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            <span>Cài đặt chung</span>
          </a>
        </li>
        <li>
          <a class="flex items-center p-3 rounded-lg hover:bg-sidebar-active transition-colors duration-200 <?php echo is_active('/admin/models.php') ? 'bg-sidebar-active font-semibold' : ''; ?>" href="/admin/models.php">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 14 4-4"></path><path d="m16 14-4-4"></path><path d="M18 10V5.5c0-1-1.2-2-2.5-2S13 4.5 13 5.5V10"></path><path d="M6 10V5.5C6 4.5 4.8 3 3.5 3S1 4.5 1 5.5V10"></path><path d="M14 21v-4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v4"></path><path d="M1 10h22"></path></svg>
            <span>Mô hình AI</span>
          </a>
        </li>
      </ul>
    </nav>
    <div class="px-4 pb-4">
      <a class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-sidebar-active hover:text-white transition-colors duration-200" href="/auth/logout.php">
        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
        <span>Đăng xuất</span>
      </a>
    </div>
  </aside>
  <!-- Main Content -->
  <main class="flex-1 overflow-y-auto p-8">
    <div class="max-w-4xl mx-auto" data-purpose="content-wrapper">