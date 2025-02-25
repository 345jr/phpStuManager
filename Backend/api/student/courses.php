<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php'; 

setJsonHeader();
// checkStudentAuth();

try {
    $query = "SELECT 
        c.course_id,
        c.course_name,
        c.max_students,
        c.tag,
        (c.max_students - COUNT(e.enrollment_id)) AS available,
        COUNT(e.enrollment_id) AS enrolled
    FROM Courses c
    LEFT JOIN Enrollments e ON c.course_id = e.course_id
    GROUP BY c.course_id , c.tag
    ";
    
    $courses = $pdo->query($query)->fetchAll();
    
    echo json_encode(['courses' => $courses]);
    
} catch(PDOException $e) {
    respondError('获取课程失败', 500);
}