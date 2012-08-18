<div class="alert-area"></div>
<?= $this->form->create(null, array("id" => "form_edit", "class" => "form-vertical")); ?>
<fieldset>
    <?= $this->form->field('title', array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span9', 'wrap' => array('class' => 'control-group'))); ?>
    <?= $this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
        <?= $this->form->submit('Add Post', array('class' => 'btn btn-success btn-large span6')); ?>
        <button class="btn btn-large span2" style="float: right"type="button">Cancel</button> 
    </div>
</fieldset>
<?= $this->form->end(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new nicEditor({
            fullPanel: true
        }).panelInstance('edit_body');
        
        $("#form_edit").submit(function(e) {
            postAddAction("<?php echo $this->url(array('Posts::addAction', 'type' => 'json')); ?>", $('#edit_title').val(), $('#edit_body').val());
            return false;
        });
    });
</script>