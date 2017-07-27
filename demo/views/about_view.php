<?php $this->load->view('header');?>
	<section class="wrap catalogues">
		<!-- <div class="catalogues-bg">
			<img src="<?=('assets/img/introduction-bg.png')?>" alt="" class="img-responsive" width="250">
		</div> -->
		<div class="row introduction">
			<div class="col-sm-12 clearfix">
				<h4>
					<span>About Us</span>
				</h4>
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<p class="text-center">
						<img src="<?=('assets/img/logo.jpg')?>" alt="" class="img-responsive logo" width="300">
					</p>
					<p class="text-center">
						Min<u class="text-success">e</u>dition ensures books of distinction,focusing on the universal nature of imagination and wonder.
					</p>
					<p class="text-center">
						When childr<u class="text-success">e</u>an are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.
						<a href="javascript:;" class="text-success">www.prolit.de</a>
					</p>
					<p class="text-center">
						When childr<u class="text-success">e</u>an are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.
						<a href="javascript:;" class="text-success">www.sofedis.fr</a>
					</p>
					<p class="text-center">
						When childr<u class="text-success">e</u>an are exposed to exceptional <button class="btn btn-light text-success">INTRODUCTION</button>
					</p>
				</div>
				<div class="col-sm-1"></div>
			</div>
			<div class="col-sm-12">
				<h4>
					<span>Disclaim<b class="text-success">e</b>r</span>
				</h4>
				<div class="row">
					<p class="text-success">
						<strong>1</strong> Contents
					</p>
					<p>
						When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
					</p>
					<p>
						When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.
					</p>
				</div>
				<div class="row">
					<p class="text-success">
						<strong>2</strong> Contents
					</p>
					<p>
						When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
					</p>
				</div>
				<div class="row">
					<p class="text-success">
						<strong>3</strong> Contents
					</p>
					<p>
						When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
					</p>
				</div>
			</div>
		</div>
	</section>
	<section class="foot-ban">
		<img src="<?=('assets/img/fish.jpg')?>" alt="" class="img-responsive" width="100%">
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
</script>
</html>