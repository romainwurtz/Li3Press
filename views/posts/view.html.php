<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

if ($success): ?>
<article class="row" id="<?php echo $post->id ?>">
	<div class="span2">
    <h1>  <?= $this->html->link($post->title, array('controller' => "posts", "action" => "view", "id" => $post->id))  ?></h1>
    <?php if ($this->login->isUserAuth()) {
    echo $this->html->link('Edit', $this->url(array('Posts::edit', 'id' => $this->request()->id)), array('class' => "btn btn-large span1 right"));  
   	} ?>
    </div>
    	<div class="span7">
    <p><?php echo $post->body ?></p>
    </div>
</article>
<div id="loader"><?= $this->html->image('loading.gif', array('align' => 'center', "width" => "64", "height" => "64")); ?></div>
<?php echo $this->_render('element', 'commentCreateForm', array(), array('type' => 'html')); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var ajax = false;
        var loaded = false;
        
        $(window).scroll(function () {
            if (loaded == true) return;
            if (ajax == true) return;
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
                ajax = true;
                // FIXME : Do something better for the url here
                commentsListAction("<?php echo $this->url(array('Comments::indexAction', 'id' => $post->id, 'type' => 'ajax')); ?>", function (comments) {
                    if (comments != null && comments.length > 0) {
                       /*
                       var elementScrollTo = $('article:last')
                        $('#loader').before($(posts));
                        $('html, body').animate({
                            scrollTop: $(elementScrollTo).offset().top
                        }, 'slow');
                        currentPage++;
                        */
                    } 
                    loaded = true;
                    ajax = false;
                    $('#loader').fadeOut('420');
                });
            }
        });
    });

</script>


<?php else: ?>
<h1>Post not found :(</h1>	
<?php endif; ?>
