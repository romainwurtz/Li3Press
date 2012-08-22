<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<div class="span9">
    <h2>Leave a comment</h2>
</div>
<?= $this->form->create(null, array("id" => "form_create", "class" => "form-horizontal span9")); ?>
<div class="row">
    <div class="span3">
        <?= $this->form->field('Name', array('id' => 'create_name', 'class' => 'span2')); ?>
        <?= $this->form->field('Email', array('id' => 'create_email', 'class' => 'span3')); ?>
        <?= $this->form->field('Website', array('id' => 'create_website', 'class' => 'span3')); ?>
    </div>
    <div class="span6">
        <?= $this->form->field(array('Body' => 'Message'), array('type' => 'textarea', 'class' => 'span4', 'style' => 'height:120px', 'id' => 'create_body')); ?>
    </div>
</div>

    <div class="span2 offset2">
        <!-- CANCEL BUTTON -->
</div>
    <div class="span3 offset4">
        <?= $this->form->submit('Submit', array('class' => 'btn btn-success btn-large offset1 span3', "id" => "create_button", 'list' => array())); ?>
</div>

</div>

<?= $this->form->end(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form_create").submit(function (e) {
            e.preventDefault();
            commentAddAction("<?php echo $this->url(array('Comments::addAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> , 
            $('#create_name').val(), $('#create_email').val(), 
            $('#create_website').val(), $('#create_body').val(), generateComments);
            return false;
        });

    });</script>