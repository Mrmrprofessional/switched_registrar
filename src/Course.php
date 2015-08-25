<?php
    class Course
    {
        private $course_name;
        private $course_number;
        private $course_id; 

        function __construct($course_name, $course_number, $course_id=null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->course_id = $course_id;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = (string) $new_course_name;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = (string) $new_course_number;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function getCourseId()
        {
            return $this->course_id;
        }


?>
