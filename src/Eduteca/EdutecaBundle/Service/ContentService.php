<?php

namespace Eduteca\EdutecaBundle\Service;

use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\DateRange;

interface ContentService
{
    public function saveContent(Content $content);
    public function updateContent(Content $content, $oldFile);
    public function findContentCount(Content $content, $strictContentTitle, DateRange $contentDateRange);
    public function findContent(Content $content, $start, $limit, $strictContentTitle, DateRange $contentDateRange);
    public function deleteContent(Content $content);
}

?>
