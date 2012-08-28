<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>

<?= $this->form->create($comment, array("id" => "form_create", "class" => "form-horizontal row")); ?>
<div class="alert-area"></div>
    <?= $this->form->field(array('comment_id' => 'Comment ID'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('name' => 'Name'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('email' => 'Email'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('website' => 'Website'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('created' => 'Created date'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('updated' => 'Updated date'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('post_id' => 'Post ID'), array('class' => 'span4', 'disabled' => 'true', 'type'=>'textNoPlaceholder')); ?>
    <?= $this->form->field(array('body' => 'Message'), array('type' => 'textarea', 'class' => 'span4', 'style' => 'height:175px', 'disabled' => 'true')); ?>
<?= $this->form->end(); ?>



