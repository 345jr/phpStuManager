<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

try {
    $stmt = $pdo->query("
        SELECT e.enrollment_id, 
               s.student_id, s.name AS student_name,
               c.course_id, c.course_name
        FROM Enrollments e
        JOIN Students s ON e.student_id = s.student_id
        JOIN Courses c ON e.course_id = c.course_id
    ");
    
    respondSuccess($stmt->fetchAll());
    
} catch(PDOException $e) {
    respondError('获取选课记录失败', 500);
}