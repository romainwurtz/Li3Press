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
<div id="loader"><?= $this->html->image('loading.gif', array('align' => 'center', "width" => "64", "height" => "64")); ?></div>


<script type="text/javascript">
$(document).ready(function() {
var ajax = false;
var currentPage = 1;
var end = false;
var url = "<?php echo $this->url(array('Posts::indexAction', 'page' => 1, 'type' => 'ajax')); ?>".slice(0,-6);
$(window).scroll(function () {
	if (end == true) return;
    if (ajax == true) return;
    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
        ajax = true;
        $('#loader').fadeIn('420', function () {
            $.ajax({
            	dataType: "html",
                url: url + (currentPage + 1) + '.ajax',
                error: function (request, data, error) {},
                success: function (data) {
					if (data && data.length > 0)
					{
						var elementScrollTo = $('article:last')
						$('#loader').before($(data));
						 $('html, body').animate({scrollTop: $(elementScrollTo).offset().top}, 'slow');
					}
					else
					end = true;
					currentPage++;


                },
                complete: function(){
                						ajax = false;
                						 $('#loader').fadeOut('420');
   }
            });


        });

    }
});
});

</script>