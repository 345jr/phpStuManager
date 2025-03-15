<?php
/**
 * 弃用
 */
require_once __DIR__ . '/../service/AuthService.php';
require_once __DIR__ . '/../service/ManagementService.php';
require_once __DIR__ . '/../service/EnrollmentService.php';
require_once __DIR__ . '/../service/CourseService.php';

class AdminController {
    private $authService;
    private $managementService;
    private $enrollmentService;
    private $courseService;

    public function __construct($db) {
        $this->authService = new AuthService($db);
        $this->managementService = new ManagementService($db);
        $this->enrollmentService = new EnrollmentService($db);
        $this->courseService = new CourseService($db);
    }

    public function login($email, $password) {
        $user = $this->authService->authenticate($email, $password, 'admin');
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';
            $this->respond(200, ['message' => 'Login successful']);
        } else {
            $this->respond(401, ['message' => 'Invalid email or password']);
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        $this->respond(200, ['message' => 'Logout successful']);
    }

    public function registerStudent($name, $email, $password) {
        try {
            $this->managementService->registerStudent($name, $email, $password);
            $this->respond(201, ['message' => 'Student registration successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function unregisterStudent($studentId) {
        try {
            $this->managementService->unregisterStudent($studentId);
            $this->respond(200, ['message' => 'Student unregistration successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function registerCourse($courseData) {
        try {
            $this->managementService->registerCourse(
                $courseData['courseName'], 
                $courseData['maxStudents'], 
                $courseData['brief'], 
                $courseData['description'], 
                $courseData['teacher'], 
                $courseData['startTime'], 
                $courseData['classHour'], 
                $courseData['courseTag']
            );
            $this->respond(201, ['message' => 'Course registration successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function unregisterCourse($courseId) {
        try {
            $this->managementService->unregisterCourse($courseId);
            $this->respond(200, ['message' => 'Course unregistration successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function enrollStudentsInCourse($studentIds, $courseId) {
        try {
            $this->enrollmentService->enrollStudentsInCourse($studentIds, $courseId);
            $this->respond(200, ['message' => 'Enrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function unenrollStudentsFromCourse($studentIds, $courseId) {
        try {
            foreach ($studentIds as $studentId) {
                $this->enrollmentService->unenrollStudentFromCourse($studentId, $courseId);
            }
            $this->respond(200, ['message' => 'Unenrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function getCourseInfo($courseId) {
        $course = $this->courseService->getCourseById($courseId);
        if ($course) {
            $this->respond(200, $course);
        } else {
            $this->respond(404, ['message' => 'Course not found']);
        }
    }

    // 响应处理方法
    private function respond($status, $data) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>