<?php
    class Student
    {
        private $student_name;
        private $date_enrolled;
        private $student_id;

        function __construct($student_name, $date_enrolled, $student_id=null)
        {
            $this->student_name = $student_name;
            $this->date_enrolled = $date_enrolled;
            $this->student_id = $student_id;
        }

        function setStudentName($new_student_name)
        {
            $this->student_name = (string) $new_student_name;
        }

        function getStudentName()
        {
            return $this->student_name;
        }

        function setEnrolledDate($new_date_enrolled)
        {
            $this->new_date_enrolled = $new_date_enrolled;
        }

        function getEnrolledDate()
        {
            return $this->date_enrolled;
        }

        function setStudentNumber($new_date_enrolled)
        {
            $this->date_enrolled = (string) $new_date_enrolled;
        }

        function getStudentNumber()
        {
            return $this->date_enrolled;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE student_id = {$this->getStudentId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getStudentId()};");
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (student_name, date_enrolled) VALUES ('{$this->getStudentName()}','{$this->getEnrolledDate()}');");
            $this->student_id = $GLOBALS['DB']->lastInsertId();
        }

    }

?>
