<?php

namespace Eduteca\EdutecaBundle\Repository\impl;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Repository\CourseRepository;
use Eduteca\EdutecaBundle\Repository\impl\BaseRepository;
use Eduteca\EdutecaBundle\Repository\impl\CriteriaOption;

class CourseRepositoryImpl extends BaseRepository implements CourseRepository
{
    private $em;
    private $logger;
    
    public function __construct(EntityManager $em, Logger $logger)
    { 
        $this->em = $em;
        $this->logger = $logger;
    }
            
    public function saveCourse(Course $course)
    {
        $this->em->persist($course);
        $this->em->flush();
    }
    
    private function buildFindCourseQuery(Course $course,$strictCourseName)
    {
        $qb = $this->em->createQueryBuilder();
        
        $qb->add('select', 'c');
        $qb->add('from', 'EdutecaBundle:Course c');
        
        $qb = $this->addConstrain($qb, $course->getCourseId(), 'c.courseId','courseId', CriteriaOption::EQUAL);
        if ($strictCourseName == true)
        {
            $criteriaCourseName = CriteriaOption::EQUAL;
        }
        else
        {
            $criteriaCourseName = CriteriaOption::LIKE;
        }
        $qb = $this->addConstrain($qb, $course->getCourseName(), 'c.courseName','courseName', $criteriaCourseName);
        
        return $qb;
    }
    
    public function findCourseCount(Course $course, $strictCourseName)
    {
        $qb = $this->buildFindCourseQuery($course, $strictCourseName); 
        $query = $qb->getQuery();
        return count($query->getResult());
    }
    
    public function findCourse(Course $course,$start=0, $limit=0, $strictCourseName=false)
    {
        $qb = $this->buildFindCourseQuery($course, $strictCourseName);
        
        $qb->add('orderBy', 'c.courseName ASC');

        if ($start != 0)
        {
            $qb->setFirstResult($start);
        }
        
        if ($limit != 0)
        {
            $qb->setMaxResults($limit);
        }
        
        $query = $qb->getQuery();
        return $query->getResult();
    }
    
    public function deleteCourse(Course $course)
    {
        $this->em->remove($course);
        $this->em->flush();
    }
}

?>
