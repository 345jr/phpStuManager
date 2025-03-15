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

    /**
     * 验证用户身份
     *
     * @param string $email 用户邮箱
     * @param string $password 用户密码
     * @param string $role 用户角色（admin或student）
     * @return array|null 返回用户信息数组，如果验证失败则返回null
     */
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