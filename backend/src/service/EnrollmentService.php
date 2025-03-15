<?php
require_once __DIR__ . '/../model/Enrollment.php';
require_once __DIR__ . '/../dao/EnrollmentDao.php';
require_once __DIR__ . '/../dao/CourseDao.php';

class EnrollmentService {
    private $enrollmentDAO;
    private $courseDAO;

    public function __construct($db) {
        $this->enrollmentDAO = new EnrollmentDAO($db);
        $this->courseDAO = new CourseDAO($db);
    }

    // 管理员为多个学生选课
    /**
     * 为多个学生选课
     *
     * @param int[] $studentIds 学生ID列表
     * @param int $courseId 课程ID
     * @return void
     */
    public function enrollStudentsInCourse($studentIds, $courseId) {
        foreach ($studentIds as $studentId) {
            $this->enrollStudentInCourse($studentId, $courseId);
        }
    }

    // 学生选课
    /**
     * 学生选课，每个学生最多只能选两门课
     *
     * @param int $studentId 学生ID
     * @param int $courseId 课程ID
     * @return void
     * @throws Exception 如果学生已经选了两门课程或已选此课程
     */
    public function enrollStudentInCourse($studentId, $courseId) {
        // 检查学生是否已经选了两门课程
        $existingEnrollments = $this->enrollmentDAO->getEnrollmentsByStudentId($studentId);
        if (count($existingEnrollments) >= 2) { // 修改为 >= 2，确保不超过两门
            throw new Exception("学生已经选了两门课程");
        }

        // 检查学生是否已经选了此课程
        $existingEnrollments = $this->enrollmentDAO->getEnrollmentByStudentAndCourse($studentId, $courseId);
        if (count($existingEnrollments) > 0) {
            throw new Exception("学生已经选了课程");
        }

        // 更新课程的当前选课人数
        $this->courseDAO->incrementCurrentNum($courseId);

        // 为学生插入选课记录
        $enrollment = new Enrollment(null, $studentId, $courseId);
        $this->enrollmentDAO->insertEnrollment($enrollment);
    }

    // 取消学生的选课
    /**
     * 取消学生的选课
     *
     * @param int $studentId 学生ID
     * @param int $courseId 课程ID
     * @return void
     */
    public function unenrollStudentFromCourse($studentId, $courseId) {
        // 更新课程的当前选课人数
        $this->courseDAO->decrementCurrentNum($courseId);

        // 删除选课记录
        $this->enrollmentDAO->deleteEnrollmentByStudentAndCourse($studentId, $courseId);
    }

    // 查询学生已选课程
    /**
     * 查询学生已选课程
     *
     * @param int $studentId 学生ID
     * @return array 选课记录的关联数组，键为列名，值为列值
     *               如果没有记录，返回一个空数组
     */
    public function getEnrollmentsByStudentId($studentId) {
        return $this->enrollmentDAO->getEnrollmentsByStudentId($studentId);
    }
}
?>