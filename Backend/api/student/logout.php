<?php
// 引入依赖
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// 启动会话
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure'   => false,
        'cookie_httponly' => true
    ]);
}

// 跨域设置
header('Access-Control-Allow-Origin: http://localhost:5173'); // 替换为前端地址
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    exit(0);
}

// 设置 JSON 响应头
setJsonHeader();

// 清除会话数据
session_unset(); // 清除所有会话变量
session_destroy(); // 销毁会话

// 返回成功响应
echo json_encode([
    'success' => true,
    'message' => '退出登录成功'
]);
exit;
?>