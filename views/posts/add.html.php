<?=$this->form->create(); ?>
    <?=$this->form->field('title');?>
    <?=$this->form->field('body', array('type' => 'textarea'));?>
    <?=$this->form->submit('Add Post'); ?>
<?=$this->form->end(); ?>

<?php if ($success): ?>
    <p>Post Successfully Saved</p>
<?php endif; ?>