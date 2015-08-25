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

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetstudentName()
        {
            //Arrange
            $student_name = "History";
            $student_number = "101";
            $student_id = 1;
            $test_student = new Student($student_name, $student_number, $student_id);

            //Act
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals($student_name, $result);
        }

        function testDeleteAll()
        {
            //arrange
            $student_id = 1;
            $student_name = "History";
            $student_number = "101";
            $test_student = new Student($student_name, $student_number, $student_id);
            $test_student->save();

            $student_id2 = 2;
            $student_name2 = "Math";
            $student_number2 = "25";
            $test_student2 = new Student($student_name2, $student_number2, $student_id2);
            $test_student2->save();

            //act
            Student::deleteAll();

            //assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testSave()
        {
            //Arrange
            $student_id = 1;
            $student_name = "History";
            $date_enrolled = "2015-12-12";
            $test_student = new Student($student_name, $date_enrolled);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function testFind()
        {
            //arrange
            $student_name = "Chemistry";
            $student_id = 1;
            $student_number = "2015-12-12";
            $test_student = new Student($student_name, $student_number, $student_id);
            $test_student->save();

            $student_name2 = "Underwater Basketweaving";
            $student_id2 = 2;
            $student_number2 = "2015-12-12";
            $test_student2 = new Student($student_name2, $student_number2, $student_id2);
            $test_student2->save();

            //act
            $result = Student::find($test_student->getStudentId());

            //assert
            $this->assertEquals($test_student, $result);
        }

        // function testUpdateStudentName()
        // {
        //     //Arrange
        //     $student_name = "Chemistry";
        //     $student_id = 1;
        //     $student_number = "1000";
        //     $test_student = new tudent($student_name, $student_number, $student_id);
        //     $test_student->save();
        //
        //     $new_student_name = "Fun with Chemistry - How to Make Bacon Bits";
        //
        //     //Act
        //     $test_student->updatestudentName($new_student_name);
        //
        //     //Assert
        //     $this->assertEquals("Fun with Chemistry - How to Make Bacon Bits", $test_student->getstudentName());
        // }
        //
        // function testUpdatestudentNumber()
        // {
        //     //Arrange
        //     $student_name = "Chemistry";
        //     $student_id = 1;
        //     $student_number = "1000";
        //     $test_student = new student($student_name, $student_number, $student_id);
        //     $test_student->save();
        //
        //     $new_student_number = "1001";
        //
        //     //Act
        //     $test_student->updatestudentNumber($new_student_number);
        //
        //     //Assert
        //     $this->assertEquals("1001", $test_student->getstudentNumber());
        // }

        // function testDeletestudent()
        // {
        //     //Arrange
        //     $student_name = "Chemistry";
        //     $student_id = 1;
        //     $student_number = "1000";
        //     $test_student = new student($student_name, $student_number, $student_id);
        //     $test_student->save();
        //
        //     $student_name2 = "Underwater Basketweaving";
        //     $student_id2 = 2;
        //     $student_number2 = "2531";
        //     $test_student2 = new student($student_name2, $student_number2, $student_id2);
        //     $test_student2->save();
        //
        //     //Act
        //     $test_student->deletestudent();
        //
        //     //Assert
        //     $this->assertEquals([$test_student2], student::getAll());
        // }

        function testAddCourse()
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
            $test_student->addCourse($test_course);

            //Assert
            $var = $test_student->getCourses();
            $this->assertEquals([$test_course], $var);
        }

        function testGetCourses()
        {
            //Arrange
            $date_enrolled = "2015-10-10";
            $student_name = "Ben Baker Billington";
            $student_id = 1;
            $test_student = new Student($student_name, $date_enrolled, $student_id);
            $test_student->save();

            $course_name2 = "Billy Joe Jim Bob";
            $course_id2 = 2;
            $test_course2 = new Course($course_name2, $date_enrolled, $course_id2);
            $test_course2->save();

            $course_name = "Jammin it, dude";
            $course_number = "102";
            $course_id = 3;
            $test_course = new Course($course_name, $course_number, $course_id);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            //Assert
            $this->assertEquals([$test_course, $test_course2], $test_student->getCourses());
        }


    }



?>
