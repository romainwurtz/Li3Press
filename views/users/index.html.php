<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<div class="row clearfix admin_action"> 
   <?php     echo $this->html->link('Create new post', $this->url(array('Posts::add')), array('class' => "btn btn-large btn-primary span3"));   ?> 
   </div>
  <div class="row clearfix admin_action"> 
   <?php     echo $this->html->link('Create new user', $this->url(array('Users::add')), array('class' => "btn btn-large btn-primary span3"));   ?>  
 </div>