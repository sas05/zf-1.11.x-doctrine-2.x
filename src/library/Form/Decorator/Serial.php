<?php
require_once 'Zend/Form/Decorator/Abstract.php';

class Form_Decorator_Serial extends Zend_Form_Decorator_Abstract
{

    /**
     * HTML tag with which to surround holder of label
     * @var string
     */
    protected $_number = '&nbsp;';
    protected $_tag = 'span';
    protected $_class = 'serial';

    protected $_flashed = false;

    /**
     * Overloading
     *
     * Currently overloads:
     *
     * - getClass()
     * - getTag()
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     * @throws Zend_Form_Exception for unsupported methods
     */
    public function __call($method, $args)
    {
        $prefix = substr($method, 0, 3);

        $optName = strtolower(substr($method, 3));
        $var = '_' . $optName;

        $option = $this->getOption(strtolower($optName));

        if ('get' == $prefix) {

            $option && $this->$var = $option;
            return $this->$var;

        } elseif ('set' == $prefix) {

            $this->$var = $args[0];
            return $this;
        }
    }

    /**
     * Render a Serial num
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        if ($this->_flashed) {
            return $content;
        }

        $tag = $this->getTag();
        $class = $this->getClass();
        $serial = $this->getNumber();

        $this->_flashed = $this->getFlashed();

        return "<{$tag} class=\"$class\">$serial</{$tag}> $content";
    }

}
