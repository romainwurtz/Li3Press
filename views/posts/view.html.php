<?php if ($success): ?>
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
<?php else: ?>
<h1>Post not found :(</h1>	
<?php endif; ?>
