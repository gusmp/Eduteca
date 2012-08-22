<?php

namespace Eduteca\EdutecaBundle\Service\impl;

use Eduteca\EdutecaBundle\Repository\CourseRepository;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Service\CourseService;

class CourseServiceImpl implements CourseService
{
    private $courseRepository;
    
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
            
    public function saveCourse(Course $course)
    {
        $this->courseRepository->saveCourse($course);
    }
    
    public function findCourseCount(Course $course, $strictCourseName)
    {
        return $this->courseRepository->findCourseCount($course, $strictCourseName);
    }
    
    public function findCourse(Course $course,$start=0, $limit=0, $strictCourseName=false)
    {
        return $this->courseRepository->findCourse($course, $start, $limit, $strictCourseName);
    }
    
    public function findCourseArray(Course $course, $start=0, $limit=0, $strictCourseName=false)
    {
        $courseArray = array();
        $courseList = $this->courseRepository->findCourse($course, $start, $limit, $strictCourseName);
        foreach ($courseList as $index => $course) 
        {
            $courseArray[$course->getCourseId()] = $course->getCourseName();
        }
        
        return $courseArray;
    }
    
    public function deleteCourse(Course $course)
    {
        return $this->courseRepository->deleteCourse($course);
    }
}

?>
