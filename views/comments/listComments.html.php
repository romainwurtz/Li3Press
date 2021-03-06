<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<div class="alert-area"></div>	
<?php if (!empty($comments)) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="span1">ID</th>
                <th class="span2">Name</th>
                <th class="span2">Website</th>
                <th class="span3">Date</th>
                <th class="span1"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment):
                ?>
                <tr data-id="<?= $comment->comment_id ?>">
                    <td><?= $comment->comment_id ?></td>
                    <td><?= $comment->name ?></td>
                    <td><?= $comment->website ?></td>  
                    <td><?= $comment->created ?></td>  
                    <td>       
                        <div class="right btn-group">
                            <a class="btn btn-primary modal_link" href="<?php echo $this->url(array('Comments::viewAction', 'id' => $comment->comment_id, 'type' => 'ajax')); ?>"><i class="icon-home icon-white"></i> Details</a>
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="delete_comment"><i class="icon-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function () {
            $("a.modal_link").click(function(e) {
                e.preventDefault();
                commentDetailsAction({url: $(this).attr('href')}, function(data) {
                    if (data)
                        bootbox.alert(data);
                });
            });
            
            $(".delete_comment").click(function (e) {
                e.preventDefault();
                var element = $(this).parents('tr');
                postDeleteAction({'url' : "<?php echo $this->url(array('Comments::deleteAction', 'type' => 'json')); ?>", "id" : $(element).data('id')}, function () {
                    displaySuccessNotice(null, null);
                    $(element).fadeOut(300, function () {
                        $(this).remove();
                    });
                });
                return false;
            });
        });
            
    </script>



<?php } else { ?>
    <h4>You don''t have any comment.</h4>
<?php } ?>
