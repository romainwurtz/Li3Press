<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<tr>
    <td class="span2"> 
        <img class="img-rounded" width="150px" height="150px" src="<?php echo "http://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=150"; ?>">
    </td>
    <td>
        <h4> <?php
                $output = $comment->name;
                if ($comment->website)
                    $output .= " (" . $comment->website . ")";
                echo $h($output);
                ?></h4>
        <blockquote class="span7">
            <p><?= $comment->body ?></p>
        <?php if ($comment->updated) {
            echo "<small>".date('M d, Y h:i:s A', strtotime($comment->updated))."</small>";
        }  ?>
           
        </blockquote>
    </td>
</tr>