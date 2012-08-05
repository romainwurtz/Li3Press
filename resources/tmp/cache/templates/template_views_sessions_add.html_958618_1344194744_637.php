<?php echo $this->form->create(null, array("id" => "form_login", "class" => "form-vertical")); ?>
 <fieldset>
    <?php echo $this->form->field('username', array('id' => 'login_username', 'autocomplete' => 'on', 'class' => 'span3', 'wrap' => array('class' => 'control-group'))); ?>
    <?php echo $this->form->field('password', array('type' => 'password', 'autocomplete' => 'off', 'class' => 'span3', 'id' => 'login_pass', 'wrap' => array('class' => 'control-group'))); ?>
        <div style="margin-top:42px">
    <?php echo $this->form->submit('Login', array('class' => 'btn btn-success btn-large span3')); ?>
        </div>
     </fieldset>
<?php echo $this->form->end(); ?>