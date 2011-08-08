<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
//        // action body
//        $manager = Doctrine_Manager::getInstance();
//// create database connection
////    $conn = Doctrine_Manager::connection(
////        'mysql://ubp:ubp@ubp/ubp', 'doctrine');
//    Doctrine::generateModelsFromDb('/tmp/models',
//        array('doctrine'),
//        array('classPrefix' => '')
//        );

//        $q = Doctrine_Query::create()
//            ->from('Square_Model_Item i')
//            ->leftJoin('i.Square_Model_Grade g')
//            ->leftJoin('i.Square_Model_Country c')
//            ->leftJoin('i.Square_Model_Type t');
//        $result = $q->fetchArray();
//        $this->view->records = $result;

        $q = Doctrine_Query::create()
//            ->select('b.BlogName u.Username')
            ->from('ubp_model_Blog b')
            ->leftJoin('b.ubp_model_User u')
//            ->where('b.UserID = u.UserID')
                ;
        $result = $q->fetchArray();
//        echo '<pre>';var_dump($result);exit;
        $this->view->blogs = $result;
    }

    public function showblogAction()
    {

    }
}

