<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

try {
    $stmt = $pdo->query("
        SELECT student_id, name, email 
        FROM Students
        ORDER BY student_id
    ");
    
    respondSuccess($stmt->fetchAll());
    
} catch(PDOException $e) {
    respondError('获取学生列表失败', 500);
}