<?php
class ubp_Form_EditBlog extends Zend_Form
{

    public function init()
    {
    // initialize form
        $this->setAction('/my/editblog')
             ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('BlogID');
//        $id->setOptions(array('size' => '50'))
//           ->addValidator('NotEmpty', 'Int')
//           ->addFilter('HtmlEntities', 'StripTags', 'StringTrim')
//           ->setDecorators($this->_hiddenElementDecorator)
                   ;

    // create text input for name
        $name = new Zend_Form_Element_Text('BlogName');
        $name->setLabel('Change blog title: ')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('StringTrim');

    // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Update blog')
            ->setOptions(array('class' => 'submit'));

    // attach elements to form
        $this->addElement($id)
            ->addElement($name)
            ->addElement($submit);
    }
}
