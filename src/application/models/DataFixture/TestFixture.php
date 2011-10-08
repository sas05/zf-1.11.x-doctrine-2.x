<?php

namespace Application\Models\DataFixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Entity\Role,
    Entity\User;

class TestFixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 2;

    public function getOrder()
    {
        return self::ORDER;
    }

    const NUM_ADMINS = 2;
    const NUM_USERS = 5;
    const NUM_END_USERS = 10;

    public function load($em)
    {
//        $roleNameList = array(
//            1 => 'admin',
//            2 => 'user',
//            3 => 'end-user'
//        );
//        foreach ($roleNameList as $key => $roleName) {
//            $role = new Role();
//
//            $role->setName($roleName);
//
//            $em->persist($role);
//
//            $this->addReference($key, $role);
//        }
//
//        $userModel = new Application_Model_Dao_User();
//        $password = '123456';
//        $salt = $userModel->createSalt();
//        $password = $userModel->_getSecret($password, $salt);
//
//        for($i = 0; $i < 100; $i++){
//
//            $user = new User();
//            $user->setUsername('test_' . $i);
//            $user->setRole($em->merge($this->getReference(rand(2,3))));
//            $user->setPassword($password);
//            $user->setEmail('test_' . $i . '@mobilespot.dhaka.codemate.com');
//            $user->setFirstName('TEST_' . $i);
//            $user->setActive(rand(0,1));
//            $user->setSalt($salt);
//
//            $em->persist($user);
//        }
//
//        $em->flush();
    }
}