<?php

namespace Eduteca\EdutecaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="USER")
 * @ORM\Entity(repositoryClass="Eduteca\EdutecaBundle\Provider\UserProvider")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="USER_ID", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $userId;
    
    /**
     * @ORM\Column(name="LOGIN", type="string", length=100, unique=true)
     * @Assert\NotBlank()
     * @var string
     */
    private $login;
    
    /**
     * @ORM\Column(name="PASSWORD", type="string",length=100)
     * @Assert\NotBlank()
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="SALT", type="string",length=50)
     * @var string
     */
    private $salt;
    
    
    /**
     * @ORM\Column(name="NAME", type="string",length=100)
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="SURNAME1", type="string",length=100)
     * @Assert\NotBlank()
     * @var string
     */
    private $surname1;

    /**
     * @ORM\Column(name="SURNAME2", type="string",length=100, nullable=true)
     * @var string
     */
    private $surname2;
    
    /**
     * @ORM\Column(name="APPROVED", type="boolean")
     * @var bool
     */
    private $approved;
    
    /**
     * @ORM\Column(name="EMAIL", type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     * @var string
     */
    private $email;
    
    /**
     * @ORM\OneToMany(targetEntity="Content", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userList;
    
    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="userList") 
     * @ORM\JoinTable(name="USER_GROUP",
     *   joinColumns={@ORM\JoinColumn(name="USER_ID", referencedColumnName="USER_ID")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="GROUP_ID", referencedColumnName="GROUP_ID")})
     */
    private $groupList;
    
    /* Constructor  */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->userList = new ArrayCollection();
        $this->groupList = new ArrayCollection();
    }
    
    public function getUserName()
    {
        return $this->login;
    }
    
    public function eraseCredentials() {}
    
    public function equals(UserInterface $user)
    {
        return $this->login === $user->getUsername();
    }
    
    
    /* Getters and setters */
    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }

    public function getLogin() { return $this->login; }
    public function setLogin($login) { $this->login = $login; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getSalt() { return $this->salt; }
    public function setSalt($salt) { $this->salt = $salt; }
    
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getSurname1() { return $this->surname1; }
    public function setSurname1($surname1) { $this->surname1 = $surname1; }

    public function getSurname2() { return $this->surname2; }
    public function setSurname2($surname2) {$this->surname2 = $surname2; }

    public function getApproved() { return $this->approved; }
    public function setApproved($approved) { $this->approved = $approved; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getUserList() { return $this->userList; }
    public function setUserList($userList) { $this->userList = $userList; }
    
    public function getGroupList() { return $this->groupList; }
    public function setGroupList($groupList) { $this->groupList = $groupList; }
     
    public function getRoles() 
    { 
        $groupArray = array();
        foreach($this->groupList as $index => $group)
        {
            $groupArray[$index] = $group->getRole();
        }
        
        return $groupArray;
    }
    
}