	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($posts as $post):
			?>
			<tr data-id="<?= $post->id ?>">
				<td><?= $post -> id ?></td>
				<td><?= $post -> title ?></td>
				<td>       <?php $this->url(array('Posts::edit', 'id' => $post->id)); ?>
					 <div class="right btn-group">
         				<a class="btn btn-primary" href="<?php echo $this->url(array('Posts::view', 'id' => $post->id)); ?>"><i class="icon-home icon-white"></i> View</a>
          				<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
         	 			<ul class="dropdown-menu">
          	  				<li><a href="<?php echo $this->url(array('Posts::edit', 'id' => $post->id)); ?>"><i class="icon-pencil"></i> Edit</a></i>
            				<li class="divider"></li>
            				<li><a href="#" class="delete_post"><i class="icon-trash"></i> Delete</a></li>
          				</ul>
        			</div>
        		</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<script type="text/javascript">
	$(document).ready(function () {
   
    
        $(".delete_post").click(function (e) {
	e.preventDefault();
	var element = $(this).parents('tr');
		
	$.ajaxQueue({
            type: "POST",
            url: "<?php echo $this->url(array('Posts::deleteAction', 'type' => 'json')); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            data: {
                "id": $(element).data('id'),
            },
            success: function (data) {
                if (data) {
                    if (data.success) {
						$('#content').prepend('<div class="alert alert-block alert-success fade in">\
						<button type="button" class="close" data-dismiss="alert">&times;</button>\
						<h4 class="alert-heading">Well done!</h4>\
						<p>This user has been successfully added.</p></div>');
						$(element).fadeOut(300, function() { $(this).remove(); });
                    } else {
                        $('#content').prepend(generateErrorNotice(data.errors));
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {}
        });
	        });

    
    
});
</script>