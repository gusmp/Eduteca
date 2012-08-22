<?php

namespace Eduteca\EdutecaBundle\Service;

use Eduteca\EdutecaBundle\Entity\User;

interface UserService
{
    public function saveUser(User $user);
    public function updateUser(User $user, $newPassword);
    public function findUserCount(User $user, $strictLogin);
    public function findUser(User $user, $start, $limit, $strictLogin);
    public function deleteUser(User $user);
    public function enableAdminUser();
}

?>
