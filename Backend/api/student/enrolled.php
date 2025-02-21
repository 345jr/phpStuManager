<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// 启动会话
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
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    exit(0);
}

// 设置 JSON 响应头
setJsonHeader();

// 获取学生 ID
$studentId = $_SESSION['student_id'] ?? null;
if (!$studentId) {
    respondError('会话中缺少学生 ID', 401);
}

try {
    $stmt = $pdo->prepare("
        SELECT c.course_id, c.course_name, e.enrollment_id
        FROM Enrollments e
        JOIN Courses c ON e.course_id = c.course_id
        WHERE e.student_id = ?
    ");
    $stmt->execute([$studentId]);
    
    echo json_encode([
        'success' => true,
        'courses' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
    exit;
} catch (PDOException $e) {
    respondError('获取选课记录失败: ' . $e->getMessage(), 500);
}
?>