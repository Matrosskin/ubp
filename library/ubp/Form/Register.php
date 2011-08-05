<?php
class ubp_Form_Register extends Zend_Form
{
    public function init()
    {
        // initialize form
        $this->setAction('/register')
            ->setMethod('post');
        // create text input for name
        $username = new Zend_Form_Element_Text('Username');
        $username->setLabel('Username:')
            ->setOptions(array('size' => '30'))
            ->setRequired(true)
            ->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        // create text input for password
        $password = new Zend_Form_Element_Password('Password');
        $password->setLabel('Password:')
            ->setOptions(array('size' => '30'))
            ->setRequired(true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Register')
            ->setOptions(array('class' => 'submit'));
        // attach elements to form
        $this->addElement($username)
            ->addElement($password)
            ->addElement($submit);
    }
}
