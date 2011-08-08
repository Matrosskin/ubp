<?php
class UserController extends Zend_Controller_Action
{
// action to handle admin URLs
    public function preDispatch()
    {
// check URL for /admin pattern
// set admin layout
        $url = $this->getRequest()->getRequestUri();
        $this->_helper->layout->setLayout('user');
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $session = new Zend_Session_Namespace('ubp.auth');
            $session->requestURL = $url;
            $this->_redirect('/my/');
        }
    }

    public function showaccountAction()
    {

    }

    public function showblogindexAction()
    {

    }
}