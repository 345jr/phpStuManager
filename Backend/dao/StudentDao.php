<?php

require_once __DIR__ . '/SQLQueries.php';

class StudentDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('students', __DIR__ . '/../config/sql/students_queries.json');
    }

    public function getStudentById($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'getStudentById'));
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllStudents() {
        $stmt = $this->db->query(SQLQueries::getQuery('students', 'getAllStudents'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertStudent($student) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'insertStudent'));
        $stmt->execute([
            $student->getName(),
            $student->getEmail(),
            $student->getPassword()
        ]);
    }

    public function updateStudent($student) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'updateStudent'));
        $stmt->execute([
            $student->getName(),
            $student->getEmail(),
            $student->getPassword(),
            $student->getid()
        ]);
    }

    public function deleteStudent($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'deleteStudent'));
        $stmt->execute([$student_id]);
    }

    public function getStudentByEmail($email) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'getStudentByEmail'));
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>