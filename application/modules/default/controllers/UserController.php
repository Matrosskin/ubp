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
        $q = Doctrine_Query::create()
            ->select('b.BlogName, b.BlogID')
            ->from('ubp_model_Blog b')
            ->leftJoin('b.ubp_model_User u')
            ->where('u.Username = ?', Zend_Auth::getInstance()->getIdentity());
        $result = $q->fetchArray();
        $this->view->blog = $result[0];
    }

    public function showblogAction()
    {
        ubp_Scripts_Show::showblogAction();
//        $q = Doctrine_Query::create()
//            ->select('p.*')
//            ->from('ubp_model_Post p')
//            ->leftJoin('p.ubp_model_Blog b')
//            ->leftJoin('b.ubp_model_User u')
//            ->where('u.UserName = ?', Zend_Auth::getInstance()->getIdentity())
//                ;
//        $result = $q->fetchArray();
////        echo '<pre>';var_dump($result);exit;
//        $this->view->posts = $result;
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
                $this->_redirect('/my/account');
            }
        }
    }

    public function createpostAction()
    {
        $form = new ubp_Form_CreatePost();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $newpost = new ubp_model_Post();
                $newpost->fromArray($form->getValues());
                $q = Doctrine_Query::create()
                    ->select('b.BlogID')
                    ->from('ubp_model_Blog b')
                    ->leftJoin('b.ubp_model_User u')
                    ->where('u.Username = ?', Zend_Auth::getInstance()->getIdentity());
                $result = $q->fetchArray();
//                echo '<pre>';
//                                var_dump($result);exit;
                $newpost->set('BlogID', $result[0]['BlogID']);
                $newpost->save();
                $this->_redirect('/my/blog');
            }
        }
    }

    public function showpostAction()
    {
        ubp_Scripts_Show::showpostAction();
    }

    public function editblogAction()
    {
        // generate input form
        $form = new ubp_Form_EditBlog();
//        $form->setAction('/my/editblog');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            // if POST request
            // test if input is valid
            // retrieve current record
            // update values and replace in database
            $postData = $this->getRequest()->getPost();
            if ($form->isValid($postData)) {
                $input = $form->getValues();
                $blog = Doctrine::getTable('ubp_model_Blog')
                    ->find($input['BlogID']);
                $blog->fromArray($input);
                $blog->save();
                $this->_helper->getHelper('FlashMessenger')
                    ->addMessage('The record was successfully updated.');
                $this->_redirect('/my/account');
            }
        } else {
            // if GET request
            // set filters and validators for GET input
            // test if input is valid
            // retrieve requested record
            // pre-populate form
            $filters = array(
                'id' => array('HtmlEntities', 'StripTags', 'StringTrim')
            );
            $validators = array(
                'id' => array('NotEmpty', 'Int')
            );
            $input = new Zend_Filter_Input($filters, $validators);
            $input->setData($this->getRequest()->getParams());
            if ($input->isValid()) {
                $q = Doctrine_Query::create()
                    ->from('ubp_model_Blog b')
                    ->where('b.BlogID = ?', $input->id);
                $result = $q->fetchArray();
                if (count($result) == 1) {
                    // perform adjustment for date selection lists
//                    $this->view->form->setAction('/my/editblog/' . $input->id);
                    $this->view->form->populate($result[0]);
                } else {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }
    }
}