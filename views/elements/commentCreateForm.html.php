<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>		
<div class="span10">
    <h2>Leave a comment</h2>
</div>

    <?= $this->form->create(null, array("id" => "form_create", "class" => "form-horizontal span10")); ?>
    <div class="alert-area" class="row"></div>
    <div class="row">
        <div class="span3" style="margin-left:0px !important;">
            <?= $this->form->field('Name', array('id' => 'create_name', 'class' => 'span2')); ?>
            <?= $this->form->field('Email', array('id' => 'create_email', 'class' => 'span3')); ?>
            <?= $this->form->field('Website', array('id' => 'create_website', 'class' => 'span3')); ?>
            <div class="control-group" style="margin-top:-10px">
                <label class="control-label" for="create_captcha"><img id="img_captcha" src="<?php echo $this->url(array('Captchas::generate', 'type' => 'ajax')); ?>" alt="CAPTCHA Image" /></label>
                <div class="controls" style="padding-top:15px"><input type="text" placeholder="Captcha" class="span3" id="create_captcha" name="Captcha"></div>
            </div>
        </div>
        <div class="span7">
            <?= $this->form->field(array('Body' => 'Message'), array('type' => 'textarea', 'class' => 'span5', 'style' => 'height:175px', 'id' => 'create_body')); ?>
        </div>
    </div>
    <div class="span4 offset5">
        <div class="right">
            <input type="button" id="create_cancel" class="btn btn-large offset1 span2" value="Cancel">
            <?= $this->form->submit('Submit', array('class' => 'btn btn-primary btn-large offset1 span2', "id" => "create_button", 'list' => array())); ?>
        </div>
    </div>
</div>

<?= $this->form->end(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form_create").submit(function (e) {
            e.preventDefault();
            commentAddAction({ "url":"<?php echo $this->url(array('Comments::addAction', 'type' => 'json')); ?>", 
                "id": "<?php echo $this->request()->id; ?>",
                "name":$('#create_name').val(),
                "email":$('#create_email').val(),
                "website": $('#create_website').val(),
                "body":$('#create_body').val(),
                "captcha":$('#create_captcha').val()}, function(data) { 
                if (data && data.success)
                {
                    displaySuccessNotice(data.details, $("#form_create .alert-area"));
                    $('#create_body').val('');
                    if ($.isFunction(generateComments)) generateComments();
                }
                $("#img_captcha").attr("src", "<?php echo $this->url(array('Captchas::generate', 'type' => 'ajax')); ?>?t=" + new Date().getTime());
            }
        );
            return false;
        });

    });</script>