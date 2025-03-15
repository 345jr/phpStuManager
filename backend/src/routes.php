<?php

// CORS 配置
// header("Access-Control-Allow-Origin: *"); // 允许所有来源的请求
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // 允许的请求方法
// header("Access-Control-Allow-Headers: Content-Type, Authorization"); // 允许的请求头

$allowed_origins = [
    'http://a39.php.youyue.info',
    'http://199.115.229.247:8080'
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json; charset=UTF-8"); // 明确指定 UTF-8
}

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/StudentController.php';
require_once __DIR__ . '/controller/AdminController.php';
// require_once __DIR__ . '/util/PublicFunction.php';

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
    case '/api/index.php':
        if ($method === 'GET') {
            echo json_encode(['message' => 'Welcome to the API , 中文测试'], JSON_UNESCAPED_UNICODE);
            echo json_encode(['message' => 'Welcome to the API , 中文测试'], JSON_UNESCAPED_UNICODE);
        }
    case '/api/login': //学生登录
        if ($method === 'POST') {
            $authController->login($body['email'], $body['password'], $body['role']);
        }
        break;
    case '/api/logout': //学生登出
        if ($method === 'POST') {
            $authController->logout();
        }
        break;
        /**
         * 弃用
         */
    case '/api/check-session': //检查是否登录
        if ($method === 'GET') {
            // session_start(); 
            if (isset($_SESSION['user_id'])) {
                http_response_code(200);
                echo json_encode(['message' => 'Session valid']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/api/courses': //查询所有课程
        if ($method === 'GET') {
            $studentController->getAllCourses();
        }
        break;
    case '/api/enrolledCourses': //查询已选课程，根据学生学号
        if ($method === 'GET') {
            // session_start();
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->getEnrolledCourses($studentId);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/api/enroll': //选课
        if ($method === 'POST') {
            // session_start();
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->enrollCourse($studentId, $body['courseId']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/api/unenroll': //退课
        if ($method === 'POST') {
            // session_start();
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->unenrollCourse($studentId, $body['courseId']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
    case '/api/studentInfo': //查看学生信息
        if ($method === 'GET') {
            // session_start();
            $studentId = $_SESSION['user_id'] ?? null;
            if ($studentId) {
                $studentController->getStudentInfo($studentId);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/login':
        if ($method === 'POST') {
            $adminController->login($body['email'], $body['password']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/logout':
        if ($method === 'POST') {
            $adminController->logout();
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/registerStudent': //管理员注册学生
        if ($method === 'POST') {
            $adminController->registerStudent($body['name'], $body['email'], $body['password']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/unregisterStudent': //管理员注销学生
        if ($method === 'DELETE') {
            $adminController->unregisterStudent($body['studentId']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/registerCourse': //管理员注册课程
        if ($method === 'POST') {
            $adminController->registerCourse($body);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/unregisterCourse': //管理员注销课程
        if ($method === 'DELETE') {
            $adminController->unregisterCourse($body['courseId']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/enrollStudents': //管理员选课
        if ($method === 'POST') {
            $adminController->enrollStudentsInCourse($body['studentIds'], $body['courseId']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/unenrollStudents': //管理员退课
        if ($method === 'POST') {
            $adminController->unenrollStudentsFromCourse($body['studentIds'], $body['courseId']);
        }
        break;
        /**
         * 弃用
         */
    case '/api/admin/courseInfo': //管理员查看课程信息
        if ($method === 'GET') {
            $adminController->getCourseInfo($params['courseId']);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
}
