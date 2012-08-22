<?php

namespace Eduteca\EdutecaBundle\Repository;

use Eduteca\EdutecaBundle\Entity\User;

interface UserRepository
{
    public function saveUser(User $user, $encodePassword);
    public function findUserCount(User $user, $strictLogin);
    public function findUser(User $user, $start, $limit, $strictLogin);
    public function deleteUser(User $user);
}

?>
