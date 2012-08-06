<?php if ($display) { ?>
<h2>Create admin</h2>
<?php echo $this->form->create(null, array("id" => "form_create", "class" => "form-vertical")); ?>
 <fieldset>
    <?php echo $this->form->field('username', array('id' => 'create_username', 'autocomplete' => 'on', 'class' => 'span3', 'wrap' => array('class' => 'control-group'))); ?>
    <?php echo $this->form->field('password', array('type' => 'password', 'autocomplete' => 'off', 'class' => 'span3', 'id' => 'create_pass', 'wrap' => array('class' => 'control-group'))); ?>
        <div style="margin-top:42px">
    <?php echo $this->form->submit('Create admin', array('class' => 'btn btn-success btn-large span3', "id" => "create_button")); ?>
        </div>
     </fieldset>
<?php echo $this->form->end(); ?>
<?php } else { ?>
<h1>Please remove the file <i>install</i> in your root directory</h1>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
       $("#form_create").submit(function(e) {
	      $(".alert").fadeOut('slow', function() {
		     $(this).remove();
	      });
	      $.ajaxQueue({
		     type: "POST",
		     url: "<?php echo $this->url(array('Installs::addAction', 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "user": $('#create_username').val(),
                "password": $('#create_pass').val()
            },
            success: function (data) {
                if (data) {
                    if (data.success) {
$('#content').empty().prepend('<div class="alert alert-block alert-success fade in">\
						<h4 class="alert-heading">Well done!</h4>\
						<p>Your changes have been successfully saved.</p></div>');
                    } else {
                        $('#content').prepend(generateError(data.errors));
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {}
        });
        return false;
    });
});
</script>