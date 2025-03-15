<?php

require_once __DIR__ . '/SQLQueries.php';

class StudentDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('students', __DIR__ . '/../config/sql/students_queries.json');
    }

    /**
     * 根据学生ID获取学生信息
     *
     * @param int $student_id 学生ID
     * @return array 学生信息的关联数组，键为列名，值为列值
     */
    public function getStudentById($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'getStudentById'));
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 获取所有学生信息
     *
     * @return array 包含所有学生信息的关联数组
     */
    public function getAllStudents() {
        $stmt = $this->db->query(SQLQueries::getQuery('students', 'getAllStudents'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 插入新的学生记录
     *
     * @param Student $student 学生对象
     * @return void
     */
    public function insertStudent($student) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'insertStudent'));
        $stmt->execute([
            $student->getName(),
            $student->getEmail(),
            $student->getPassword()
        ]);
    }

    /**
     * 更新学生记录
     *
     * @param Student $student 学生对象
     * @return void
     */
    public function updateStudent($student) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'updateStudent'));
        $stmt->execute([
            $student->getName(),
            $student->getEmail(),
            $student->getPassword(),
            $student->getid()
        ]);
    }

    /**
     * 删除学生记录
     *
     * @param int $student_id 学生ID
     * @return void
     */
    public function deleteStudent($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'deleteStudent'));
        $stmt->execute([$student_id]);
    }

    /**
     * 根据学生Email获取学生信息
     *
     * @param string $email 学生Email
     * @return array 学生信息的关联数组，键为列名，值为列值
     */
    public function getStudentByEmail($email) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('students', 'getStudentByEmail'));
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>