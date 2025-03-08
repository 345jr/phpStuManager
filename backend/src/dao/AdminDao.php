<?php

require_once __DIR__ . '/SQLQueries.php';

class AdminDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('admins', __DIR__ . '/../config/sql/admins_queries.json');
    }

    public function getAdminById($admin_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'getAdminById'));
        $stmt->execute([$admin_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAdmins() {
        $stmt = $this->db->query(SQLQueries::getQuery('admins', 'getAllAdmins'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertAdmin($admin) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'insertAdmin'));
        $stmt->execute([
            $admin->getName(),
            $admin->getEmail(),
            $admin->getPassword()
        ]);
    }

    public function updateAdmin($admin) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'updateAdmin'));
        $stmt->execute([
            $admin->getName(),
            $admin->getEmail(),
            $admin->getPassword(),
            $admin->getAdminId()
        ]);
    }

    public function deleteAdmin($admin_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'deleteAdmin'));
        $stmt->execute([$admin_id]);
    }

    public function getAdminByEmail($email) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('admins', 'getAdminByEmail'));
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>