<?php

namespace Eduteca\EdutecaBundle\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    
    private function login($request, &$session)
    {
        //$request = $this->getRequest();
        //$session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $error;
    }
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $error = $this->login($request, $session);
        
        return $this->render('EdutecaBundle:Security:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error));
    }
    
    public function loginAdminAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $error = $this->login($request, $session);
        
        return $this->render('EdutecaBundle:Security:loginAdmin.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error));
    }
}
