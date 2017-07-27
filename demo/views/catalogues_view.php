<?php $this->load->view('header');?>
	<section class="wrap catalogues" id="contain">
		<!-- <div class="catalogues-bg">
			<img src="<?=('assets/img/catalogues-bg.png')?>" alt="" class="img-responsive" width="300">
		</div> -->
		<div class="row">
			<div class="dropdown">
				<span>Sort By</span>
			    <button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Popularity
			        <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			        <li role="presentation">
			            <a role="menuitem" tabindex="-1" href="#">Germany</a>
			        </li>
			        <li role="presentation">
			            <a role="menuitem" tabindex="-1" href="#">France</a>
			        </li>
			        <li role="presentation">
			            <a role="menuitem" tabindex="-1" href="#">United Kingdom/Hong Kong</a>
			        </li>
			    </ul>
			</div>
			<div class="col-sm-12 clearfix download-list">
				<div class="col-xs-12">
					<p><span>NEW</span></p>
				</div>
				<div class="col-sm-3 text-center">
					<a href="javascript:;">
						<!-- <span class="download book1"></span> -->
						<img src="<?=('assets/img/bear.jpg')?>" alt="" class="img-responsive" width="100%">
						<button class="btn btn-light">DOWNLOAD <span class="glyphicon glyphicon-arrow-down text-success"></span></button>
					</a>
					<p>MINEDITION CATALOGUES FALL 2016</p>
				</div>
				<div class="col-sm-3 text-center">
					<a href="javascript:;">
						<!-- <span class="download book2"></span> -->
						<img src="<?=('assets/img/bear.jpg')?>" alt="" class="img-responsive" width="100%">
						<button class="btn btn-light">DOWNLOAD <span class="glyphicon glyphicon-arrow-down text-success"></span></button>
					</a>
					<p>MINEDITION CATALOGUES FALL 2016</p>
				</div>
				<div class="col-sm-3 text-center">
					<a href="javascript:;">	
						<!-- <span class="download book3"></span> -->
						<img src="<?=('assets/img/bear.jpg')?>" alt="" class="img-responsive" width="100%">
						<button class="btn btn-light">DOWNLOAD <span class="glyphicon glyphicon-arrow-down text-success"></span></button>
					</a>
					<p>MINEDITION CATALOGUES FALL 2016</p>	
				</div>
			</div>
			
		</div>
		
	</section>
	<section class="foot-ban">
		<img src="<?=('assets/img/flower.jpg')?>" alt="" class="img-responsive" width="100%">
	</section>
	<?php $this->load->view('footer');?>
</body>
<script>
// 滑动导航
$(".nav-list li div").hover(function (e) {

	// make sure we cannot click the slider
	if ($(this).hasClass('slider')) {
		return;
	}

	/* Add the slider movement */
	var liW = $(".nav-list li div").width();
	// what tab was pressed
	var whatTab = $(this).index();

	// Work out how far the slider needs to go
	var howFar = liW * whatTab;

	$(".slider").css({
		left: howFar + "px"
	});

	/* Add the ripple */

	// Remove olds ones
	$(".ripple").remove();

	// Setup
	var posX = $(this).offset().left,
	  	posY = $(this).offset().top,
	  	buttonWidth = $(this).width(),
	  	buttonHeight = $(this).height();

	// Add the element
	$(this).prepend("<span class='ripple'></span>");

	// Make it round!
	if (buttonWidth >= buttonHeight) {
		buttonHeight = buttonWidth;
	} else {
		buttonWidth = buttonHeight;
	}

	// Get the center of the element
	var x = e.pageX - posX - buttonWidth / 2;
	var y = e.pageY - posY - buttonHeight / 2;

	// Add the ripples CSS and start the animation
	$(".ripple").css({
		width: buttonWidth,
		height: buttonHeight,
		top: y + 'px',
		left: x + 'px'
	}).addClass("rippleEffect");
});

$("#contain").ImgLoading({
    errorimg: "assets/images/doc.png",
    loadimg: "assets/img/loading.gif",
    timeout: 1000
});
</script>
</html>