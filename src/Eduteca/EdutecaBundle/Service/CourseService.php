<?php

namespace Eduteca\EdutecaBundle\Service;

use Eduteca\EdutecaBundle\Entity\Course;

interface CourseService
{
    public function saveCourse(Course $course);
    public function findCourseCount(Course $course, $strictCourseName);
    public function findCourse(Course $course, $start, $limit, $strictCourseName);
    public function findCourseArray(Course $course, $start, $limit, $strictCourseName);
    public function deleteCourse(Course $course);
}

?>
