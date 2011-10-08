<?php
 /**
 *
 *
 * @category    Entity Repository
 * @package
 * @copyright
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/8/11 1:04 PM
 */
namespace Repository;

use Doctrine\ORM\EntityRepository;
 
class CustomerRepository extends EntityRepository
{
    protected $_entityClassName = 'Entity\Customer';
}