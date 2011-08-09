<?php
class ubp_Scripts_Show extends Zend_Controller_Action
{
    public function showblogAction()
    {

//        var_dump('haha');exit;
// set filters and validators for GET input
        $filters = array(
            'id' => array('HtmlEntities', 'StripTags', 'StringTrim')
        );
        $validators = array(
            'id' => array('NotEmpty', 'Int')
        );
// test if input is valid
// retrieve requested record
// attach to view
        $input = new Zend_Filter_Input($filters, $validators);
        $input->setData($this->getRequest()->getParams());
        if ($input->isValid()) {
            $q = Doctrine_Query::create()
                ->from('ubp_model_Post p')
                ->where('p.BlogID = ?', $input->id)
                    ;

            $result = $q->fetchArray();
//            if (count($result) == 1) {
                $this->view->posts = $result;
//            } else {
//                throw new Zend_Controller_Action_Exception('Page not found', 404);
//            }
        } else {
            throw new Zend_Controller_Action_Exception('Invalid input');
        }
    }

    public function showpostAction()
    {
//        var_dump('haha');exit;
// set filters and validators for GET input
        $filters = array(
            'id' => array('HtmlEntities', 'StripTags', 'StringTrim')
        );
        $validators = array(
            'id' => array('NotEmpty', 'Int')
        );
// test if input is valid
// retrieve requested record
// attach to view
        $input = new Zend_Filter_Input($filters, $validators);
        $input->setData($this->getRequest()->getParams());
        if ($input->isValid()) {
            $q = Doctrine_Query::create()
                ->from('ubp_model_Post p')
                ->where('p.PostID = ?', $input->id);
            $result = $q->fetchArray();
            if (count($result) == 1) {
                $this->view->post = $result[0];
            } else {
                throw new Zend_Controller_Action_Exception('Page not found', 404);
            }
        } else {
            throw new Zend_Controller_Action_Exception('Invalid input');
        }
    }
}