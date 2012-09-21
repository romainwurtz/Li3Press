<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
$title = BLOG_TITLE;
if (isset($post)) {
    $title .= " | " . $post->title;
}
?>
<!doctype html>
<html>
    <head>
        <?php echo $this->html->charset(); ?>
        <title><?php echo $title ?></title>
        <?php echo $this->html->style(array('bootstrap.min', 'li3Press')); ?>

        <?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
        <?php echo $this->html->script(array('modernizr.2.6.2', 'jquery-1.8.0.min', 'jquery.ajaxQueue', 'bootstrap.min', 'jquery.backstretch.min', 'nicEdit')); ?>
        <?php echo $this->html->script(array('li3Press')); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript">
            $(document).ready(function() {
                $.backstretch("<?php echo BLOG_BG; ?>
                ", {speed: 150});
            });

        </script>
    </head>
    <body class="app">
        <?php
        if ($this->login->isUserAuth()) {
            echo $this->_render('element', 'adminMenu');
        }
        ?>
        <div class="row">

            <header id="header" class="row">
                <div class="wrap span10 offset2 clearfix">
                    <div id="logo" class="row">
                        <h1>
                           <?php echo $this->html->link(BLOG_TITLE, "/"); ?>
                        </h1>
                        <h2>Powered by Li3 Press</h2>
                    </div>
                </div><!-- /.wrap -->
                <div class="shadow"></div>
            </header>

            <div id="container" class="row">
                    <div id="content" class="span10 offset2 ">
                        <?php echo $this->content(); ?>
                    </div>
            </div>

        </div>

    </body>
</html>