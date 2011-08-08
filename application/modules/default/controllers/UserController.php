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
            $this->_redirect('/login');
        }
    }

    public function showaccountAction()
    {
//        $q = Doctrine_Query::create()
//            ->select('u.UserID')
//            ->from('ubp_model_User u')
//            ->where('u.Username = ?', Zend_Auth::getInstance()->getIdentity());
//        $result = $q->fetchArray();
////                echo '<pre>';var_dump($result[0]['UserID']);exit;
//                $newblog->set('UserID', $result[0]['UserID']);
    }

    public function showblogAction()
    {

    }

    public function createblogAction()
    {
        $form = new ubp_Form_CreateBlog();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $newblog = new ubp_model_Blog();
                $newblog->fromArray($form->getValues());
                $q = Doctrine_Query::create()
                    ->select('u.UserID')
                    ->from('ubp_model_User u')
                    ->where('u.Username = ?', Zend_Auth::getInstance()->getIdentity());
                $result = $q->fetchArray();
                $newblog->set('UserID', $result[0]['UserID']);
                $newblog->save();
            }
        }
    }
}