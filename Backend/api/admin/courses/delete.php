<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    respondError('仅支持DELETE请求', 405);
}

$courseId = $_GET['id'] ?? null;

if (!$courseId || !is_numeric($courseId)) {
    respondError('无效的课程ID', 400);
}

try {
    // 先删除相关选课记录
    $pdo->beginTransaction();
    
    $deleteEnroll = $pdo->prepare("DELETE FROM Enrollments WHERE course_id = ?");
    $deleteEnroll->execute([$courseId]);
    
    $deleteCourse = $pdo->prepare("DELETE FROM Courses WHERE course_id = ?");
    $deleteCourse->execute([$courseId]);
    
    $pdo->commit();
    
    respondSuccess([
        'deleted_courses' => $deleteCourse->rowCount(),
        'deleted_enrollments' => $deleteEnroll->rowCount()
    ]);
    
} catch(PDOException $e) {
    $pdo->rollBack();
    respondError('删除失败: ' . $e->getMessage(), 500);
}