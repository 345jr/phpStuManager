<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('仅支持POST请求', 405);
}

$data = json_decode(file_get_contents('php://input'), true);
$courseName = $data['course_name'] ?? '';
$maxStudents = $data['max_students'] ?? 0;

if (empty($courseName) || $maxStudents <= 0) {
    respondError('无效的课程参数', 400);
}

try {
    $stmt = $pdo->prepare("INSERT INTO Courses (course_name, max_students) VALUES (?, ?)");
    $stmt->execute([$courseName, $maxStudents]);
    
    respondSuccess([
        'course_id' => $pdo->lastInsertId(),
        'course_name' => $courseName
    ]);
    
} catch(PDOException $e) {
    respondError('创建失败: ' . $e->getMessage(), 500);
}