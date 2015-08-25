<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();
    $app['debug'] = true;
    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');    
    });
    
    $app->get("/courses", function() use ($app) {
       return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll())); 
    });
    
    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });
    
    $app->get("/courses/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    
    $app->get("/students/{id}", function($id) use ($app) {
       $student = Student::find($id);
       return $app['twig']->render("student.html.twig", array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll())); 
    });
    
    $app->post("/courses", function() use ($app) {
        $course_name = $_POST['course_name'];
        $course_number = $_POST['course_number'];
        $course = new Course($course_name, $course_number);
        $course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });
    
    $app->post("/students", function() use ($app) {
       $student_name = $_POST['student_name'];
       $date_enrolled = $_POST['date_enrolled'];
       $student = new Student($student_name, $date_enrolled);
       $student->save();
       return $app['twig']->render('students.html.twig', array( 'students' => Student::getAll())); 
    });
    
    $app->post("/add_student", function() use ($app) {
       $course = Course::find($_POST['course_id']);
       $student = Student::find($_POST['student_id']);
       $course->addStudent($student);
       return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    
    $app->post("/add_course", function() use ($app) {
       $student = Student::find($_POST['student_id']);
       $course = Course::find($_POST['course_id']);
       $student->addCourse($course);
       return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });
    
    return $app;
?>
