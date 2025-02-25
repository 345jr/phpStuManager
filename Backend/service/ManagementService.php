<?php

require_once __DIR__ . '/../dao/StudentDAO.php';
require_once __DIR__ . '/../dao/CourseDAO.php';

class ManagementService {
    private $studentDAO;
    private $courseDAO;

    public function __construct($db) {
        $this->studentDAO = new StudentDAO($db);
        $this->courseDAO = new CourseDAO($db);
    }

    // 注册新学生
    public function registerStudent($name, $email, $password) {
        $student = new Student(null, $name, $email, $password);
        $this->studentDAO->insertStudent($student);
    }

    // 注销学生
    public function unregisterStudent($studentId) {
        $this->studentDAO->deleteStudent($studentId);
    }

    // 注册新课程
    public function registerCourse($courseName, $maxStudents, $brief, $description, $teacher, $startTime, $classHour, $courseTag) {
        $course = new Course(null, $courseName, $maxStudents, $brief, $description, $teacher, $startTime, $classHour, 0, $courseTag);
        $this->courseDAO->insertCourse($course);
    }

    // 注销课程
    public function unregisterCourse($courseId) {
        $this->courseDAO->deleteCourse($courseId);
    }
}
?>