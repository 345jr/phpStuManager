<?php

require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../dao/StudentDao.php';

class AuthService {
    private $adminDAO;
    private $studentDAO;

    public function __construct($db) {
        $this->adminDAO = new AdminDAO($db);
        $this->studentDAO = new StudentDAO($db);
    }

    public function authenticate($email, $password, $role) {
        if ($role === 'admin') {
            $user = $this->adminDAO->getAdminByEmail($email);
        } elseif ($role === 'student') {
            $user = $this->studentDAO->getStudentByEmail($email);
        } else {
            return null;
        }

        if ($user && $user['password'] === $password) {
            return $user;
        } else {
            return null;
        }
    }
}
?>