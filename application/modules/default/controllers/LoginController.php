<?php
class LoginController extends Zend_Controller_Action
{
    public function init()
    {
//        this part will be changed later
//        $this->_helper->layout->setLayout('admin');
    }

    // login action
    public function loginAction()
    {
        $form = new ubp_Form_Login();
        $this->view->form = $form;
        // check for valid input
        // authenticate using adapter
        // persist user record to session
        // redirect to original request URL if present
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $values = $form->getValues();
                $adapter = new ubp_Auth_Adapter_Doctrine(
                    $values['username'], $values['password']
                );
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);
                if ($result->isValid()) {
                    $session = new Zend_Session_Namespace('ubp.auth');
                    $session->user = $adapter->getResultArray('Password');
                    if (isset($session->requestURL)) {
                        $url = $session->requestURL;
                        unset($session->requestURL);
                        $this->_redirect($url);
                    } else {
                        $this->_helper->getHelper('FlashMessenger')
                            ->addMessage('You were successfully logged in.');
                        $this->_redirect('/my');
                    }
                } else {
                    $this->view->message = 'You could not be logged in. Please try again or register.';
                }
            }
        }
    }

    public function successAction()
    {
        if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
            $this->view->messages = $this->_helper
                ->getHelper('FlashMessenger')
                ->getMessages();
        } else {
            $this->_redirect('/my');
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
        $this->_redirect('/');
    }

    public function registerAction()
    {
        $form = new ubp_Form_Register();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $newuser = new ubp_model_User();
                $newuser->fromArray($form->getValues());
                $pvalue = md5($newuser->get('Password'));
                $newuser->set('Password', $pvalue);
                $username = $form->getValue('Username');
                try {
                    $newuser->save(); //Throws an Exception in case of failure
                    $this->_helper->getHelper('FlashMessenger')->addMessage(
                        'Now you can login to site with name' . $username);
                    $this->_redirect('/login');
                } catch (Doctrine_Connection_Mysql_Exception $e) {
                    if ($e->getPortableMessage() == "already exists") {
                        $this->view->message = 'You cannot use the name "' . $username .
                                '" because it is already registered. Please change the name?';
                    }
                }
            }
        }
    }
}
