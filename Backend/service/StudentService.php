<?php

require_once __DIR__ . '/../dao/StudentDAO.php';

class StudentService {
    private $studentDAO;

    public function __construct($db) {
        $this->studentDAO = new StudentDAO($db);
    }

    public function getStudentById($studentId) {
        return $this->studentDAO->getStudentById($studentId);
    }
}
?>