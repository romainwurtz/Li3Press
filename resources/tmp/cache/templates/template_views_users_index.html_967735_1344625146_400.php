  <div class="row clearfix admin_action"> 
   <?php     echo $this->html->link('Create new post', $this->url(array('Posts::add')), array('class' => "btn btn-large btn-primary span3"));   ?> 
   </div>
  <div class="row clearfix admin_action"> 
   <?php     echo $this->html->link('Create new user', $this->url(array('Users::add')), array('class' => "btn btn-large btn-primary span3"));   ?>  
 </div>