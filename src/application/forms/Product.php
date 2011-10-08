<?php
/**
 * @category    
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */

class Application_Form_Product extends Zend_Form
{
    protected $_roles = array(1 => 'Admin', 2 => 'User');
    
    public function __construct($entity = null)
    {
        parent::__construct();

        if(!is_null($entity)){
            $this->_values = $entity;
        }

        $this->addElementPrefixPath('Form_Decorator', 'Form/Decorator', 'decorator');

        $this->setName('product-form');
        $this->setAttrib('id', 'product-form');
        (is_null($entity)) ? $this->setAction('/product/create') : $this->setAction('/product/edit/id/' . $this->_values->getId());
        $this->setMethod('post');

        $this->_addName();
        $this->_addDescription();
        $this->_addPrice();
        $this->_addCustomer();
        $this->_addSubmitButton();
        $this->_addResetButton();

        $this->setDisableLoadDefaultDecorators(true);
        $this->setDecorators(array(
                                  array(
                                      'ViewScript',
                                      array('viewScript' => 'form/_product.phtml')
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

    protected function _addDescription()
    {
        $description = new Zend_Form_Element_Textarea('description');
        $description    ->addFilters(array('StringTrim'))
                        ->addValidators(array())
                        ->setRequired(false)
                        ->setAttribs(
                                array(
                                          'cols' => 40,
                                          'rows' => 10
                                )
                        )
                        ->removeDecorator('Label')
                        ->removeDecorator('DtDdWrapper')
                        ->removeDecorator('HtmlTag');

        $this->addElement($description);
    }

    protected function _addPrice()
    {
        $price = new Zend_Form_Element_Text('price');
        $price          ->addFilters(array('StringTrim'))
                        ->addValidators(array())
                        ->setRequired(true)
                        ->removeDecorator('Label')
                        ->removeDecorator('DtDdWrapper')
                        ->removeDecorator('HtmlTag');

        $this->addElement($price);
    }

    protected function _addCustomer()
    {
        $customer = new Zend_Form_Element_Select('customer');

        $customer       ->addValidators(array())
                        ->setRequired(true)
                        ->removeDecorator('Label')
                        ->removeDecorator('DtDdWrapper')
                        ->removeDecorator('HtmlTag');
        foreach ($this->_roles as $key => $role) {
            $customer->addMultiOption($key, $role);
        }

        $this->addElement($customer);
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
