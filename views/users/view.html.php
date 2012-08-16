<?php if ($success): ?>
<article class="row user_profile" id="<?php echo $user->id ?>">
	<div class="span2">
		<a href="#" class="thumbnail">
			<img src="http://placehold.it/260x180" alt="">
		</a>
		<br />
    <?php
	if ($this -> login -> isUserAuth()) {
		echo $this -> html -> link('Edit', $this -> url(array('Users::edit', 'id' => $this -> request() -> id)), array('class' => "btn btn-large span1 right"));
	}
 ?>
    </div>
    	<div class="span7">
       <h1> 
       	<?= $this -> html -> link($user -> username, array('controller' => "users", "action" => "view", "id" => $user -> id), array('style')) ?></h1>
    <p></p>
    </div>
</article>
<?php else: ?>
<h1>User not found :(</h1>	
<?php endif; ?>
