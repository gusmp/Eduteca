<?php

namespace Eduteca\EdutecaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="EDUTECA_GROUP")
 */
class Group implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="GROUP_ID", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int 
     */
    private $groupId;
    
    /**
     * @ORM\Column(name="GROUP_NAME", type="string", length=50)
     */
    private $groupName;
    
    /**
     * @ORM\Column(name="ROLE", type="string", length=50, unique=true)
     */
    private $role;
    
   
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groupList")
     */
    private $userList;
    
    public function __construct()
    {
        $this->userList = new ArrayCollection();
    }
    
    public function getGroupId() { return $this->groupId; }
    public function setGroupId($groupId) { $this->groupId = $groupId; }

    public function getGroupName() { return $this->groupName; }
    public function setGroupName($groupName) { $this->groupName = $groupName; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }

    public function getUserList() { return $this->userList; }
    public function setUserList($userList) { $this->userList = $userList; }

}

?>
