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

        function setDateEnrolled($new_date_enrolled)
        {
            $this->new_date_enrolled = $new_date_enrolled;
        }

        function getDateEnrolled()
        {
            return $this->date_enrolled;
        }

        function getStudentId()
        {
            return $this->student_id;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE student_id = {$this->getStudentId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getStudentId()};");
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (student_name, date_enrolled) VALUES ('{$this->getStudentName()}', '{$this->getDateEnrolled()}');");
            $this->student_id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id) VALUES ({$this->getStudentId()}, {$course->getCourseId()});");
        }

        function getCourses()
        {
            $courses = array();
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM
            students JOIN students_courses ON(students.student_id = students_courses.student_id)
            JOIN courses ON(students_courses.course_id = courses.course_id)
            WHERE students.student_id = {$this->getStudentId()};");

            foreach($query as $course) {
                $course_name = $course['course_name'];
                $course_number = $course['course_number'];
                $course_id = $course['course_id'];
                $new_course = new Course($course_name, $course_number, $course_id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student){
                $student_id = $student->getStudentId();
                if ($student_id == $search_id){
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $student_name = $student['student_name'];
                $student_id = $student['student_id'];
                $date_enrolled = $student['date_enrolled'];
                $new_student = new Student($student_name, $date_enrolled, $student_id);
                array_push($students, $new_student);
            }
            return $students;
        }

    }

?>
