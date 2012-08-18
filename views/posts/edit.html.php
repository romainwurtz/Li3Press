<?=$this->form->create($post, array("id" => "form_edit", "class" => "form-vertical ")); ?>
 <fieldset>
    	<div class="clearfix">
    	<?=$this->form->field('title',  array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span5', 'wrap' => array('class' => 'control-group left')));?>
    	
    	<div class="control-group right span3">
    		
    		<div class="btn-group" data-toggle="buttons-radio" id="visible_choice">
<button class="btn disabled" style="height:69px;width:100px" id="visible_text" autocomplete="off"><h3>Visible?</h3></button>
<button class="btn btn-success <?php echo (!$post->visibility) ? ("disabled") : (""); ?>" id="visible_on" style="height:69px;width:80px" autocomplete="off">YES</button>
<button class="btn btn-danger  <?php echo ($post->visibility) ? ("disabled") : (""); ?>" id="visible_off" style="height:69px;width:80px" autocomplete="off">NO</button>
</div>
    	</div>
    	
    	

    	</div>
    	<?=$this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group')));?>
    <div style="margin-top:42px">
    	<?=$this->form->submit('Edit Post', array('class' => 'btn btn-success btn-large span2 right')); ?>
<?php
	  $text = 'Show Post';
	  $class = 'btn btn-large btn-info span2 right';
	  if ($post->visibility) {
	    $text = 'Hide Post';
	    $class .= ' visible';
	  }
  
	  echo $this->html->link($text, '', array('class' => $class, 'id' => 'hide_post')); ?> 
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
            	"id" : <?php echo $this -> request() -> id ?> ,
                "title": $('#edit_title').val(),
                "body": $('#edit_body').val()
            },
            success: function (data) {
                if (data) {
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
            	"id" : <?php echo $this -> request() -> id ?> ,
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

function visibleAction(status)
{
	$.ajaxQueue({
            type: "POST",
            url: "/blog/hideAction.json",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
            	"id" : <?php echo $this -> request() -> id ?> ,
				"visibility" : status,
            },
            success: function (data) {
                if (data && data.success) {
		  			var group = $('#visible_choice');
					$('.disabled', group).not("#visible_text").removeClass('disabled');
					$('.active', group).not("#visible_text").removeClass('active');
					(status == true) ? $('#visible_off', group).addClass('disabled') : $('#visible_on', group).addClass('disabled');
					 $('#content').prepend('<div class="alert alert-block alert-success fade in">\
						<button type="button" class="close" data-dismiss="alert">&times;</button>\
						<h4 class="alert-heading">Well done!</h4>\
						<p>Your changes have been successfully saved.</p></div>');
                    } else {
                        $('#content').prepend(generateError(data.errors));
                    }
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {}
        });
}





		$("#visible_on").click(function (e) {
    e.preventDefault();
    if ($(this).hasClass('disabled')) visibleAction(true);
    return false;

});

$("#visible_off").click(function (e) {
    e.preventDefault();
    if ($(this).hasClass('disabled')) visibleAction(false);
    return false;

});
$("#visible_text").click(function (e) {
    e.preventDefault();
    return false;

>>>>>>> d986a998192e7ea3d678fdc593299b11c5745be4
});

   


		});
</script>
