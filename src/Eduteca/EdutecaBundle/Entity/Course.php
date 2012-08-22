<?php

namespace Eduteca\EdutecaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="COURSE")
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\Column(name="COURSE_ID", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $courseId;
    
    /**
     * @ORM\Column(name="COURSE_NAME", type="string",length=100)
     * @var string
     */
    private $courseName;
    
    /**
     * @ORM\OneToMany(targetEntity="Content", mappedBy="course", cascade={"persist", "remove"})
     */
    private $contentList;
    
    /* Constructor  */
    public function __construct()
    {
        $this->contentList = new ArrayCollection();
    }
    
    /* Getters and setters */
    public function getCourseId() { return $this->courseId; }
    public function setCourseId($courseId) { $this->courseId = $courseId; }

    public function getCourseName() { return $this->courseName; }
    public function setCourseName($courseName) { $this->courseName = $courseName; }
    
    public function getContentList() { return $this->contentList; }
    public function setContentList($contentList) { $this->contentList = $contentList; }
 
    
    /**
     * Add materialList
     *
     * @param Eduteca\EdutecaBundle\Entity\Material $materialList
     */
    public function addContent(\Eduteca\EdutecaBundle\Entity\Content $contentList)
    {
        $this->contentList[] = $contentList;
    }
    
}