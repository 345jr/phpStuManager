<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';

setJsonHeader();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('仅支持POST请求', 405);
}

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM Admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && $password === $admin['password']) {
        session_start();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];
        
        echo json_encode([
            'success' => true,
            'admin' => [
                'id' => $admin['admin_id'],
                'name' => $admin['name']
            ]
        ]);
    } else {
        respondError('认证失败', 401);
    }
} catch(PDOException $e) {
    respondError('登录失败', 500);
}