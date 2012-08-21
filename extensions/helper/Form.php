<?php

namespace app\extensions\helper;

class Form extends \lithium\template\helper\Form {

    protected function _init() {
        parent::_init();
        $this->config(array('templates' => array(
                'field' => '<div class="control-group">{:label}<div class="controls">{:input}</div></div>',
                'label' => '<label for="{:id}" class="control-label"{:options}>{:title}</label>',
                'text' => '<input type="text" name="{:name}"{:options} placeholder="{:name}" />',
                )));
    }

}

?>