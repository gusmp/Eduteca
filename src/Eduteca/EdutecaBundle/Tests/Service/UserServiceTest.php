<?php

namespace Eduteca\EdutecaBundle\Tests\Repository;


use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Repository\UserRepository;
use Eduteca\EdutecaBundle\Repository\impl\UserRepositoryImpl;
use Eduteca\EdutecaBundle\Tests\ContainerAwareUnitTestCase;


class UserServiceTest extends ContainerAwareUnitTestCase
{
    /**
     * @var UserRepository 
     */
    private $userService;
    
    /**
     * @var type string
     */
    private $userLoginTest = 'userLoginTest';
    
    /**
     * @var type string
     */
    private $userPasswordTest = 'userPasswordTest';
    
    /**
     * @var type string
     */
    private $userNameTest = 'userNameTest';
    
    /**
     * @var type string
     */
    private $userSurname1Test = 'userSurname1Test';
    
    /**
     * @var type string
     */
    private $userSurname2Test = 'userSurname2Test';
    
    /**
     * @var type string
     */
    private $userMailTest = 'userMailTest';
    
    /**
     * @var type bool
     */
    private $userApprovedTest = false;
    

    public function __construct()
    {
        $this->setUpBeforeClass();
        $this->userService = $this->get('userService');
    }
    
    private function checkUserObject(User $user)
    {
        $this->assertEquals($user->getLogin(), $this->userLoginTest);
        //$this->assertEquals($user->getPassword(), $this->userPasswordTest);
        $this->assertEquals($user->getName(), $this->userNameTest);
        $this->assertEquals($user->getSurname1(), $this->userSurname1Test);
        $this->assertEquals($user->getSurname2(), $this->userSurname2Test);
        $this->assertEquals($user->getApproved(), $this->userApprovedTest);
        $this->assertEquals($user->getEmail(), $this->userMailTest);
    }
    
    public function testUser()
    {
        $sufix = '_TMP';
        
        // insert
        $user = new User();
        $user->setLogin($this->userLoginTest);
        $user->setPassword($this->userPasswordTest);
        $user->setName($this->userNameTest);
        $user->setSurname1($this->userSurname1Test);
        $user->setSurname2($this->userSurname2Test);
        $user->setApproved($this->userApprovedTest);
        $user->setEmail($this->userMailTest);
        
        $this->userService->saveUser($user);
        
        
        // recover
        $user = new User();
        $user->setLogin($this->userLoginTest);
        $userList = $this->userService->findUser($user);
        $this->assertEquals(1, count($userList));
        $this->checkUserObject($userList[0]);
        
        // delete
        $this->userService->deleteUser($userList[0]);
        
        $userList = $this->userService->findUser($user);
        $this->assertEquals(0, count($userList));
    }
}
?>
