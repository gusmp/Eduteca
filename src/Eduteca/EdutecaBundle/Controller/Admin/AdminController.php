<?php

namespace Eduteca\EdutecaBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\User;

class AdminController extends Controller
{
    public function adminAction(Request $request)
    {
        return $this->render('EdutecaBundle:Admin:index.html.twig');
    }
    

}
