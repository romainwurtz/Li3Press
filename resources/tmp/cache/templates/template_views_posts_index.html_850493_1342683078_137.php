<?php foreach($posts as $post): ?>
<article>
    <h1><?php echo $h($post->title); ?></h1>
    <p><?php echo $h($post->body); ?></p>
</article>
<?php endforeach; ?>