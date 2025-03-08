<?php
    class Student{
      private $id;
      private $name;
      private $email;
      private $password;

      public function __construct($id, $name, $email, $password){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
      }

      //getter
      public function getid(){
        return $this->id;
      }

      public function getName(){
        return $this->name;
      }

      public function getEmail(){
        return $this->email;
      }

      public function getPassword(){
        return $this->password;
      }

      //setter
      public function setid($id){
        $this->id = $id;
      }

      public function setName($name){
        $this->name = $name;
      }

      public function setEmail($email){
        $this->email = $email;
      }

      public function setPassword($password){
        $this->password = $password;
      }
    }
?>