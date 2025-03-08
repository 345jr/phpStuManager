<?php

class Course {
    private $course_id;
    private $course_name;
    private $max_students;
    private $brief; // 简介
    private $description; // 描述
    private $teacher;
    private $start_time;
    private $class_hour;
    private $current_num;
    private $course_tag;

    const VALID_COURSE_TAGS = ['math', 'physics', 'chemistry', 'biology', 'computer'];

    public function __construct($course_id, $course_name, $max_students, $brief, $description, $teacher, $start_time, $class_hour, $current_num, $course_tag) {
        $this->course_id = $course_id;
        $this->course_name = $course_name;
        $this->max_students = $max_students;
        $this->brief = $brief;
        $this->description = $description;
        $this->teacher = $teacher;
        $this->start_time = $start_time;
        $this->class_hour = $class_hour;
        $this->current_num = $current_num;
        $this->setCourseTag($course_tag);
    }

    public function getCourseId() {
        return $this->course_id;
    }

    public function setCourseId($course_id) {
        $this->course_id = $course_id;
    }

    public function getCourseName() {
        return $this->course_name;
    }

    public function setCourseName($course_name) {
        $this->course_name = $course_name;
    }

    public function getMaxStudents() {
        return $this->max_students;
    }

    public function setMaxStudents($max_students) {
        $this->max_students = $max_students;
    }

    public function getBrief() {
        return $this->brief;
    }

    public function setBrief($brief) {
        $this->brief = $brief;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getTeacher() {
        return $this->teacher;
    }

    public function setTeacher($teacher) {
        $this->teacher = $teacher;
    }

    public function getStartTime() {
        return $this->start_time;
    }

    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    public function getClassHour() {
        return $this->class_hour;
    }

    public function setClassHour($class_hour) {
        $this->class_hour = $class_hour;
    }

    public function getCurrentNum() {
        return $this->current_num;
    }

    public function setCurrentNum($current_num) {
        $this->current_num = $current_num;
    }

    public function getCourseTag() {
        return $this->course_tag;
    }

    public function setCourseTag($course_tag) {
        if (!in_array($course_tag, self::VALID_COURSE_TAGS)) {
            throw new InvalidArgumentException("Invalid course tag: $course_tag");
        }
        $this->course_tag = $course_tag;
    }
}
?>