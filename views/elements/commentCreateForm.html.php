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
<div class="span9">

    <?= $this->form->create(null, array("id" => "form_create", "class" => "form-horizontal span9")); ?>
    <div class="alert-area"></div>
    <div class="row">
        <div class="span3">
            <?= $this->form->field('Name', array('id' => 'create_name', 'class' => 'span2')); ?>
            <?= $this->form->field('Email', array('id' => 'create_email', 'class' => 'span3')); ?>
            <?= $this->form->field('Website', array('id' => 'create_website', 'class' => 'span3')); ?>
            <div class="control-group" style="margin-top:-10px">
                <label class="control-label" for="create_captcha"><img id="captcha" src="<?php echo $this->url(array('Captchas::generate', 'type' => 'ajax')); ?>" alt="CAPTCHA Image" /></label>
                <div class="controls" style="padding-top:15px"><input type="text" placeholder="Captcha" class="span3" id="create_captcha" name="Captcha"></div>
            </div>
        </div>
        <div class="span6">
            <?= $this->form->field(array('Body' => 'Message'), array('type' => 'textarea', 'class' => 'span4', 'style' => 'height:175px', 'id' => 'create_body')); ?>
        </div>
    </div>
    <div class="span4 offset4">
        <div class="right">
            <input type="button" id="create_cancel" class="btn btn-large offset1 span2" value="Cancel">
            <?= $this->form->submit('Submit', array('class' => 'btn btn-success btn-large offset1 span2', "id" => "create_button", 'list' => array())); ?>
        </div>
    </div>

</div>
</div>

<?= $this->form->end(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form_create").submit(function (e) {
            e.preventDefault();
            commentAddAction("<?php echo $this->url(array('Comments::addAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> , 
            $('#create_name').val(), $('#create_email').val(), 
            $('#create_website').val(), $('#create_body').val(), function(data) { 
                displaySuccessNotice(data.details, $("#form_create .alert-area"));
                $('#create_body').val('');
                if ($.isFunction(generateComments)) generateComments();
            });
            return false;
        });

    });</script>