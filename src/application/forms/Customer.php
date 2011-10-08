<?php
/**
 * @category    
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */
 
class Application_Form_Customer extends Zend_Form
{

    public function __construct($entity = null)
    {
        parent::__construct();

        if(!is_null($entity)){
            $this->_values = $entity;
        }

        $this->addElementPrefixPath('Form_Decorator', 'Form/Decorator', 'decorator');

        $this->setName('customer-form');
        $this->setAttrib('id', 'customer-form');
        (is_null($entity)) ? $this->setAction('/customer/create') : $this->setAction('/user/edit/id/' . $this->_values->getId());
        $this->setMethod('post');

        $this->_addName();
        $this->_addSubmitButton();
        $this->_addResetButton();

        $this->setDisableLoadDefaultDecorators(true);
        $this->setDecorators(array(
                                  array(
                                      'ViewScript',
                                      array('viewScript' => 'form/_customer.phtml')
                                  )));
    }

    protected function _addName()
    {
        $userName = new Zend_Form_Element_Text('name');
        $userName   ->addFilters(array('StringTrim'))
                    ->addValidators(array(
                                          array(
                                              'validator' => 'NotEmpty',
                                              'breakChainOnFailure' => true)
                                     ))
                    ->setValue(($this->_values) ? $this->_values->getUsername() : '')
                    ->setRequired(true)
                    ->removeDecorator('Label')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('HtmlTag');

        $this->addElement($userName);
    }

    protected function _addSubmitButton()
    {
        $create = new Zend_Form_Element_Submit('save');
        $create->setLabel('Save')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('HtmlTag');

        $this->addElement($create);
    }

    protected function _addResetButton()
    {
        $reset = new Zend_Form_Element_Reset('reset');
        $reset  ->setLabel('Reset')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('HtmlTag');

        $this   ->addElement($reset);
    }
}