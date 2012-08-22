<?php

namespace Eduteca\EdutecaBundle\Repository;

use Eduteca\EdutecaBundle\Entity\Group;

interface GroupRepository
{
    public function saveGroup(Group $group);
    public function findGroup(Group $group);
    public function deleteGroup(Group $group);
}

?>
