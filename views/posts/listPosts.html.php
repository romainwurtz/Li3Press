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
<?php if (!empty($posts)) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="span1">ID</th>
                <th class="span4">Title</th>
                <th class="span3"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post):
                ?>
                <tr data-id="<?= $post->id ?>">
                    <td><?= $post->id ?></td>
                    <td><?= $post->title ?></td>
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
                postDeleteAction("<?php echo $this->url(array('Posts::deleteAction', 'type' => 'json')); ?>", $(element).data('id'), function () {
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
    <h4>You don't have any post.</h4>
<?php } ?>
