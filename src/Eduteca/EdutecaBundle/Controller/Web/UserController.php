<?php

namespace Eduteca\EdutecaBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\Role;

class UserController extends Controller
{
 
    private function buildForm(User $user, $addCaptcha)
    {
        $qb = $this->createFormBuilder($user)
                ->add('login')
                ->add('password','repeated', 
                    array('type'       => 'password', 
                          'first_name' => $this->get('translator')->trans('register.form.password'),
                          'second_name' => $this->get('translator')->trans('register.form.password_verification'),
                          'invalid_message' => $this->get('translator')->trans('register.error_password')))
                ->add('name')
                ->add('surname1')
                ->add('surname2')
                ->add('email','email');
        
        if ($addCaptcha == TRUE)
        {
            $qb->add('captcha', 'captcha');
        }
        
        $form = $qb->getForm();
        
        return $form;
    }
    
    private function registerAction(Request $request)
    {
        try
        {
            $user = new User();
            $form = $this->buildForm($user, true);

            if ($request->getMethod() == 'GET')
            {
                return $this->render('EdutecaBundle:Web/registerUser:prepareRegister.html.twig',
                    array('form'   => $form->createView(),
                        'errors' => null));             
            }
            else if ($request->getMethod() == 'POST')
            {
                $form->bindRequest($request);

                if ($form->isValid() == false) 
                {
                    return $this->render('EdutecaBundle:Web/registerUser:prepareRegister.html.twig', 
                            array('form'   => $form->createView(),
                                'errors' => $form->getErrors()));
                }
                else
                {
                    $user = $form->getData();

                    $userService = $this->get('userService');
                    $userService->saveUser($user);

                    return $this->render('EdutecaBundle:Web/registerUser:register.html.twig', 
                            array('user' => $user, 
                            'name' => $user->getName()));
                }
            }
        }
        catch(\PDOException $exc)
        {
            return $this->render('EdutecaBundle:Web/registerUser:prepareRegister.html.twig', 
                array('form'   => $form->createView(),
                        'errors' => true));
        }
    }
    
    public function prepareRegisterUserAction(Request $request)
    {
        return $this->registerAction($request);
    }
    
    public function registerUserAction(Request $request)
    {
        return $this->registerAction($request);
    }
    
    public function editAction(Request $request)
    {
        try
        {
            $user = $this->get('security.context')->getToken()->getUser();
            $form = $this->buildForm($user, false);

            if ($request->getMethod() == 'GET')
            {
                return $this->render('EdutecaBundle:Web/editUser:prepareEdit.html.twig',
                    array('form'   => $form->createView(), 
                        'errors' => null));
            }
            else if ($request->getMethod() == 'POST')
            {
                $form->bindRequest($request);

                if ($form->isValid() == false) 
                {
                    return $this->render('EdutecaBundle:Web/editUser:prepareEdit.html.twig', 
                            array('form'   => $form->createView(),
                                'errors' => $form->getErrors()));
                }
                else
                {
                    $user = $form->getData();

                    $userService = $this->get('userService');
                    $userService->updateUser($user);

                    return $this->render('EdutecaBundle:Web/editUser:edit.html.twig', 
                            array('user' => $user, 
                            'name' => $user->getName()));
                }
            }
        }
        catch(\PDOException $exc)
        {
            return $this->render('EdutecaBundle:Web/editUser:prepareEdit.html.twig', 
                array('form'   => $form->createView(),
                        'errors' => true));
        }
    }
    
    public function prepareEditUserAction(Request $request)
    {
        return $this->editAction($request);
    }
    
    public function editUserAction(Request $request)
    {
        return $this->editAction($request);
    }
    
    public function deleteUserAction(Request $request)
    {
        $userService = $this->get('userService');
        $user = $this->get('security.context')->getToken()->getUser();
        $userService->deleteUser($user);
        
        $this->get('request')->getSession()->invalidate();
        $this->get('security.context')->setToken(null); 
        return $this->redirect($this->generateUrl('home'));
    }
}
