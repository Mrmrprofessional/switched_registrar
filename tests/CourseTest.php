<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetCourseName()
        {
            //Arrange
            $course_name = "History";
            $date_enrolled = "101";
            $id = 1;
            $test_course = new Course($course_name, $date_enrolled, $id);

            //Act
            $result = $test_course->getcourseName();

            //Assert
            $this->assertEquals($course_name, $result);
        }

        function testSetCourseName()
        {
            //Arrange
            $course_name = "History";
            $course_number = "101";
            $course_id = 1;
            $test_course = new Course($course_name, $course_number, $course_id);

            //Act
            $test_course->setCourseName($course_name);
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("History", $result);
        }

        function testDeleteAll()
        {
            //arrange
            $course_id = 1;
            $course_name = "History";
            $course_number = "101";
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            $course_id2 = 2;
            $course_name2 = "Math";
            $course_number2 = "25";
            $test_course2 = new Course($course_name2, $course_number2, $course_id2);
            $test_course2->save();

            //act
            Course::deleteAll();

            //assert
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function testSave()
        {
            //Arrange
            $course_id = 1;
            $course_name = "History";
            $course_number = "101";
            $test_course = new Course($course_name, $course_number, $course_id);

            //Act
            $test_course->save();

            //Assert
            $result = Course::getAll();
            $this->assertEquals($test_course, $result[0]);
        }

        function testFind()
        {
            //arrange
            $course_name = "Chemistry";
            $course_id = 1;
            $course_number = "1000";
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            $course_name2 = "Underwater Basketweaving";
            $course_id2 = 2;
            $course_number2 = "2531";
            $test_course2 = new Course($course_name2, $course_number2, $course_id2);
            $test_course2->save();

            //act
            $result = Course::find($test_course->getCourseId());

            //assert
            $this->assertEquals($test_course, $result);
        }

        function testUpdateCourseName()
        {
            //Arrange
            $course_name = "Chemistry";
            $course_id = 1;
            $course_number = "1000";
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            $new_course_name = "Fun with Chemistry - How to Make Bacon Bits";

            //Act
            $test_course->updateCourseName($new_course_name);

            //Assert
            $this->assertEquals("Fun with Chemistry - How to Make Bacon Bits", $test_course->getCourseName());
        }

        function testUpdateCourseNumber()
        {
            //Arrange
            $course_name = "Chemistry";
            $course_id = 1;
            $course_number = "1000";
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            $new_course_number = "1001";

            //Act
            $test_course->updateCourseNumber($new_course_number);

            //Assert
            $this->assertEquals("1001", $test_course->getCourseNumber());
        }

        function testDeleteCourse()
        {
            //Arrange
            $course_name = "Chemistry";
            $course_id = 1;
            $course_number = "1000";
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            $course_name2 = "Underwater Basketweaving";
            $course_id2 = 2;
            $course_number2 = "2531";
            $test_course2 = new Course($course_name2, $course_number2, $course_id2);
            $test_course2->save();

            //Act
            $test_course->deleteCourse();

            //Assert
            $this->assertEquals([$test_course2], Course::getAll());
        }

        function testAddStudent()
        {
            //arrange
            $student_name = "Ben Baker Billington";
            $date_enrolled = "2015-10-10";
            $student_id = 1;
            $test_student = new Student($student_name, $date_enrolled, $student_id);
            $test_student->save();

            $course_name = "Jammin it, dude";
            $course_number = "102";
            $course_id = 2;
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $var = array();
            $var = $test_course->getStudents();
            $this->assertEquals($var, [$test_student]);
        }

        function testGetStudents()
        {
            //Arrange
            $date_enrolled = "2015-10-10";

            $student_name = "Ben Baker Billington";
            $student_id = 1;
            $test_student = new Student($student_name, $date_enrolled, $student_id);
            $test_student->save();

            $student_name2 = "Billy Joe Jim Bob";
            $student_id2 = 2;
            $test_student2 = new Student($student_name2, $date_enrolled, $student_id2);
            $test_student2->save();

            $course_name = "Jammin it, dude";
            $course_number = "102";
            $course_id = 3;
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }


    }



?>
