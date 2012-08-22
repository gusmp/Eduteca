<?php

namespace Eduteca\EdutecaBundle\Tests\Repository;


use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Repository\ContentRepository;
use Eduteca\EdutecaBundle\Repository\impl\ContentRepositoryImpl;
use Eduteca\EdutecaBundle\Tests\ContainerAwareUnitTestCase;


class ContentServiceTest extends ContainerAwareUnitTestCase
{
    /**
     * @var ContentRepository 
     */
    private $contentService;
    
    /**
     * @var CourseRepository 
     */
    private $courseService;
    
    /**
     * @var type string
     */
    private $titleTest = 'titleTest';
    
    /**
     * @var type string
     */
    private $descriptionTest = 'descriptionTest';
    
    /**
     * @var type string
     */
    private $pathTest = 'pathTest';
    
    /**
     * @var type boolean
     */
    private $publishedTest = true;
    
    public function __construct()
    {
        $this->setUpBeforeClass();
        $this->contentService = $this->get('contentService');
        $this->courseService = $this->get('courseService');
    }
    
    public function testContent()
    {
        $sufix = "_TMP";
        
        // insert
        $content = new Content();
        
        $content->setTitle($this->titleTest);
        $content->setDescription($this->descriptionTest);
        $content->setPath($this->pathTest);
        $content->setPublished($this->publishedTest);
        $content->setDate(new \DateTime("now"));
        
        $course = new Course();
        $course->setCourseName("First course");
        $content->setCourse($course);
        //$content->setCourseId($courseId);
        
        $content->setUser(null);
        //$content->setUserId($userId);
        
        $this->contentService->saveContent($content);
        
        // recover
        $content = new Content();
        $content->setTitle($this->titleTest);
        $contentList = $this->contentService->findContent($content);
        $this->assertEquals(1, count($contentList));
        
        // update
        $this->titleTest = $this->titleTest.$sufix;
        $contentList[0]->setTitle($this->titleTest);
        $this->contentService->saveContent($contentList[0]);
        
        $content->setTitle($this->titleTest);
        $contentList = $this->contentService->findContent($content);
        $this->assertEquals(1, count($contentList));
        
        // delete
        $course = $contentList[0]->getCourse();
        $this->contentService->deleteContent($contentList[0]);
        $contentList = $this->contentService->findContent($content);
        $this->assertEquals(0, count($contentList));
        
        $this->courseService->deleteCourse($course);
    }
}
?>
