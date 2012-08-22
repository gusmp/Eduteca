<?php

namespace Eduteca\EdutecaBundle\Repository;

use Eduteca\EdutecaBundle\Entity\Course;

interface CourseRepository
{
    public function saveCourse(Course $course);
    public function findCourseCount(Course $course, $strictCourseName);
    public function findCourse(Course $course, $start, $limit, $strictCourseName);
    public function deleteCourse(Course $course);
}

?>
