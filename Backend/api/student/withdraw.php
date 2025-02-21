<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php'; 

setJsonHeader();
// checkStudentAuth();

// 仅接受DELETE请求
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    respondError('仅支持DELETE请求', 405);
}

$studentId = $_SESSION['student_id'];
$courseId = $_GET['course_id'] ?? null;

if (!$courseId || !is_numeric($courseId)) {
    respondError('无效的课程ID', 400);
}

try {
    $stmt = $pdo->prepare("DELETE FROM Enrollments 
        WHERE student_id = ? AND course_id = ?");
    $stmt->execute([$studentId, $courseId]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        respondError('未找到选课记录', 404);
    }
    
} catch(PDOException $e) {
    respondError('退课失败', 500);
}