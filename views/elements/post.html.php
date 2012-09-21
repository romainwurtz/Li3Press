<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<article class=" entry row clearfix" id="<?php echo $post->id ?>">
    <a title="<?= $post->title ?>" href="<?php echo $this->url(array('controller' => "posts", "action" => "view", "id" => $post->id)); ?>" >
        <div class="thumb span3">
            <img width="400" height="250" title="Snap Motion Screenshot 1" alt="Snap Motion Screenshot 1" class="attachment-homepage-thumb wp-post-image" src="http://placehold.it/400x250&text=Li3%20Press">
        </div>
        <div class="content-entry span7">
            <header>
                <h1><?= $post->title ?></h1>
            </header>
            <p><?php echo $this->text->limit_words($post->body, 42, '...'); ?></p>
        <?= $this->html->link('Read More', array('controller' => "posts", "action" => "view", "id" => $post->id), array('class' => 'btn pull-right')) ?>

        </div>
    </a>
</article>
