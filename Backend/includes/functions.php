<?php
// includes/functions.php
require_once 'db.php';

// 统一错误响应
function respondError($message, $code = 400) {
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'error' => [
            'code' => $code,
            'message' => $message
        ]
    ]);
    exit;
}

// 统一成功响应
function respondSuccess($data = null) {
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    exit;
}

// 安全获取输入参数
function getInput($key, $default = null) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    return isset($input[$key]) ? htmlspecialchars($input[$key]) : $default;
}

// 检查课程是否存在
function courseExists($courseId) {
  global $pdo;
  try {
      $stmt = $pdo->prepare("SELECT course_id FROM Courses WHERE course_id = ?");
      $stmt->execute([$courseId]);
      return $stmt->fetch() !== false;
  } catch(PDOException $e) {
      return false;
  }
}