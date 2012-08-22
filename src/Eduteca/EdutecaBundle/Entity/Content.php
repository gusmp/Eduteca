<?php

namespace Eduteca\EdutecaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="CONTENT")
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\Column(name="CONTENT_ID", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $contentId;
    
    /**
     * @ORM\Column(name="TITLE", type="string", length=255)
     * @var type string
     */
    private $title;
    
    /**
     * @ORM\Column(name="DESCRIPTION", type="string", length=2000)
     * @Assert\NotBlank()
     * @var type string
     */
    private $description;
    
    /**
     * @ORM\Column(name="PATH", type="string", length=255)
     * @var string 
     */
    private $path;
    
    /**
     * @Assert\File(maxSize="6000000", mimeTypes={"image/jpeg", "text/plain", "application/vnd.oasis.opendocument.text", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf"})
     */
    private $file;
    
    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="contentList", cascade={"persist"})
     * @ORM\JoinColumn(name="COURSE_ID", referencedColumnName="COURSE_ID") 
     */
    private $course;
    
    /**
     * @var int
     */
    private $courseId;
    
    /**
     * @ORM\Column(name="PUBLISHED", type="boolean")
     * @var bool
     */
    private $published;
    
    /**
     * @ORM\Column(name="DATE", type="datetime")
     * @var type datetime
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userList", cascade={"persist"})
     * @ORM\JoinColumn(name="USER_ID", referencedColumnName="USER_ID")
     * @var int
     */
    private $user;
    
    
    /* Constructor  */
    public function __construct()
    {
        $this->course = new Course();
        $this->user = new User();
    }
    
    public static function constructWithId($contentId)
    {
        $instance = new self();
        $instance->contentId = $contentId;
        $instance->course = new Course();
        return($instance);
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        //return __DIR__.'/../../../../web/'.$this->getUploadDir();
        return __DIR__.'/../../../../'.$this->getUploadDir();
    }
    
    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) 
        {
            return;
        }
        $prefix = date('YmdHis_');
        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadRootDir(), $prefix.$this->file->getClientOriginalName());
        // set the path property to the filename where you'ved saved the file
        $this->path = $prefix.$this->file->getClientOriginalName();
        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
    public function getMimeType()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $this->getAbsolutePath());
        finfo_close($finfo);
        return($mimeType);
    }
    
    /* Getters and setters */
    public function getContentId() { return $this->contentId; }
    public function setContentId($contentId) { $this->contentId = $contentId; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    
    public function getPath() { return $this->path; }
    public function setPath($path) { $this->path = $path; }
    
    public function getFile() { return $this->file; }
    public function setFile($file) { $this->file = $file; }
     
    public function getCourse() { return $this->course; }
    public function setCourse($course) { $this->course = $course; }
    
    public function getCourseId() { return $this->courseId; }
    public function setCourseId($courseId) { $this->courseId = $courseId; }
    
    public function getPublished() { return $this->published; }
    public function setPublished($published) { $this->published = $published; }

    public function getDate() { return $this->date; }
    public function setDate($date) { $this->date = $date; }
 
    public function getUser() { return $this->user; }
    public function setUser($user) { $this->user = $user; }

    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }
    
}