<?php echo $this->form->create(null, array("id" => "form_edit", "class" => "form-vertical")); ?>
 <fieldset>
    	<?php echo $this->form->field('title',  array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span9', 'wrap' => array('class' => 'control-group'))); ?>
    	<?php echo $this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
    	<?php echo $this->form->submit('Add Post', array('class' => 'btn btn-success btn-large span6')); ?>
    	<button class="btn btn-large span2" style="float: right"type="button">Cancel</button> 
    </div>
 </fieldset>
<?php echo $this->form->end(); ?>

<script type="text/javascript">
	$(document).ready(function() {
       new nicEditor({
	      fullPanel: true
       }).panelInstance('edit_body');
       $("#form_edit").submit(function(e) {
	      $(".alert").fadeOut('slow', function() {
		     $(this).remove();
	      });
	      $.ajaxQueue({
		     type: "POST",
		     url: ""<?php echo $this->url(array('Posts::addAction', 'id' => $this->request()->id, 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "title": $('#edit_title').val(),
                "body": $('#edit_body').val()
            },
            success: function (data) {
                if (data) {
                    if (data.success) {
                       window.location.replace(data.url);
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