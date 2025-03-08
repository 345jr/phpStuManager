<?php

require_once __DIR__ . '/../dao/CourseDao.php';

class CourseService {
    private $courseDAO;

    public function __construct($db) {
        $this->courseDAO = new CourseDAO($db);
    }

    public function getAllCourses() {
        return $this->courseDAO->getAllCourses();
    }

    public function getCourseById($courseId) {
        return $this->courseDAO->getCourseById($courseId);
    }
}
?>