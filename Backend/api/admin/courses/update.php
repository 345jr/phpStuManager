<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    respondError('仅支持PUT请求', 405);
}

$courseId = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('php://input'), true);

if (!$courseId || !is_numeric($courseId)) {
    respondError('无效的课程ID', 400);
}

$courseName = $data['course_name'] ?? null;
$maxStudents = $data['max_students'] ?? null;

try {
    $updates = [];
    $params = [];
    
    if ($courseName !== null) {
        $updates[] = "course_name = ?";
        $params[] = $courseName;
    }
    
    if ($maxStudents !== null) {
        if ($maxStudents <= 0) {
            respondError('人数限制必须大于0', 400);
        }
        $updates[] = "max_students = ?";
        $params[] = $maxStudents;
    }
    
    if (empty($updates)) {
        respondError('没有修改内容', 400);
    }
    
    $params[] = $courseId;
    $query = "UPDATE Courses SET " . implode(', ', $updates) . " WHERE course_id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    
    respondSuccess(['affected_rows' => $stmt->rowCount()]);
    
} catch(PDOException $e) {
    respondError('更新失败', 500);
}