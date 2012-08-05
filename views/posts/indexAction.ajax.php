<?php foreach($posts as $post): ?>
<article class="row" id="<?php echo $post->id ?>">
	<div class="span2">
    <h1>  <?= $this->html->link($post->title, array('controller' => "posts", "action" => "view", "id" => $post->id))  ?></h1>
    </div>
    	<div class="span7">
    <p><?php echo $post->body ?></p>
    </div>
</article>
<?php endforeach; ?>