<?php
/**
 * Index Controler
 * @author Martin A. Santangelo
 */
class IndexController extends Zend_Controller_Action
{
    public function init ()
    {
		/* Initialize action controller here */
    }
    
    public function indexAction ()
    {
        //TODO: Hacer esto global desde un plugin
        if (! Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'auth');
        } else {
            $this->_helper->redirector('index', 'desktop');
        }
    }
}

