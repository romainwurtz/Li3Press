<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
if ($comments) {
    ?>
<div class="span9">
<h2>Comments</h2>
</div>
        <table class="table table-striped span9">
            <tbody>
                <?php
                foreach ($comments as $comment) {
                    echo $this->_render('element', 'comment', compact('comment'), array('type' => 'html'));
                }
                ?>
            </tbody>
        </table>
<?php } ?>
