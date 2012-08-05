<?php foreach($posts as $post): ?>
<article>
    <h1><?php echo $h($post->title); ?></h1>
    <p><?php echo $post->body ?></p>
</article>
<?php endforeach; ?>
