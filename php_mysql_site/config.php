<?php
// config.php - DB settings and common functions
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'chat_app');
define('DB_USER', 'chat_user');
define('DB_PASS', 'change_me');

function get_pdo(){
    static $pdo = null;
    if($pdo === null){
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}

function is_logged_in(){
    return !empty($_SESSION['user_id']);
}

function require_login(){
    if(!is_logged_in()){
        header('Location: /auth/login.php');
        exit;
    }
}

function csrf_token(){
    if(empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}

function check_csrf($token){
    return hash_equals($_SESSION['csrf'] ?? '', $token ?? '');
}

function is_admin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_admin(){
    if(!is_admin()){
        header('HTTP/1.1 403 Forbidden');
        echo 'Forbidden';
        exit;
    }
}
?>