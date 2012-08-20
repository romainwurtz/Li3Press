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
<?= $this->form->create($post, array("id" => "form_edit", "class" => "form-vertical ")); ?>
<fieldset>
    <div class="clearfix">
        <?= $this->form->field('title', array('id' => 'edit_title', 'autocomplete' => 'off', 'class' => 'span5', 'wrap' => array('class' => 'control-group left'))); ?>
        <div class="control-group right span3">
            <div class="btn-group" data-toggle="buttons-radio" id="visible_choice">
                <button class="btn disabled" style="height:69px;width:100px" id="visible_text" autocomplete="off"><h3>Visible?</h3></button>
                <button class="btn btn-success <?php echo (!$post->visibility) ? ("disabled") : (""); ?>" id="visible_on" style="height:69px;width:80px" autocomplete="off">YES</button>
                <button class="btn btn-danger  <?php echo ($post->visibility) ? ("disabled") : (""); ?>" id="visible_off" style="height:69px;width:80px" autocomplete="off">NO</button>
            </div>
        </div>
    </div>
    <?= $this->form->field('body', array('type' => 'textarea', 'autocomplete' => 'off', 'class' => 'span9', 'style' => 'height:200px', 'id' => 'edit_body', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
        <?= $this->form->submit('Edit Post', array('class' => 'btn btn-success btn-large span2 right')); ?>
        <?php echo $this->html->link('Delete post', $this->url(array('Posts::editAction', 'id' => $this->request()->id)), array('class' => "btn btn-large btn-danger span2 right", 'id' => 'delete_post')); ?> 
    </div>
</fieldset>
<?= $this->form->end(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        new nicEditor({
            fullPanel: true
        }).panelInstance('edit_body');


        $("#form_edit").submit(function (e) {
            e.preventDefault();
            postEditAction("<?php echo $this->url(array('Posts::editAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> , $('#edit_title').val(), $('#edit_body').val());
            return false;
        });

        $("#delete_post").click(function (e) {
            e.preventDefault();
            postDeleteAction("<?php echo $this->url(array('Posts::deleteAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> );
            return false;
        });

        $("#visible_on").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) postVisibleAction("<?php echo $this->url(array('Posts::hideAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> , true);
            return false;

        });

        $("#visible_off").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) postVisibleAction("<?php echo $this->url(array('Posts::hideAction', 'type' => 'json')); ?>", <?php echo $this->request()->id ?> , false);
            return false;

        });
        $("#visible_text").click(function (e) {
            e.preventDefault();
            return false;
        });
  
    });</script>
