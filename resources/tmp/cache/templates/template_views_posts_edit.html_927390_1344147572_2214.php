<?php echo $this->form->create($post, array("id" => "form_edit", "class" => "form-vertical ")); ?>
 <fieldset>
    	<?php echo $this->form->field('title',  array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span9', 'wrap' => array('class' => 'control-group'))); ?>
    	<?php echo $this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
    	<?php echo $this->form->submit('Edit Post', array('class' => 'btn btn-success btn-large span6')); ?>
    	<?php echo $this->form->submit('Delete Post', array('class' => 'btn btn-large span2', 'style' => 'float:right')); ?>
    </div>
 </fieldset>
<?php echo $this->form->end(); ?>

<script type="text/javascript">
	$(document).ready(function () {
    new nicEditor({
        fullPanel: true
    }).panelInstance('edit_body');
    $("#form_edit").submit(function (e) {
        $(".alert").fadeOut('slow', function () {
            $(this).remove();
        });
        $.ajaxQueue({
            type: "POST",
            url: "<?php echo $this->url(array('Posts::editAction', 'id' => $this->request()->id, 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "id": <?php echo $this -> request() -> id ?> ,
                "title": $('#edit_title').val(),
                "body": $('#edit_body').val()
            },
            success: function (data) {
                if (data) {
                    console.log(data);
                    if (data.success) {
                        $('#content').prepend('<div class="alert alert-block alert-success fade in">\
						<button type="button" class="close" data-dismiss="alert">&times;</button>\
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