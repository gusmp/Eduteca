<?php

namespace Eduteca\EdutecaBundle\Service\impl;

use Eduteca\EdutecaBundle\Repository\ContentRepository;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\DateRange;
use Eduteca\EdutecaBundle\Service\ContentService;

class ContentServiceImpl implements ContentService
{
    private $contentRepository;
    
    public function __construct(ContentRepository $ContentRepository)
    {
        $this->contentRepository = $ContentRepository;
    }
            
    public function saveContent(Content $content)
    {
        $this->contentRepository->saveContent($content);
    }
    
    public function updateContent(Content $content, $oldFile)
    {
        $this->contentRepository->updateContent($content, $oldFile);
    }
    
    public function findContentCount(Content $content, $strictContentTitle, DateRange $contentDateRange)
    {
        return $this->contentRepository->findContentCount($content, $strictContentTitle, $contentDateRange);
    }
    
    public function findContent(Content $content, $start=0, $limit=0, $strictContentTitle = false, DateRange $contentDateRange = null)
    {
        return $this->contentRepository->findContent($content, $start, $limit, $strictContentTitle, $contentDateRange);
    }
    
    public function deleteContent(Content $content)
    {
        $this->contentRepository->deleteContent($content);
    }
}

?>
