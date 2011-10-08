<?php

class View_Helper_FlashMessenger extends Zend_View_Helper_Abstract
{
    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    private $flashMessenger = null;

    /**
     * Display Flash Messages.
     *
     * @param  string $key Message level for string messages
     * @param  string $template Format string for message output
     * @return string Flash messages formatted for output
     */
    public function flashMessenger($key = 'warning')
    {
        $flashMessenger = $this->_getFlashMessenger();

        $messages = $flashMessenger->getMessages();

        if ($flashMessenger->hasCurrentMessages()) {
            $messages = array_merge(
                $messages,
                $flashMessenger->getCurrentMessages()
            );
            $flashMessenger->clearCurrentMessages();
        }

        $output = '';

        foreach ($messages as $message)
        {
            if (is_array($message)) {
                list($key, $message) = each($message);
            }
            $output .= sprintf($this->_getTemplate(), $key, $message);
        }

        return $output;
    }

    /**
     * Lazily fetches FlashMessenger Instance.
     *
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    public function _getFlashMessenger()
    {
        if (null === $this->flashMessenger) {
            $this->flashMessenger =
                    Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'FlashMessenger');
        }
        return $this->flashMessenger;
    }

    private function _getTemplate()
    {
        return '<div class="msg  %s"><p>%s</p><a href="#" class="close"></a></div>';
    }
}