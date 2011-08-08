<?php
class ubp_Form_CreateBlog extends Zend_Form
{
    public function init()
    {
    // initialize form
        $this->setAction('/my/createblog')
             ->setMethod('post');

    // create text input for name
        $name = new Zend_Form_Element_Text('BlogName');
        $name->setLabel('Blog title: ')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
//            ->addValidator('Alpha', true)
//            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

    // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Create blog')
            ->setOptions(array('class' => 'submit'));

    // attach elements to form
        $this->addElement($name)
            ->addElement($submit);
    }
}
