<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php'; 

setJsonHeader();
checkStudentAuth();

$studentId = $_SESSION['student_id'];

try {
    $stmt = $pdo->prepare("
        SELECT c.course_id, c.course_name, e.enrollment_id
        FROM Enrollments e
        JOIN Courses c ON e.course_id = c.course_id
        WHERE e.student_id = ?
    ");
    $stmt->execute([$studentId]);
    
    echo json_encode([
        'courses' => $stmt->fetchAll()
    ]);
    
} catch(PDOException $e) {
    respondError('获取选课记录失败', 500);
}