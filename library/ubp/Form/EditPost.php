<?php
class ubp_Form_EditPost extends Zend_Form
{
    public function init()
    {
    // initialize form
        $this->setAction('/my/editpost')
             ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('PostID')
//        $id->setOptions(array('size' => '50'))
//           ->addValidator('NotEmpty', 'Int')
//           ->addFilter('HtmlEntities', 'StripTags', 'StringTrim')
//           ->setDecorators($this->_hiddenElementDecorator)
                   ;

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
            ->addElement($id)
//            ->addElement($email)
            ->addElement($body)
    //        ->addElement($captcha)
            ->addElement($submit);
    }
}
