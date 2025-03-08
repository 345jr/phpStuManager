<?php
    class Enrollment{
      private $enrollment_id;
      private $student_id;
      private $course_id;

      public function __construct($enrollment_id, $student_id, $course_id){
        $this->enrollment_id = $enrollment_id;
        $this->student_id = $student_id;
        $this->course_id = $course_id;
      }

      //getter
      public function getEnrollment_id(){
        return $this->enrollment_id;
      }

      public function getStudent_id(){
        return $this->student_id;
      }

      public function getCourses_id(){
        return $this->course_id;
      }

      //setter
      public function setEnrollment_id($enrollment_id){
        $this->enrollment_id = $enrollment_id;
      }

      public function setStudent_id($student_id){
        $this->student_id = $student_id;
      }

      public function setCourse_id($course_id){
        $this->course_id = $course_id;
      }
    }
?>