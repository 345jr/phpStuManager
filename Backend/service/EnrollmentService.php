<?php
require_once __DIR__ . '/../model/Enrollment.php';
require_once __DIR__ . '/../dao/EnrollmentDAO.php';
require_once __DIR__ . '/../dao/CourseDAO.php';

class EnrollmentService {
    private $enrollmentDAO;
    private $courseDAO;

    public function __construct($db) {
        $this->enrollmentDAO = new EnrollmentDAO($db);
        $this->courseDAO = new CourseDAO($db);
    }

    // 管理员为多个学生选课
    public function enrollStudentsInCourse($studentIds, $courseId) {
        foreach ($studentIds as $studentId) {
            $this->enrollStudentInCourse($studentId, $courseId);
        }
    }

    // 学生选课
    public function enrollStudentInCourse($studentId, $courseId) {
        // 检查学生是否已经选了一门课程
        $existingEnrollments = $this->enrollmentDAO->getEnrollmentsByStudentId($studentId);
        if (count($existingEnrollments) > 0) {
            throw new Exception("学生已经选了一门课程");
        }

        // 更新课程的当前选课人数
        $this->courseDAO->incrementCurrentNum($courseId);

        // 为学生插入选课记录
        $enrollment = new Enrollment(null, $studentId, $courseId);
        $this->enrollmentDAO->insertEnrollment($enrollment);
    }

    // 取消学生的选课
    public function unenrollStudentFromCourse($studentId, $courseId) {
        // 更新课程的当前选课人数
        $this->courseDAO->decrementCurrentNum($courseId);

        // 删除选课记录
        $this->enrollmentDAO->deleteEnrollmentByStudentAndCourse($studentId, $courseId);
    }

    //查询学生已选课程
    public function getEnrollmentsByStudentId($studentId){
      return $this->enrollmentDAO->getEnrollmentsByStudentId($studentId);
    }
}
?>