<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
			<?php echo $this->html->link(BLOG_TITLE." administration", $this->url(array('Users::index')), array('class' => 'brand')); ?> 
			
			<div class="nav-collapse">
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Posts <b class="caret"></b></a>
						<ul class="dropdown-menu">
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
								<a href="#">List</a>
							</li>
							<li>
								   <?php echo $this->html->link('Create', $this->url(array('Users::add'))); ?>  
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li>
						<a href="#" class="user"></i>TOTO</a>
					</li>
				</ul>
			</div><!-- /.nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div><!-- /navbar -->