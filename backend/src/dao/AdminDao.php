<?php

require_once __DIR__ . '/SQLQueries.php';

class AdminDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('admins', __DIR__ . '/../config/sql/admins_queries.json');
    }

    /**
     * 根据管理员ID获取管理员信息
     *
     * @param int $admin_id 管理员ID
     * @return array 管理员信息的关联数组，键为列名，值为列值
     */
    public function getAdminById($admin_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'getAdminById'));
        $stmt->execute([$admin_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 获取所有管理员信息
     *
     * @return array 包含所有管理员信息的关联数组
     */
    public function getAllAdmins() {
        $stmt = $this->db->query(SQLQueries::getQuery('admins', 'getAllAdmins'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 插入新的管理员记录
     *
     * @param Admin $admin 管理员对象
     * @return void
     */
    public function insertAdmin($admin) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'insertAdmin'));
        $stmt->execute([
            $admin->getName(),
            $admin->getEmail(),
            $admin->getPassword()
        ]);
    }

    /**
     * 更新管理员记录
     *
     * @param Admin $admin 管理员对象
     * @return void
     */
    public function updateAdmin($admin) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'updateAdmin'));
        $stmt->execute([
            $admin->getName(),
            $admin->getEmail(),
            $admin->getPassword(),
            $admin->getid()
        ]);
    }

    /**
     * 删除管理员记录
     *
     * @param int $admin_id 管理员ID
     * @return void
     */
    public function deleteAdmin($admin_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'deleteAdmin'));
        $stmt->execute([$admin_id]);
    }

    /**
     * 根据管理员Email获取管理员信息
     *
     * @param string $email 管理员Email
     * @return array 管理员信息的关联数组，键为列名，值为列值
     */
    public function getAdminByEmail($email) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'getAdminByEmail'));
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>