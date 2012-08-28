<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<article class="row" id="<?php echo $post->id ?>">
    <div class="span2">
        <h2>  <?= $this->html->link($post->title, array('controller' => "posts", "action" => "view", "id" => $post->id)) ?></h2>
    </div>
    <div class="span7">
        <p><?php echo $post->body ?></p>
    </div>
</article>
