<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/functions.php';

setJsonHeader();
checkAdminAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    respondError('仅支持DELETE请求', 405);
}

$enrollmentId = $_GET['id'] ?? null;

if (!$enrollmentId || !is_numeric($enrollmentId)) {
    respondError('无效的记录ID', 400);
}

try {
    $stmt = $pdo->prepare("DELETE FROM Enrollments WHERE enrollment_id = ?");
    $stmt->execute([$enrollmentId]);
    
    if ($stmt->rowCount() > 0) {
        respondSuccess(['deleted' => true]);
    } else {
        respondError('记录不存在', 404);
    }
    
} catch(PDOException $e) {
    respondError('删除失败: ' . $e->getMessage(), 500);
}