<?php
/**
 * @category
 * @package
 * @copyright
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */

class ProductController extends Zend_Controller_Action
{
    private $_flashMessenger;

    private $_itemNumber;

    private $_page;

    private $_entityManager;


    public function init()
    {
        $this->_itemNumber = 3;
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->_flashMessenger = $this->_helper->FlashMessenger;
        $this->_productModel = new Application_Model_Dao_Product();
    }

    public function indexAction()
    {
        if (is_null($this->getRequest()->getParam('page'))) {
            $this->_page = 1;
        } else {
            $this->_page = $this->getRequest()->getParam('page');
        }
        $records = $this->_productModel->getAll($this->_page, $this->_itemNumber);
        $this->view->page = $this->_page;
        $this->view->itemNumber = $this->_itemNumber;
        $this->view->records = $records;
    }

    public function createAction()
    {
        $productForm = new Application_Form_Product();
        $this->view->create = $productForm;
        $productModel = new Application_Model_Dao_Product();
        $entity = new Entity\Product;

        if ($this->getRequest()->isPost()) {
            if ($productForm->isValid($_POST)) {
                $entity->setName($this->getRequest()->getParam('name'));
                $entity->setDescription($this->getRequest()->getParam('description'));
                $entity->setPrice($this->getRequest()->getParam('price'));
                $entity->setCustomer($this->_entityManager->getRepository('Entity\Customer')->find($this->getRequest()->getParam('customer')));

                $this->_entityManager->persist($entity);
                $this->_entityManager->flush();
                $this->_flashMessenger->addMessage(
                    array('flash-success' => 'Create Successfully!')
                );
            }
        }
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}
