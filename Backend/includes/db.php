<?php

// 开发环境显示错误
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 数据库配置
define('DB_HOST', 'localhost');
define('DB_NAME', 'stumanager');
define('DB_USER', 'root');
define('DB_PASS', '123456');

// 创建数据库连接
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode([
        'error' => '数据库连接失败',
        'message' => $e->getMessage()
    ]));
}