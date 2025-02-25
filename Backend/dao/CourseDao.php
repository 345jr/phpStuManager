<?php

require_once __DIR__ . '/SQLQueries.php';

class CourseDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('courses', __DIR__ . '/../config/sql/courses_queries.json');
    }

    public function getCourseById($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'getCourseById'));
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCourses() {
        $stmt = $this->db->query(SQLQueries::getQuery('courses', 'getAllCourses'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCourse($course) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'insertCourse'));
        $stmt->execute([
            $course->getCourseName(),
            $course->getMaxStudents(),
            $course->getBrief(),
            $course->getDescription(),
            $course->getTeacher(),
            $course->getStartTime(),
            $course->getClassHour(),
            $course->getCurrentNum(),
            $course->getCourseTag()
        ]);
    }

    public function updateCourse($course) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'updateCourse'));
        $stmt->execute([
            $course->getCourseName(),
            $course->getMaxStudents(),
            $course->getBrief(),
            $course->getDescription(),
            $course->getTeacher(),
            $course->getStartTime(),
            $course->getClassHour(),
            $course->getCurrentNum(),
            $course->getCourseTag(),
            $course->getCourseId()
        ]);
    }

    public function deleteCourse($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'deleteCourse'));
        $stmt->execute([$course_id]);
    }

    public function incrementCurrentNum($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'incrementCurrentNum'));
        $stmt->execute([$course_id]);
    }

    public function decrementCurrentNum($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'decrementCurrentNum'));
        $stmt->execute([$course_id]);
    }
}
?>