<?php
// 开启会话（如果未启动）
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // 24小时
        'cookie_secure'   => false, // 本地开发可关闭
        'cookie_httponly' => true
    ]);
}

// 跨域设置（开发环境用）
header('Access-Control-Allow-Origin: http://localhost:8080'); // 根据Vue前端地址修改
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');

// 管理员权限验证
function checkAdminAuth() {
    if (!isset($_SESSION['admin_id'])) {
        http_response_code(401);
        die(json_encode([
            'code' => 401,
            'error' => '需要管理员权限',
            'login_route' => '/admin/login.php'
        ]));
    }
}

// 学生权限验证
function checkStudentAuth() {
    if (!isset($_SESSION['student_id'])) {
        http_response_code(401);
        die(json_encode([
            'code' => 401,
            'error' => '需要学生登录',
            'login_route' => '/student/login.php'
        ]));
    }
}

// 通用响应头设置
function setJsonHeader() {
    header('Content-Type: application/json; charset=utf-8');
}

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    exit(0);
}