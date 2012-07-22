<?php echo $this->form->create(); ?>
    <?php echo $this->form->field('title'); ?>
    <?php echo $this->form->field('body', array('type' => 'textarea')); ?>
    <?php echo $this->form->submit('Add Post'); ?>
<?php echo $this->form->end(); ?>

<?php if ($success): ?>
    <p>Post Successfully Saved</p>
<?php endif; ?>