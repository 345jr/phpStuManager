<?php

require_once __DIR__ . '/../service/CourseService.php';
require_once __DIR__ . '/../service/EnrollmentService.php';
require_once __DIR__ . '/../service/StudentService.php';
require_once __DIR__ . '/../model/Course.php';

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
        /**
         * 这里服务层返回的课程并不是多个课程，也不是具体的课程信息，而是中间表的信息，内含记录id，学生id和课程id
         */
        $courses = $this->enrollmentService->getEnrollmentsByStudentId($studentId);
        /**
         * 为不进行大量更改暂时在此处调用课程服务查询课程信息
         */
        $courseInformation = $this->courseService->getCourseById($studentId);
        $this->respond(200, $courseInformation);
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