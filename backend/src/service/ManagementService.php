<?php

require_once __DIR__ . '/../dao/StudentDao.php';
require_once __DIR__ . '/../dao/CourseDao.php';

class ManagementService {
    private $studentDAO;
    private $courseDAO;

    public function __construct($db) {
        $this->studentDAO = new StudentDAO($db);
        $this->courseDAO = new CourseDAO($db);
    }

    /**
     * 注册新学生
     *
     * @param string $name 学生姓名
     * @param string $email 学生邮箱
     * @param string $password 学生密码
     * @return void
     */
    public function registerStudent($name, $email, $password) {
        $student = new Student(null, $name, $email, $password);
        $this->studentDAO->insertStudent($student);
    }

    /**
     * 注销学生
     *
     * @param int $studentId 学生ID
     * @return void
     */
    public function unregisterStudent($studentId) {
        $this->studentDAO->deleteStudent($studentId);
    }

    /**
     * 注册新课程
     *
     * @param string $courseName 课程名称
     * @param int $maxStudents 最大学生人数
     * @param string $brief 课程简介
     * @param string $description 课程详细描述
     * @param string $teacher 教师姓名
     * @param string $startTime 开课时间
     * @param int $classHour 课程时长
     * @param string $courseTag 课程标签
     * @return void
     */
    public function registerCourse($courseName, $maxStudents, $brief, $description, $teacher, $startTime, $classHour, $courseTag) {
        $course = new Course(null, $courseName, $maxStudents, $brief, $description, $teacher, $startTime, $classHour, 0, $courseTag);
        $this->courseDAO->insertCourse($course);
    }

    /**
     * 注销课程
     *
     * @param int $courseId 课程ID
     * @return void
     */
    public function unregisterCourse($courseId) {
        $this->courseDAO->deleteCourse($courseId);
    }
}
?>