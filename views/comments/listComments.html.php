<?php
/**
 * Li3Press: A simple blog using Lithium framework
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
                <th class="span4">Name</th>
                <th class="span3"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment):
                ?>
                <tr data-id="<?= $comment->comments_id ?>">
                    <td><?= $comment->comments_id ?></td>
                    <td><?= $comment->name ?></td>
                    <td>     
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
<?php } else { ?>
    <h4>You don''t have any comment.</h4>
<?php } ?>
