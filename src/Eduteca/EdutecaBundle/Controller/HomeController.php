<?php

namespace Eduteca\EdutecaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\Content;

class HomeController extends Controller
{
    
    public function indexAction()
    {
        //$logger = $this->get("service.logger");
        //$logger->err("--We just got the logger");
        //$logger->info("--We just got the logger");
        
        $course = new Course();
        $course->setCourseName("nameCourse!!");
        $id = $course->getCourseId();
        echo isset($id);
        /*
        if (isset($course->getCourseId()))
        {
            echo "NO SET";
        }
         * 
         */
        

        $user = new User();
        $user->setLogin("login");
        $user->setPassword("pwd");
        $user->setName("name");
        $user->setSurname1("surName1");
        $user->setSurname2("surName2");
        $user->setApproved(true);
        $user->setEmail("email@email.com");
        
        $content = new Content();
        $content->setTitle("title");
        $content->setDescription("description");
        $content->setPath("path");
        $content->setCourse($course);
        $content->setPublished(true);
        $content->setUser($user);
        $content->setDate(new \DateTime("now"));
        
        //$repo = $this->get('courseRepository');
        //$repo->saveCourse($course);
        
        //$repo = $this->get('contentRepository');
        //$repo->saveContent($content);
        
        //$user->setName("XXXX");
        //$repo->saveContent($content);
        
        //$repo2 = $this->get('userService');
        //$user->setName("XXXX");
        //$repo2->saveUser($user);
        
        //$repo = $this->get('courseService');
        //$repo->saveCourse($course);
        
        
        
        $name="name";
        
        return $this->render('EdutecaBundle:Web:index.html.twig', array('name' => $name));
    }
    
    /*
    public function testAction()
    {
        $this->renderView("OK");
    }
    */
}
