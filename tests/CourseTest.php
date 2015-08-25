<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    // require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
        //    Student::deleteAll();
            Course::deleteAll();
        }

        function testGetCourseName()
        {
            //Arrange
            $course_name = "History";
            $course_number = "101";
            $course_id = 1;
            $test_course = new Course($course_name, $course_number, $course_id);

            //Act
            $result = $test_course->getCourseName();

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
          var_dump($result[0]);
          $this->assertEquals($test_course, $result[0]);
        }

    }



?>
