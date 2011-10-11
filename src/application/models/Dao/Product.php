<?php
/**
 * @category
 * @package
 * @copyright
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */

class Application_Model_Dao_Product
{
    private $_productRepo;

    private $_entityManager;


    public function __construct()
    {
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_productRepo = $this->_entityManager->getRepository('\Entity\Product');
    }

    public function getAll($page, $itemNumber)
    {
        $dql = $this->_entityManager->createQueryBuilder();
        $dql->select('p.id, p.name')
                ->from('Entity\Customer', 'p')
                ->orderBy('p.id', 'ASC');

        $query = $dql->getQuery();

        $records = new Zend_Paginator(new DoctrineExtensions\Paginate\PaginationAdapter($query));

        $records->setCurrentPageNumber($page);
        $records->setItemCountPerPage($itemNumber);

        return $records;
    }

    public function save($postDate)
    {
        $entity = new Entity\Product;

        $entity->setName($postDate['name']);
        $entity->setDescription($postDate['description']);
        $entity->setPrice($postDate['price']);
        $entity->setCustomer($this->_entityManager->getRepository('Entity\Customer')->find($postDate['customer']));

        $this->_entityManager->persist($entity);
        $this->_entityManager->flush();

        return true;
    }

    public function getCustomer()
    {

    }
}