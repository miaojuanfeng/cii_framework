<?php $this->load->view('header');?>
	<section class="wrap" id="contain">
		<div class="row reviews">
			<div class="clearfix">
				<div class="col-sm-6">
					<a href="<?=('reviewsdetail')?>">
						<img src="<?=('assets/img/three.jpg')?>" alt="" class="img-responsive" width="100%">
						<!-- <h4 class="text-right pad-right">
							<span>Intervi<b class="text-success">e</b>w</span>
						</h4> -->
					</a>
					<p>Santa Claus -All about me is a charming and wonderfully informative book by and about Santa Claus compiled bu the careative team of john and juliette Atkinson. I was very fortunate that this close before Christmas i was able to interview not only the Atkinsons,but Santa Claus himself.</p>
					<p class="text-right">
						<button class="btn btn-light">View all</button>
					</p>
				</div>
				<div class="col-sm-6">
					<a href="<?=('reviewsdetail')?>">
						<img src="<?=('assets/img/four.jpg')?>" alt="" class="img-responsive" width="100%">
						<!-- <h4 class="text-right pad-right">
							<span>Revi<b class="text-success">e</b>w</span>
						</h4> -->
						<p>Santa Claus -All about me is a charming and wonderfully informative book by and about Santa Claus compiled bu the careative team of john and juliette Atkinson. I was very fortunate that this close before Christmas i was able to interview not only the Atkinsons,but Santa Claus himself.</p>
						<p class="text-right">
							<button class="btn btn-light">View all</button>
						</p>
					</a>
				</div>
			</div>
			<div class="clearfix">
				<div class="col-sm-6">
					<a href="<?=('reviewsdetail')?>">
						<img src="<?=('assets/img/five.jpg')?>" alt="" class="img-responsive" width="100%">
						<!-- <h4 class="text-right pad-right">
							<span>Intervi<b class="text-success">e</b>w</span>
						</h4> -->
						<p>Santa Claus -All about me is a charming and wonderfully informative book by and about Santa Claus compiled bu the careative team of john and juliette Atkinson. I was very fortunate that this close before Christmas i was able to interview not only the Atkinsons,but Santa Claus himself.</p>
						<p class="text-right">
							<button class="btn btn-light">View all</button>
						</p>
					</a>
				</div>
				<div class="col-sm-6">
					<a href="<?=('reviewsdetail')?>">
						<img src="<?=('assets/img/six.jpg')?>" alt="" class="img-responsive" width="100%">
						<!-- <h4 class="text-right pad-right">
							<span>Revi<b class="text-success">e</b>w</span>
						</h4> -->
						<p>Santa Claus -All about me is a charming and wonderfully informative book by and about Santa Claus compiled bu the careative team of john and juliette Atkinson. I was very fortunate that this close before Christmas i was able to interview not only the Atkinsons,but Santa Claus himself.</p>
						<p class="text-right">
							<button class="btn btn-light">View all</button>
						</p>
					</a>
				</div>
			</div>
			
		</div>
		
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