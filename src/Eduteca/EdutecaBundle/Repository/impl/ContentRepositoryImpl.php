<?php

namespace Eduteca\EdutecaBundle\Repository\impl;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\DateRange;
use Eduteca\EdutecaBundle\Repository\ContentRepository;
use Eduteca\EdutecaBundle\Repository\impl\BaseRepository;
use Eduteca\EdutecaBundle\Repository\impl\CriteriaOption;
use Eduteca\EdutecaBundle\Repository\CourseRepository;

class ContentRepositoryImpl extends BaseRepository implements ContentRepository
{
    private $em;
    private $logger;
    private $courseRepository;
    
    public function __construct(EntityManager $em, Logger $logger, CourseRepository $courseRepository)
    { 
        $this->em = $em;
        $this->logger = $logger;
        $this->courseRepository = $courseRepository;
    }
    
    private function storeContent(Content $content)
    {
        $this->em->persist($content);
        $this->em->flush();
    }
            
    public function saveContent(Content $content)
    {
        $this->storeContent($content);
    }
    
    public function updateContent(Content $content, $oldFile)
    {
        if ($oldFile != null)
        {
            unlink($oldFile);
        }
        $this->storeContent($content);
    }
    
    private function buildFindContentQuery(Content $content,$strictContentTitle, DateRange $contentDateRange = null)
    {
        $qb = $this->em->createQueryBuilder();
        
        $qb->select('c');
        $qb->add('from','EdutecaBundle:Content c INNER JOIN c.course course INNER JOIN c.user user',false);
        
        $qb = $this->addConstrain($qb, $content->getContentId() , 'c.contentId','contentId', CriteriaOption::EQUAL);
        $qb = $this->addConstrain($qb, $content->getCourse()->getCourseId() , 'course.courseId','courseId', CriteriaOption::EQUAL);
        $qb = $this->addConstrain($qb, $content->getUser()->getUserId() , 'user.userId','userId', CriteriaOption::EQUAL);

        if ($strictContentTitle == true)
        {
            $criteriaContentTitle = CriteriaOption::EQUAL;
        }
        else
        {
            $criteriaContentTitle = CriteriaOption::LIKE;
        }
        
        if ($contentDateRange != null)
        {
            if ($contentDateRange->getStartDate() != null)
            {
                $qb = $this->addConstrain($qb, $contentDateRange->getStartDate(), 'c.date','startDate', CriteriaOption::GREAT_OR_EQUAL);
            }
            if ($contentDateRange->getEndDate() != null)
            {
                $qb = $this->addConstrain($qb, $contentDateRange->getEndDate(), 'c.date','endDate', CriteriaOption::LESS_OR_EQUAL);
            }
        }
        
        $qb = $this->addConstrain($qb, $content->getTitle(), 'c.title','title', $criteriaContentTitle);
        $qb = $this->addConstrain($qb, $content->getDescription(), 'c.description','description', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $content->getPublished(), 'c.published','published', CriteriaOption::EQUAL);
        
        return $qb;
    }
    
    public function findContentCount(Content $content, $strictContentTitle, DateRange $contentDateRange)
    {
        $qb = $this->buildFindContentQuery($content, $strictContentTitle, $contentDateRange); 
        $query = $qb->getQuery();
        return count($query->getResult());
    }
    
    public function findContent(Content $content,$start=0, $limit=0, $strictContentTitle=false, DateRange $contentDateRange=null)
    {
        $qb = $this->buildFindContentQuery($content, $strictContentTitle, $contentDateRange);
        
        $qb->add('orderBy', 'c.title ASC');
        
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
    
    public function deleteContent(Content $content)
    {
        $this->em->remove($content);
        $this->em->flush();
        unlink($content->getAbsolutePath());
    }
    
}


?>
