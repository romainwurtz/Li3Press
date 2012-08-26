<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
if ($posts) {
    foreach ($posts as $post) {
        echo $this->_render('element', 'post', compact('post'), array('type' => 'html'));
    }
}
?>
<div id="loader"><?= $this->html->image('loading.gif', array('align' => 'center', "width" => "64", "height" => "64")); ?></div>


<script type="text/javascript">
    $(document).ready(function () {
        var ajax = false;
        var end = false;
        var currentPage = <?php echo $page; ?>;  
        
        $(window).scroll(function () {
            if (end == true) return;
            if (ajax == true) return;
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
                ajax = true;
                // FIXME : Do something better for the url here
                postsIndexAction("<?php echo substr($this->url(array('Posts::indexAction', 'page' => 1, 'type' => 'ajax')), 0, -6); ?>", currentPage + 1, function (posts) {
                    if (posts != null && posts.length > 0) {
                        var elementScrollTo = $('article:last')
                        $('#loader').before($(posts));
                        $('html, body').animate({
                            scrollTop: $(elementScrollTo).offset().top
                        }, 'slow');
                        currentPage++;
                    } else end = true;
                    ajax = false;
                    $('#loader').fadeOut('420');
                });
            }
        });
    });

</script>
