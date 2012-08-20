<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<article class="row user_profile" id="<?php echo $user->id ?>">
    <div class="span2">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/260x180" alt="">
        </a>
        <br />
    </div>
    <div class="span7">
        <h1>Edit</h1>
        <!--
        <div id="dropzone" class="fade well">Drop files here</div>
        <input id="fileupload" type="file" name="files[]" data-url="<?php echo $this->url(array('Uploads::add', 'type' => 'upload')); ?>" multiple>
        <div id="progress">
            <div class="bar" style="width: 0%;"></div>
        </div>
        -->
        <?= $this->form->create(null, array("id" => "form_create", "class" => "form-vertical")); ?>
        <fieldset>
            <?= $this->form->field('username', array('id' => 'edit_username', 'autocomplete' => 'off', 'class' => 'span3', 'wrap' => array('class' => 'control-group'))); ?>
            <div style="margin-top:42px">
                <?= $this->form->submit('Save', array('class' => 'btn btn-success btn-large span3', "id" => "create_button")); ?>
            </div>
        </fieldset>
        <?= $this->form->end(); ?>
    </div>
</article>






<script type="text/javascript">
    $(document).ready(function() {
        
        
        $(document).bind('dragover', function (e) {
            var dropZone = $('#dropzone'),
            timeout = window.dropZoneTimeout;
            if (!timeout) {
                dropZone.addClass('in');
            } else {
                clearTimeout(timeout);
            }
            if (e.target === dropZone[0]) {
                dropZone.addClass('hover');
            } else {
                dropZone.removeClass('hover');
            }
            window.dropZoneTimeout = setTimeout(function () {
                window.dropZoneTimeout = null;
                dropZone.removeClass('in hover');
            }, 100);
        });
        
        
        $('#fileupload').fileupload({
            dataType: 'json',
            dropZone: $('#dropzone'),
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                'width',
                progress + '%'
            );
            }
        });
        
        
        $("#form_create").submit(function(e) {
            $(".alert").fadeOut('slow', function() {
                $(this).remove();
            });
            $.ajaxQueue({
                type: "POST",
                url: "<?php echo $this->url(array('Users::editAction', 'type' => 'json')); ?>",
                async: true,
                cache: false,
                timeout: 50000,
                data: {
                    "id" : <?php echo $this->request()->id ?> ,
                    "username": $('#edit_username').val(),
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