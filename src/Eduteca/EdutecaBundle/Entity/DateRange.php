<?php

namespace Eduteca\EdutecaBundle\Entity;

class DateRange
{

    /**
     * @var date 
     */
    private $startDate;
    
    /**
     * @var date 
     */
    private $endDate;

    public function getStartDate() { return $this->startDate; }
    public function setStartDate($startDate) { $this->startDate = $startDate; }

    public function getEndDate() { return $this->endDate; }
    public function setEndDate($endDate) { $this->endDate = $endDate; }

}


?>
