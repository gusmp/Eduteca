<?php

namespace Eduteca\EdutecaBundle\Service;

use Eduteca\EdutecaBundle\Entity\Group;

interface GroupService
{
    const ROLE_USERS  = 'ROLE_USER';
    const ROLE_ADMIN  = 'ROLE_ADMIN';
    
    public function saveGroup(Group $group);
    public function findGroup(Group $group);
    public function findGroupArray(Group $group);
    public function deleteGroup(Group $group);
}

?>
