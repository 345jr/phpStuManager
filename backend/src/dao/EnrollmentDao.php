<?php

require_once __DIR__ . '/SQLQueries.php';

class EnrollmentDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('enrollments', __DIR__ . '/../config/sql/enrollments_queries.json');
    }

    /**
     * 根据选课ID获取选课记录
     *
     * @param int $enrollment_id 选课ID
     * @return array 选课记录的关联数组，键为列名，值为列值
     */
    public function getEnrollmentById($enrollment_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'getEnrollmentById'));
        $stmt->execute([$enrollment_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 获取所有选课记录
     *
     * @return array 包含所有选课记录的关联数组
     */
    public function getAllEnrollments() {
        $stmt = $this->db->query(SQLQueries::getQuery('enrollments', 'getAllEnrollments'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 插入新的选课记录
     *
     * @param Enrollment $enrollment 选课记录对象
     * @return void
     */
    public function insertEnrollment($enrollment) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'insertEnrollment'));
        $stmt->execute([
            $enrollment->getStudent_id(),
            $enrollment->getCourses_id()
        ]);
    }

    /**
     * 更新选课记录
     *
     * @param Enrollment $enrollment 选课记录对象
     * @return void
     */
    public function updateEnrollment($enrollment) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'updateEnrollment'));
        $stmt->execute([
            $enrollment->getStudent_id(),
            $enrollment->getCourses_id(),
            $enrollment->getEnrollment_id()
        ]);
    }

    /**
     * 删除选课记录
     *
     * @param int $enrollment_id 选课ID
     * @return void
     */
    public function deleteEnrollment($enrollment_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'deleteEnrollment'));
        $stmt->execute([$enrollment_id]);
    }

    /**
     * 根据学生ID获取选课记录
     *
     * @param int $student_id 学生ID
     * @return array 包含选课记录的关联数组
     */
    public function getEnrollmentsByStudentId($student_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'getEnrollmentsByStudentId'));
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 根据学生ID和课程ID删除选课记录
     *
     * @param int $student_id 学生ID
     * @param int $course_id 课程ID
     * @return void
     */
    public function deleteEnrollmentByStudentAndCourse($student_id, $course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'deleteEnrollmentByStudentAndCourse'));
        $stmt->execute([$student_id, $course_id]);
    }

    /**
     * 根据学生ID和课程ID获取选课记录
     *
     * @param int $student_id 学生ID
     * @param int $course_id 课程ID
     * @return array 包含选课记录的关联数组
     */
    public function getEnrollmentByStudentAndCourse($student_id, $course_id){
        $stmt = $this->db->prepare(SQLQueries::getQuery('enrollments', 'getEnrollmentByStudentAndCourse'));
        $stmt->execute([$student_id, $course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>