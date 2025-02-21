<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php'; 

setJsonHeader();

// 只接受POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('仅支持POST请求', 405);
}

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM Students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch();

    if ($student && $password === $student['password']) {
        session_start();
        $_SESSION['student_id'] = $student['student_id'];
        $_SESSION['student_name'] = $student['name'];
        
        echo json_encode([
            'success' => true,
            'student' => [
                'id' => $student['student_id'],
                'name' => $student['name']
            ]
        ]);
    } else {
        respondError('邮箱或密码错误', 401);
    }
} catch(PDOException $e) {
    respondError('登录失败', 500);
}