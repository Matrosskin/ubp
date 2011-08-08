<?php
class ubp_Form_CreatePost extends Zend_Form
{
    public function init()
    {
    // initialize form
        $this->setAction('/my/createpost')
             ->setMethod('post');

    // create text input for name
        $name = new Zend_Form_Element_Text('PostName');
        $name->setLabel('Title of post:')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
//            ->addValidator('Alpha', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

    // create text input for message body
        $body = new Zend_Form_Element_Textarea('PostBody');
        $body->setLabel('Main text of post:')
            ->setOptions(array('rows' => '8','cols' => '40'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

    // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save post')
            ->setOptions(array('class' => 'submit'));

    // attach elements to form
        $this->addElement($name)
//            ->addElement($email)
            ->addElement($body)
    //        ->addElement($captcha)
            ->addElement($submit);
    }
}
