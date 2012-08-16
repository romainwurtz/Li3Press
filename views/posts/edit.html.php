<?=$this->form->create($post, array("id" => "form_edit", "class" => "form-vertical ")); ?>
 <fieldset>
    	<?=$this->form->field('title',  array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span9', 'wrap' => array('class' => 'control-group')));?>
    	<?=$this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group')));?>
    <div style="margin-top:42px">
    	<?=$this->form->submit('Edit Post', array('class' => 'btn btn-success btn-large span2 right')); ?>
	<?php $text = 'Hide Post'; if (!$post->visibility) $text = 'Show Post';
	  echo $this->html->link($text, '', array('class' => 'btn btn-large btn-info span2 right', 'id' => 'hide_post')); ?> 
    	<?php echo $this->html->link('Delete post', $this->url(array('Posts::editAction', 'id' => $this->request()->id)), array('class' => "btn btn-large btn-danger span2 right", 'id' => 'delete_post')); ?> 
    </div>
 </fieldset>
<?=$this->form->end(); ?>

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

        $("#delete_post").click(function (e) {
	e.preventDefault();
	$.ajaxQueue({
            type: "POST",
            url: "<?php echo $this->url(array('Posts::deleteAction', 'id' => $this->request()->id, 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "id": <?php echo $this -> request() -> id ?> ,
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
	        });

    $("#hide_post").click(function (e) {
	e.preventDefault();
	var button = $(this);
	$.ajaxQueue({
            type: "POST",
            url: "<?php echo $this->url(array('Posts::hideAction', 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "id": <?php echo $this -> request() -> id ?> ,
		"visibility" : !($(this).hasClass('visible')),
            },
            success: function (data) {
                if (data) {
		  if (data.success) {
		      console.log($(button).hasClass('visible'));
		      if ($(button).hasClass('visible')) {
			$(button).removeClass('visible');
			$(button).html('Show Post');
		      }
		      else {
			$(button).addClass('visible');
			$(button).html('Hide Post');
		      }
                    } else {
                        $('#content').prepend(generateError(data.errors));
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {}
        });
	        });
});
</script>
