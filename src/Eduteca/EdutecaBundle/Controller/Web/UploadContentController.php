<?php

namespace Eduteca\EdutecaBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\User;

class UploadContentController extends Controller
{
    private function action(Request $request)
    {
        $courseService = $this->get('courseService');
        $contentService = $this->get('contentService');
        $courseList = $courseService->findCourseArray(new Course());

        $content = new Content();
        $content->setCourse(new Course());
        
        $form = $this->createFormBuilder($content)
                ->add('courseId','choice', array('choices' => $courseList))
                ->add('title')
                ->add('description','textarea')
                ->add('file','file')
                ->getForm();
        if ($request->getMethod() == 'GET')
        {
            return $this->render('EdutecaBundle:Web/upload:prepareUpload.html.twig', 
                array('form'  => $form->createView(),
                      'title' => null));
        }
        else if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
        
            if ($form->isValid() == false) 
            {
                return $this->render('EdutecaBundle:Web/upload:prepareUpload.html.twig', 
                array('form'       => $form->createView(),
                      'title'      => null));
            }
            else
            {
                $content = $form->getData();
                
                $contentTest = new Content();
                $contentTest->setTitle($content->getTitle());
                $contentTest->getCourse()->setCourseId($content->getContentId());
                $contentList = $contentService->findContent($contentTest);
                if ($contentList != null)
                {
                    return $this->render('EdutecaBundle:Web/upload:prepareUpload.html.twig', 
                        array('form'       => $form->createView(),
                              'title'      => $content->getTitle()));
                }
                
                
                $content->upload();
                $content->setDate(new \DateTime("now"));
                $content->setPublished(false);
                
                $course = new Course();
                $course->setCourseId($content->getContentId());
                $courseList = $courseService->findCourse($course);
                $content->setCourse($courseList[0]);

                $user = $this->get('security.context')->getToken()->getUser();
                $content->setUser($user);
                
                
                $contentService->saveContent($content);
        
                return $this->render('EdutecaBundle:Web/upload:upload.html.twig',
                        array('title' => $content->getTitle()));
            }
        }
    }
    
    public function prepareUploadAction(Request $request)
    {
        return $this->action($request);
    }
    
    public function uploadAction(Request $request)
    {
        return $this->action($request);
    }

}
