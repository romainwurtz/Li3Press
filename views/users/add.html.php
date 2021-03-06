<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<?= $this->form->create(null, array("id" => "form_create", "class" => "form-vertical")); ?>
<fieldset>
    <?= $this->form->field('username', array('id' => 'create_username', 'autocomplete' => 'off', 'class' => 'span3', 'wrap' => array('class' => 'control-group'))); ?>
    <?= $this->form->field('password', array('type' => 'password', 'autocomplete' => 'off', 'class' => 'span3', 'id' => 'create_password', 'wrap' => array('class' => 'control-group'))); ?>
    <div style="margin-top:42px">
        <?= $this->form->submit('Create admin', array('class' => 'btn btn-success btn-large span3', "id" => "create_button")); ?>
    </div>
</fieldset>
<?= $this->form->end(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#form_create").submit(function(e) {
            $(".alert").fadeOut('slow', function() {
                $(this).remove();
            });
            $.ajaxQueue({
                type: "POST",
                url: "<?php echo $this->url(array('Users::addAction', 'type' => 'json')); ?>",
                async: true,
                cache: false,
                timeout: 50000,
                data: {
                    "username": $('#create_username').val(),
                    "password": $('#create_password').val()
                },
                success: function (data) {
                    if (data) {
                        if (data.success) {
                            $('#content').prepend('<div class="alert alert-block alert-success fade in">\
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>\
                                                <h4 class="alert-heading">Well done!</h4>\
                                                <p>This user has been successfully added.</p></div>');
                                                                        } else {
                                                                            $('#content').prepend(generateErrorNotice(data.errors));
                                                                        }
                                                                    }
                                                                },
                                                                error: function (XMLHttpRequest, textStatus, errorThrown) {}
                                                            });
                                                            return false;
                                                        });
                                                    });
</script>