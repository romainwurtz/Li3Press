    <h2>Add user</h2>
    <?=$this->form->create($user); ?>
        <?=$this->form->field('username'); ?>
        <?=$this->form->field('password', array('type' => 'password')); ?>
        <?=$this->form->submit('Create me'); ?>
    <?=$this->form->end(); ?>