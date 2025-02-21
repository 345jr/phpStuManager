<?php
// 引入依赖
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// 启动会话（避免重复调用）
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure'   => false, // 本地开发
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

// 只接受 POST 请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('仅支持POST请求', 405);
}

// 获取 POST 数据
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// 验证输入
if (empty($email) || empty($password)) {
    respondError('邮箱和密码不能为空', 400);
}

try {
    // 查询学生信息
    $stmt = $pdo->prepare("SELECT * FROM Students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // 验证密码（假设使用哈希）
    // if ($student && password_verify($password, $student['password'])) {
    $_SESSION['student_id'] = $student['student_id'];
    $_SESSION['student_name'] = $student['name'];
    // 生成简单 token（实际应使用更安全的生成方式）
    $token = bin2hex(random_bytes(16));

    // 返回成功响应
    echo json_encode([
        'success' => true,
        'student' => [
            'id' => $student['student_id'],
            'name' => $student['name']
        ],
        'token' => $token
    ]);
    exit;
}
// else {
//     respondError('邮箱或密码错误', 401);
// }

catch (PDOException $e) {
    respondError('登录失败: ' . $e->getMessage(), 500);
}
