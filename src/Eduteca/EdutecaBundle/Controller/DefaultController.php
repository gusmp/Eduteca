<?php

namespace Eduteca\EdutecaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;

class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        $course = new Course();
        $course->setCourseName("nameCourse!!3");

        //$repo = $this->get('courseRepository');
        //$repo->saveCourse($course);
        
        $repo = $this->get('courseService');
        $repo->saveCourse($course);
        
        return $this->render('EdutecaBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /*
    public function testAction()
    {
        $this->renderView("OK");
    }
    */
}
