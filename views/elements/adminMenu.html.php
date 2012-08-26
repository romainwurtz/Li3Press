<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            <?php echo $this->html->link(BLOG_TITLE . " administration", $this->url(array('Users::index')), array('class' => 'brand')); ?> 

            <div class="nav-collapse">
                <ul class="nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Posts <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->html->link('List', $this->url(array('Posts::listPosts'))); ?>  
                            </li>
                            <li>
                                <?php echo $this->html->link('Create', $this->url(array('Posts::add'))); ?> 
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->html->link('List', $this->url(array('Users::listUsers'))); ?>  
                            </li>
                            <li>
                                <?php echo $this->html->link('Create', $this->url(array('Users::add'))); ?>  
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Comments <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->html->link('List', $this->url(array('Comments::listComments'))); ?>  
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li>
                        <a href="#" class="user"></i><?= $this->login->displayName(); ?></a>
                    </li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->