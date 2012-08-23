<?php

namespace Eduteca\EdutecaBundle\Tests\Repository;


use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Repository\CourseRepository;
use Eduteca\EdutecaBundle\Repository\impl\CourseRepositoryImpl;
use Eduteca\EdutecaBundle\Tests\ContainerAwareUnitTestCase;


class CourseServiceTest extends ContainerAwareUnitTestCase
{
    /**
     * @var CourseRepository 
     */
    private $courseService;
    
    /**
     * @var type string
     */
    private $courseNameTest = 'courseTest';
    

    public function __construct()
    {
        $this->setUpBeforeClass();
        $this->courseService = $this->get('courseService');
    }
    
    public function testCourse()
    {
        $sufix = '_TMP';
       
        // insert
        $course = new Course();
        $course->setCourseName($this->courseNameTest);
        $this->courseService->saveCourse($course);
        
        // recover
        $course = new Course();
        $course->setCourseName($this->courseNameTest);
        $courseList = $this->courseService->findCourse($course);
        $this->assertEquals(1, count($courseList));
        
        // update
        $this->courseNameTest = $this->courseNameTest.$sufix;
        $courseList[0]->setCourseName($this->courseNameTest);
        $this->courseService->saveCourse($courseList[0]);
        
        $course->setCourseName($this->courseNameTest);
        $courseList = $this->courseService->findCourse($course);
        $this->assertEquals(1, count($courseList));
        
        // delete
        $this->courseService->deleteCourse($courseList[0]);
        
        $courseList = $this->courseService->findCourse($course);
        $this->assertEquals(0, count($courseList));

    }
}
?>
