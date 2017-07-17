		

		<div class="header-area">

			<h1 class="btn btn-primary btn-md"><i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;&nbsp;KM CMS</h1>
			<div class="shadow-area"></div>

			<div class="menu-area">
				<div class="container-fluid">
					<div class="row">
						
						<div class="menu-column-area col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ms-6">
							<h3 class="corpcolor-font">Link</h3>
							<ul>
								<li><a href="<?=cii_base_url('cms/dashboard')?>">Dashboard</a></li>
								<li><a href="<?=cii_base_url()?>" target="_blank">Website</a></li>
							</ul>
						</div>
						
						<div class="menu-column-area col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ms-6">
							<h3 class="corpcolor-font">Content</h3>
							<ul>
								<!-- <li><a href="<?=cii_base_url('cms/main')?>">Main</a></li>
								<li><a href="<?=cii_base_url('cms/menu')?>">Menu</a></li>
								<li><a href="<?=cii_base_url('cms/news')?>">News</a></li> -->
								<li><a href="<?=cii_base_url('cms/page')?>">Page</a></li>
								<li><a href="<?=cii_base_url('cms/video')?>">Video</a></li>
							</ul>
						</div>
						
						<div class="menu-column-area col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ms-6">
							<h3 class="corpcolor-font">Data preset</h3>
							<ul>
								<!-- <li><a href="<?=cii_base_url('cms/catalogues')?>">Catalogues</a></li>
								<li><a href="<?=cii_base_url('cms/book')?>">Book</a></li> -->
								<li><a href="<?=cii_base_url('cms/banner')?>">Banner</a></li>
								<!-- <li><a href="<?=cii_base_url('cms/ai')?>">Author/Illustrator</a></li> -->
							</ul>
						</div>
						
						<div class="menu-column-area col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ms-6">
							<!-- <h3 class="corpcolor-font">System setting / log</h3>
							<ul>
								<li><a href="<?=cii_base_url('cms/log')?>">System log</a></li>
							</ul> -->
							<h3 class="corpcolor-font">Permission / role / user</h3>
							<ul>
								<li><a href="<?=cii_base_url('cms/role')?>">Role</a></li>
								<li><a href="<?=cii_base_url('cms/user')?>">User</a></li>
							</ul>
						</div>

					</div>
				</div>
			</div>

		</div> <!-- header-area -->


		<div class="btn-group show-myself">
			<a href="#" class="btn btn-primary btn-ms dropdown-toggle" data-toggle="dropdown">
				<i class="glyphicon glyphicon-user"> <?=ucfirst(($this->session->userdata('user_id')))?></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-right" role="menu">
				<!--数据库有错， user_name拿不到-->
				<li><a href="<?=cii_base_url('cms/login')?>">Logout: <?=ucfirst(($this->session->userdata('user_id')))?></a></li>
			</ul>
		</div>

<?php //$a = ucfirst(get_user($this->session->userdata('user_id'))->user_name); echo $a; ?>