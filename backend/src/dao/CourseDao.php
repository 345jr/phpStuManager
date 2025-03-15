<?php

require_once __DIR__ . '/SQLQueries.php';

class CourseDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        SQLQueries::loadQueries('courses', __DIR__ . '/../config/sql/courses_queries.json');
    }

    /**
     * 根据课程ID获取课程信息
     *
     * @param int $course_id 课程ID
     * @return array 课程信息的关联数组，键为列名，值为列值
     */
    public function getCourseById($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'getCourseById'));
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 获取所有课程信息
     *
     * @return array 包含所有课程信息的关联数组
     */
    public function getAllCourses() {
        $stmt = $this->db->query(SQLQueries::getQuery('courses', 'getAllCourses'));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 插入新的课程记录
     *
     * @param Course $course 课程对象
     * @return void
     */
    public function insertCourse($course) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'insertCourse'));
        $stmt->execute([
            $course->getCourseName(),
            $course->getMaxStudents(),
            $course->getBrief(),
            $course->getDescription(),
            $course->getTeacher(),
            $course->getStartTime(),
            $course->getClassHour(),
            $course->getCurrentNum(),
            $course->getCourseTag()
        ]);
    }

    /**
     * 更新课程记录
     *
     * @param Course $course 课程对象
     * @return void
     */
    public function updateCourse($course) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'updateCourse'));
        $stmt->execute([
            $course->getCourseName(),
            $course->getMaxStudents(),
            $course->getBrief(),
            $course->getDescription(),
            $course->getTeacher(),
            $course->getStartTime(),
            $course->getClassHour(),
            $course->getCurrentNum(),
            $course->getCourseTag(),
            $course->getCourseId()
        ]);
    }

    /**
     * 删除课程记录
     *
     * @param int $course_id 课程ID
     * @return void
     */
    public function deleteCourse($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'deleteCourse'));
        $stmt->execute([$course_id]);
    }

    /**
     * 增加课程的当前选课人数
     *
     * @param int $course_id 课程ID
     * @return void
     */
    public function incrementCurrentNum($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'incrementCurrentNum'));
        $stmt->execute([$course_id]);
    }

    /**
     * 减少课程的当前选课人数
     *
     * @param int $course_id 课程ID
     * @return void
     */
    public function decrementCurrentNum($course_id) {
        $stmt = $this->db->prepare(SQLQueries::getQuery('courses', 'decrementCurrentNum'));
        $stmt->execute([$course_id]);
    }
}
?>