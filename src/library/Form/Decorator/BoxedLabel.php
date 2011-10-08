<?php
require_once 'Zend/Form/Decorator/Label.php';

class Form_Decorator_BoxedLabel extends Zend_Form_Decorator_Label
{

    /**
     * HTML tag with which to surround holder of label
     * @var string
     */
    protected $_holderClass = 'new-line';

    public function getHolderClass()
    {
        if (null != $this->getOption('holderClass')) {
            $this->setHolderClass($this->getOption('holderClass'));
        }

        return $this->_holderClass;
    }

    public function setHolderClass($className)
    {
        $this->_holderClass = $className;
    }

    /**
     * Render a label using holder tag
     * Print Serial if 'Serial' decorator attuchted
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view = $element->getView();
        if (null === $view) {
            return $content;
        }

        $label = $this->getLabel();
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag = $this->getTag();
        $id = $this->getId();
        $class = $this->getClass();
        $options = $this->getOptions();

        $holderClass = $this->getHolderClass();

        if (empty($label) && empty($tag)) {
            return $content;
        }

        if (!empty($label)) {
            $options['class'] = $class;
            $label = $view->formLabel($element->getFullyQualifiedName(), trim($label), $options);
        } else {
            $label = '&nbsp;';
        }

        if (null !== $tag) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            $decorator->setOptions(array('tag' => $tag,
                                        'id' => $this->getElement()->getName() . '-label',
                                        'class' => $holderClass));

            $label = $this->_setSerialNo($label);
            $label = $decorator->render($label);

        }

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $label;
            case self::PREPEND:
                return $label . $separator . $content;
        }
    }

    protected function _setSerialNo($content)
    {
        $element = $this->getElement();
        $serial = $element->getDecorator('Serial');

        if (empty($serial)) {
            return $content;
        }

        $serial->setOption('flashed', true);
        return $serial->render($content);
    }
}
