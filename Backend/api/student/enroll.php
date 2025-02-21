<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

setJsonHeader();
checkStudentAuth();

// 仅接受POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('仅支持POST请求', 405);
}

$studentId = $_SESSION['student_id'];
$courseId = getInput('course_id');

try {
    // 验证课程有效性
    if (!courseExists($courseId)) {
        respondError('课程不存在', 404);
    }
    
    // 检查是否已选
    $checkStmt = $pdo->prepare("SELECT * FROM Enrollments 
        WHERE student_id = ? AND course_id = ?");
    $checkStmt->execute([$studentId, $courseId]);
    if ($checkStmt->rowCount() > 0) {
        respondError('不能重复选课', 409);
    }
    
    // 检查课程容量
    $capacityStmt = $pdo->prepare("SELECT 
        max_students,
        (SELECT COUNT(*) FROM Enrollments WHERE course_id = ?) AS current
        FROM Courses WHERE course_id = ?");
    $capacityStmt->execute([$courseId, $courseId]);
    $capacity = $capacityStmt->fetch();
    
    if ($capacity['current'] >= $capacity['max_students']) {
        respondError('课程已满', 400);
    }
    
    // 执行选课
    $insertStmt = $pdo->prepare("INSERT INTO Enrollments 
        (student_id, course_id) VALUES (?, ?)");
    $insertStmt->execute([$studentId, $courseId]);
    
    echo json_encode([
        'success' => true,
        'enrollment_id' => $pdo->lastInsertId()
    ]);
    
} catch(PDOException $e) {
    respondError('选课失败: ' . $e->getMessage(), 500);
}