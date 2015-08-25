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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number)
                VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
            $this->course_id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $course_name = $course['course_name'];
                $course_id = $course['course_id'];
                $course_number = $course['course_number'];
                $new_course = new Course($course_name, $course_number, $course_id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course){
                $course_id = $course->getCourseId();
                if ($course_id == $search_id){
                    $found_course = $course;
                }
            }
            return $found_course;
        }

        function updateCourseName($new_course_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}' WHERE course_id = {$this->getCourseId()};");
            $this->setCourseName($new_course_name);
        }

        function updateCourseNumber($new_course_number)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_number = '{$new_course_number}' WHERE course_id = {$this->getCourseId()};");
            $this->setCourseNumber($new_course_number);
        }

        function deleteCourse()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE course_id = {$this->getCourseId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE course_id = {$this->getCourseId()};");
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id)
            VALUES ({$student->getStudentId()}, {$this->getCourseId()});");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT students.* FROM
            courses JOIN students_courses ON(courses.course_id = students_courses.course_id)
            JOIN students ON(students_courses.student_id = students.student_id)
            WHERE courses.course_id = {$this->getCourseId()}");
        }







    }
?>
