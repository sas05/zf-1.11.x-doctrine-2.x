<?php
/**
 * @category    
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */
 
namespace Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    protected $_entityClassName = 'Entity\Product';
}