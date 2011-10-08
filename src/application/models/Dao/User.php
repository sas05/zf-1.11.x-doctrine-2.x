<?php

/**
 * User Dao
 *
 * @category   Dao
 * @package    Budget
 * @author     Saeed Ahmed <saeed.ahmed@codemate.com>
 */

use Doctrine\ORM\EntityManager;

class Application_Model_Dao_User
{
    const NOT_FOUND = 1;
    const WRONG_PW = 2;
    
    protected $_entityManager;
    protected $_userRepo;

    public function __construct()
    {
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_userRepo = $this->_entityManager->getRepository('\Entity\User');
    }

    public function authenticate($username, $password)
    {
        $user = $this->_entityManager->find('\Entity\User', 1);

        if ($user) {
            if ($user->getPassword() == $this->_getSecret($password))
                return $user;

            throw new Exception(self::NOT_FOUND);
        }
        throw new Exception(self::WRONG_PW);
    }

    private static function _getSecret($password)
    {
        return md5($password);
    }
    
    public function randomString($length = 50) {
    $string = '';

    for ($i = 0; $i < $length; ++$i) {

        $type = rand(1, 5);

        switch ($type) {
            case 1:
                // lowercase letters
                $ascii_start = 65;
                $ascii_end = 90;
                break;
            case 2:
                // uppercase leters
                $ascii_start = 97;
                $ascii_end = 122;
                break;
            case 3:
                // Space
                $ascii_start = 32;
                $ascii_end = 32;
                break;
            case 4:
                // numbers
                $ascii_start = 48;
                $ascii_end = 57;
                break;
            case 5:
                // Punctuation
                $ascii_start = 33;
                $ascii_end = 47;
                break;
        }

        $string .= chr(rand($ascii_start, $ascii_end));
    }
    return $string;
    }
}