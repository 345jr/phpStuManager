<?php

// CORS 配置
header("Access-Control-Allow-Origin: *"); // 允许所有来源的请求
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // 允许的请求方法
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // 允许的请求头

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/StudentController.php';
require_once __DIR__ . '/controller/AdminController.php';

// 创建数据库连接
$db = Database::getInstance()->getConnection();

// 创建控制器实例
$authController = new AuthController($db);
$studentController = new StudentController($db);
$adminController = new AdminController($db);

// 获取请求方法和路径
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$params = $_GET;
$body = json_decode(file_get_contents('php://input'), true);

// 路由配置
switch ($path) {
    case '/login'://学生登录
        if ($method === 'POST') {
            $authController->login($body['email'], $body['password'], $body['role']);
        }
        break;
    case '/logout'://学生登出
        if ($method === 'POST') {
            $authController->logout();
        }
        break;
    case '/courses'://查询所有课程
        if ($method === 'GET') {
            $studentController->getAllCourses();
        }
        break;
    case '/enrolledCourses'://查询已选课程，根据学生学号
        if ($method === 'GET') {
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->getEnrolledCourses($studentId);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/enroll'://选课
        if ($method === 'POST') {
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->enrollCourse($studentId, $body['courseId']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/unenroll'://退课
        if ($method === 'POST') {
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->unenrollCourse($studentId, $body['courseId']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/studentInfo'://查看学生信息
        if ($method === 'GET') {
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->getStudentInfo($studentId);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/admin/login':
        if ($method === 'POST') {
            $adminController->login($body['email'], $body['password']);
        }
        break;
    case '/admin/logout':
        if ($method === 'POST') {
            $adminController->logout();
        }
        break;
    case '/admin/registerStudent'://管理员注册学生
        if ($method === 'POST') {
            $adminController->registerStudent($body['name'], $body['email'], $body['password']);
        }
        break;
    case '/admin/unregisterStudent'://管理员注销学生
        if ($method === 'DELETE') {
            $adminController->unregisterStudent($body['studentId']);
        }
        break;
    case '/admin/registerCourse'://管理员注册课程
        if ($method === 'POST') {
            $adminController->registerCourse($body);
        }
        break;
    case '/admin/unregisterCourse'://管理员注销课程
        if ($method === 'DELETE') {
            $adminController->unregisterCourse($body['courseId']);
        }
        break;
    case '/admin/enrollStudents'://管理员选课
        if ($method === 'POST') {
            $adminController->enrollStudentsInCourse($body['studentIds'], $body['courseId']);
        }
        break;
    case '/admin/unenrollStudents'://管理员退课
        if ($method === 'POST') {
            $adminController->unenrollStudentsFromCourse($body['studentIds'], $body['courseId']);
        }
        break;
    case '/admin/courseInfo'://管理员查看课程信息
        if ($method === 'GET') {
            $adminController->getCourseInfo($params['courseId']);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
}
?>