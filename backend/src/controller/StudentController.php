<?php

require_once __DIR__ . '/../service/CourseService.php';
require_once __DIR__ . '/../service/EnrollmentService.php';
require_once __DIR__ . '/../service/StudentService.php';
require_once __DIR__ . '/../util/PublicFunction.php';
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
        if (!checkLogin()){
            return;
        }
        // 获取学生的选课记录
        $enrollments = $this->enrollmentService->getEnrollmentsByStudentId($studentId);
        
        // 获取每个选课记录对应的课程详细信息
        $courseInformation = [];
        foreach ($enrollments as $enrollment) {
            $courseId = $enrollment['course_id'];
            $course = $this->courseService->getCourseById($courseId);
            if ($course) {
                $courseInformation[] = $course;
            }
        }
        
        $this->respond(200, $courseInformation);
    }

    public function enrollCourse($studentId, $courseId) {
        if (!checkLogin()){
            return;
        }
        try {
            $this->enrollmentService->enrollStudentInCourse($studentId, $courseId);
            $this->respond(200, ['message' => 'Enrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function unenrollCourse($studentId, $courseId) {
        if (!checkLogin()){
            return;
        }
        try {
            $this->enrollmentService->unenrollStudentFromCourse($studentId, $courseId);
            $this->respond(200, ['message' => 'Unenrollment successful']);
        } catch (Exception $e) {
            $this->respond(400, ['message' => $e->getMessage()]);
        }
    }

    public function getStudentInfo($studentId) {
        if (!checkLogin()){
            return;
        }
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
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data , JSON_UNESCAPED_UNICODE);
    }
}
?>