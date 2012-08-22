<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
if ($success):
    ?>
    <article class="row" id="<?php echo $post->id ?>">
        <div class="span2">
            <h2>  <?= $this->html->link($post->title, array('controller' => "posts", "action" => "view", "id" => $post->id)) ?></h2>
            <?php
            if ($this->login->isUserAuth()) {
                echo $this->html->link('Edit', $this->url(array('Posts::edit', 'id' => $this->request()->id)), array('class' => "btn btn-large span1 right"));
            }
            ?>
        </div>
        <div class="span7">
            <p><?php echo $post->body ?></p>
        </div>
    </article>
    <div class="clearfix"></div>
    <span class="span9 dotted"></span>
    <div class="clearfix" id="list_comment"></div>
    <div id="loader"><?= $this->html->image('loading.gif', array('align' => 'center', "width" => "64", "height" => "64")); ?></div>
    <div class="clearfix"></div>
    <div class="clearfix" id="add_comment">
        <?php echo $this->_render('element', 'commentCreateForm', array(), array('type' => 'html')); ?>
    </div>

    <script type="text/javascript">
        var ajax = false;
        var loaded = false;

        function generateComments() {
            ajax = true;
            $('#list_comment').stop(true, true).fadeOut('420', function () {
                var alreadyLoaded = ($('#list_comment').html()) ? true : false;
                $(this).empty();
                $('#loader').fadeIn('420');
                commentsListAction("<?php echo $this->url(array('Comments::indexAction', 'id' => $post->id, 'type' => 'ajax')); ?>", function (comments) {
                    $('#loader').stop(true, true).fadeOut('420');
                    if (comments != null && comments.length > 0) {
                        $('#list_comment').append($(comments)).fadeIn('slow');
                        if (alreadyLoaded) {
                            var elementScrollTo = $('#list_comment tr:last');
                            $('html, body').animate({
                                scrollTop: $(elementScrollTo).offset().top
                            }, 'slow');
                        }
                    }
                    loaded = true;
                    ajax = false;
                });
            });
        }

        $(document).ready(function () {


            $(window).scroll(function () {
                if (loaded == true) return;
                if (ajax == true) return;
                if ($(window).scrollTop() >= $(document).height() - $(window).height() - $('#add_comment').position().top) {
                    generateComments();
                }
            });
        });
    </script>


<?php else: ?>
    <h1>Post not found :(</h1>	
<?php endif; ?>
