<?php

namespace Eduteca\EdutecaBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Symfony\Component\HttpFoundation\Response;

class BrowseContentController extends Controller
{
    
    public function prepareBrowseAction()
    {
        $courseService = $this->get('courseService');
        $courseList = $courseService->findCourse(new Course());
        $form = $this->createFormBuilder(new Content())->getForm();

        return $this->render('EdutecaBundle:Web/browseContent:prepareBrowse.html.twig', 
                array('form' => $form->createView(), 'courseList' => $courseList));
    }
    

    public function browseAction(Request $request)
    {
        $content = new Content();
        $form = $this->createFormBuilder($content)
                ->add('course.courseId')
                ->add('title')
                ->add('description')
                ->getForm();
        
        $form->bindRequest($request);
        $content = $form->getData();
        $content->setPublished(true);
        
        $contentService = $this->get('contentService');
        $contentList = $contentService->findContent($content);
        
        return $this->render('EdutecaBundle:Web/browseContent:browse.html.twig', array('contentList' => $contentList));
    }
    
    public function getContentAction($contentId)
    {
        $contentService = $this->get('contentService');
        $contentList = $contentService->findContent(Content::constructWithId($contentId));
        
        $headers = array(
            'Content-Type' => $contentList[0]->getMimeType(),
            'Content-Disposition' => 'attachment; filename="'.$contentList[0]->getPath().'"'
        ); 
        
        return new Response(file_get_contents($contentList[0]->getAbsolutePath()), 200, $headers);
    }

}
