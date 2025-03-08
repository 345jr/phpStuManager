<?php

require_once __DIR__ . '/../service/CourseService.php';
require_once __DIR__ . '/../service/EnrollmentService.php';
require_once __DIR__ . '/../service/StudentService.php';

class StudentController {
    private $courseService;
    private $enrollmentService;
    private $studentService;

    public function __construct($db) {
        $this->courseService = new CourseService($db);
        $this->enrollmentService = new EnrollmentService($db);
        $this->studentService = new StudentService($db);
    }

    public function getAllCourses() {
        $courses = $this->courseService->getAllCourses();
        $this->respond(200, $courses);
    }

    public function getEnrolledCourses($studentId) {
        $courses = $this->enrollmentService->getEnrollmentsByStudentId($studentId);
        $this->respond(200, $courses);
    }

    public function enrollCourse($studentId, $courseId) {
        try {
            $this->enrollmentService->enrollStudentInCourse($studentId, $courseId);
            $this->respond(200, ['message' => 'Enrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function unenrollCourse($studentId, $courseId) {
        try {
            $this->enrollmentService->unenrollStudentFromCourse($studentId, $courseId);
            $this->respond(200, ['message' => 'Unenrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function getStudentInfo($studentId) {
        $student = $this->studentService->getStudentById($studentId);
        if ($student) {
            $this->respond(200, $student);
        } else {
            $this->respond(404, ['message' => 'Student not found']);
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