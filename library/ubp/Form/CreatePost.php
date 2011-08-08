<?php
class ubp_Form_CreatePost extends Zend_Form
{
    public function init()
    {
    // initialize form
        $this->setAction('/contact/index')
             ->setMethod('post');

    // create text input for name
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
            ->setOptions(array('size' => '35'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('Alpha', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

    // create text input for email address
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email address:');
        $email->setOptions(array('size' => '50'))

            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim')
                ;

    // create text input for message body
        $message = new Zend_Form_Element_Textarea('message');
        $message->setLabel('Message:')
            ->setOptions(array('rows' => '8','cols' => '40'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

    // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Send Message')
            ->setOptions(array('class' => 'submit'));

    // attach elements to form
        $this->addElement($name)
            ->addElement($email)
            ->addElement($message)
    //        ->addElement($captcha)
            ->addElement($submit);
    }
}
