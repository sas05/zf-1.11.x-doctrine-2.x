<?php
/**
 * @category    Controller
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */
 
class CustomerController extends Zend_Controller_Action
{

    private $_form;

    private $_entityManager;

    private $_customerRepo;

    private $_flashMessenger;

    private $_customerModel;

    private $_page;

    private $_itemNumber;


    public function init()
    {
        $this->_itemNumber = 3;
        $this->_entityManager   = \Zend_Registry::get('DoctrineEntityManager');
        $this->_customerRepo    = $this->_entityManager->getRepository('Entity\Customer');
        $this->_flashMessenger  = $this->_helper->FlashMessenger;
        $this->_form            = new Application_Form_Customer();
        $this->_customerModel   = new Application_Model_Dao_Customer();
    }

    public function indexAction()
    {
        if (is_null($this->getRequest()->getParam('page'))) {
            $this->_page = 1;
        } else {
            $this->_page = $this->getRequest()->getParam('page');
        }
        $records = $this->_customerModel->getAll($this->_page, $this->_itemNumber);
        $this->view->page = $this->_page;
        $this->view->itemNumber = $this->_itemNumber;
        $this->view->records = $records;
    }

    public function createAction()
    {
        $this->view->createForm = $this->_form;
        $this->_customerEntity      = new \Entity\Customer;

        if ($this->getRequest()->isPost()) {

            if ($this->_form->isValid($_POST)) {
                if($this->_customerModel->save($this->_request->getPost())){
                    $this->_flashMessenger->addMessage(
                        array('success' => 'Customer Created')
                    );
                }else{
                    $this->_flashMessenger->addMessage(
                        array('error' => 'Something Went Wrong')
                    );
                }
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