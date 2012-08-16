	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($users as $user):
			?>
			<tr data-id="<?= $user->id ?>">
				<td><?= $user -> id ?></td>
				<td><?= $user -> username ?></td>
				<td>       
					 <div class="right btn-group">
         				<a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> Profile</a>
          				<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
         	 			<ul class="dropdown-menu">
          	  				<li><a href="<?php echo $this->url(array('Users::edit', 'id' => $user->id)); ?>"><i class="icon-pencil"></i> Edit</a></li>
            				<li class="divider"></li>
            				<li><a href="#" class="delete_user"><i class="icon-trash"></i> Delete</a></li>
          				</ul>
        			</div>
        		</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<script type="text/javascript">
	$(document).ready(function () {
   
    
        $(".delete_user").click(function (e) {
	e.preventDefault();
	var element = $(this).parents('tr');
		
	$.ajaxQueue({
            type: "POST",
            url: "<?php echo $this->url(array('Users::deleteAction', 'type' => 'json')); ?>",
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
                        $('#content').prepend(generateError(data.errors));
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {}
        });
	        });

    
    
});
</script>