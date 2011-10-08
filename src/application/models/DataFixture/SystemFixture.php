<?php

namespace Application\Models\DataFixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
Doctrine\Common\DataFixtures\FixtureInterface,
Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Application_Model_Dao_User;

use Entity\Role;
use Entity\User;
use Entity\Season;
use Entity\XmlContent;

class SystemFixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    public function getOrder()
    {
        return self::ORDER;
    }

    public function load($em)
    {
        $roleNameList = array(
            1 => 'admin',
            2 => 'user',
            3 => 'end-user'
        );
        foreach ($roleNameList as $key => $roleName) {
            $role = new Role();

            $role->setName($roleName);

            $em->persist($role);

            $this->addReference($key, $role);
        }

        $userModel = new Application_Model_Dao_User();
        $password = '123456';
        $salt = $userModel->createSalt();
        $password = $userModel->_getSecret($password, $salt);

        $users = array(
            array(
                'username' => 'admin',
                'role' => 1,
                'password' => $password,
                'email' => 'mobilespot@mobilespot.dhaka.codemate.com',
                'firstName' => 'Admin',
                'lastName' => '',
                'active' => 1,
                'salt' => $salt
            ),

            array(
                'username' => 'saeed',
                'role' => 2,
                'password' => $password,
                'email' => 'saeed@mobilespot.dhaka.codemate.com',
                'firstName' => 'Saeed',
                'lastName' => 'Ahmed',
                'active' => 1,
                'salt' => $salt
            ),

            array(
                'username' => 'lasse',
                'role' => 3,
                'password' => md5('123456'),
                'email' => 'lasse@mobilespot.dhaka.codemate.com',
                'firstName' => 'Lasse',
                'lastName' => 'Sarkila',
                'active' => 1,
                'salt' => $salt
            )
        );

        foreach ($users as $userInfo) {
            $user = new User();

            $user->setUsername($userInfo['username']);
            $user->setRole($em->merge($this->getReference($userInfo['role'])));
            $user->setPassword($userInfo['password']);
            $user->setEmail($userInfo['email']);
            $user->setFirstName($userInfo['firstName']);
            $user->setLastName($userInfo['lastName']);
            $user->setActive($userInfo['active']);
            $user->setSalt($userInfo['salt']);

            $em->persist($user);
        }

//        $seasons = array(
//            array(
//                'name' => '2008',
//                'current' => 1,
//                'year' => '2008',
//                'seasonWiseDirectory' => '',
//                'importSeason' => '',
//            ),
//
//            array(
//                'name' => '2009',
//                'current' => 0,
//                'year' => '2009',
//                'seasonWiseDirectory' => '',
//                'importSeason' => '',
//            )
//        );
//
//        foreach ($seasons as $key => $seasonInfo) {
//            $season = new Season();
//
//            $season->setName($seasonInfo['name']);
//            $season->setCurrent($seasonInfo['current']);
//            $season->setYear($seasonInfo['year']);
//            $season->setSeasonWiseDirectory($seasonInfo['seasonWiseDirectory']);
//            $season->setImportSeason($seasonInfo['importSeason']);
//
//            $em->persist($season);
//
//            $this->addReference(4, $season);
//        }
//
//        $xmlContents = array(
//            array(
//                'season' => 1,
//                'statisticId' => '006',
//                'xmlUrl' => 'URL-6',
//                'localFilename' => 'FILE-6',
//                'pollInterval' => '04:15:30',
//                'isArchived' => 0,
//            ),
//
//            array(
//                'season' => 4,
//                'statisticId' => '007',
//                'xmlUrl' => 'URL-7',
//                'localFilename' => 'FILE-7',
//                'pollInterval' => '05:15:30',
//                'isArchived' => 0,
//            )
//        );
//
//        foreach ($xmlContents as $xmlContentInfo) {
//            $xmlContent = new XmlContent();
//
//            $xmlContent->setSeason($em->merge($this->getReference($xmlContentInfo['season'])));
//            $xmlContent->setStatisticId($xmlContentInfo['statisticId']);
//            $xmlContent->setXmlUrl($xmlContentInfo['xmlUrl']);
//            $xmlContent->setLocalFilename($xmlContentInfo['localFilename']);
//            $xmlContent->setPollInterval($xmlContentInfo['pollInterval']);
//            $xmlContent->setIsArchived($xmlContentInfo['isArchived']);
//
//            $em->persist($xmlContent);
//        }

        $em->flush();
    }
}