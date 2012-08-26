<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<?= $this->form->create(null, array("id" => "form_login", "class" => "form-vertical")); ?>
<fieldset>
    <?= $this->form->field('username', array('id' => 'login_username', 'autocomplete' => 'on', 'class' => 'span3', 'wrap' => array('class' => 'control-group'))); ?>
    <?= $this->form->field('password', array('type' => 'password', 'autocomplete' => 'off', 'class' => 'span3', 'id' => 'login_pass', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
        <?= $this->form->submit('Login', array('class' => 'btn btn-success btn-large span3')); ?>
    </div>
</fieldset>
<?= $this->form->end(); ?>