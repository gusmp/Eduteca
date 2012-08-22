<?php

namespace Eduteca\EdutecaBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;

class AboutEdutecaController extends Controller
{
    
    public function aboutEdutecaAction()
    {
        $userService = $this->get('userService');
        $userService->enableAdminUser();
        
        $name = "name";
        return $this->render('EdutecaBundle:Web/about:about.html.twig', array('name' => $name));
    }

}
