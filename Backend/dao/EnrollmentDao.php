<?php

require_once __DIR__ . '/SQLQueries.php';

class EnrollmentDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('enrollments', __DIR__ . '/../config/sql/enrollments_queries.json');
    }

    public function getEnrollmentById($enrollment_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'getEnrollmentById'));
        $stmt->execute([$enrollment_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllEnrollments() {
        $stmt = $this->db->query(SQLQueries::getQuery('enrollments', 'getAllEnrollments'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertEnrollment($enrollment) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'insertEnrollment'));
        $stmt->execute([
            $enrollment->getStudentId(),
            $enrollment->getCourseId()
        ]);
    }

    public function updateEnrollment($enrollment) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'updateEnrollment'));
        $stmt->execute([
            $enrollment->getStudentId(),
            $enrollment->getCourseId(),
            $enrollment->getEnrollmentId()
        ]);
    }

    public function deleteEnrollment($enrollment_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'deleteEnrollment'));
        $stmt->execute([$enrollment_id]);
    }

    public function getEnrollmentsByStudentId($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'getEnrollmentsByStudentId'));
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEnrollmentByStudentAndCourse($student_id, $course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'deleteEnrollmentByStudentAndCourse'));
        $stmt->execute([$student_id, $course_id]);
    }
}
?>