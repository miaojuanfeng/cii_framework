<?php $this->load->view('header');?>
	<section class="wrap catalogues">
		<!-- <div class="catalogues-bg">
			<img src="<?=('assets/img/introduction-bg.png')?>" alt="" class="img-responsive" width="250">
		</div> -->
		<div class="row introduction">
			<h3>
				min<b class="text-success">e</b>dition · <b class="text-success">mi</b>chael <b class="text-success">ne</b>ugebauer e<b class="text-success">dition</b>
			</h3>
			<div class="col-sm-12">
				<h4>
					<span>Our Mission</span>
				</h4>
				<p>
					min<u class="text-success">e</u>dition publishes picture books of the highest quality <br>
					that "open the door to the world" for children.
				</p>
				<p>
					<strong class="text-success">B</strong>y working with exciting international artists and authors,min<u class="text-success">e</u>dition ensures books of distinction,focusing on the universal nature of imagination and wonder. When children are exposed to exceptional books, if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and a greater appreciation of the multi-cultural world in which we live.
				</p>
				<p>
					When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
				</p>
			</div>
			<div class="col-sm-12">
				<h4>
					<span>Our B<b class="text-success">e</b>ginning</span>
				</h4>
				<p>
					<strong class="text-success">B</strong>y working with exciting international artists and authors,min<u class="text-success">e</u>dition ensures books of distinction,focusing on the universal nature of imagination and wonder.
				</p>
				<p>
					When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
				</p>
			</div>
			<div class="col-sm-12">
				<h4>
					<span>Partn<b class="text-success">e</b>rs in Quality</span>
				</h4>
				<p>
					<strong class="text-success">B</strong>y working with exciting international artists and authors,min<u class="text-success">e</u>dition ensures books of distinction,focusing on the universal nature of imagination and wonder.
				</p>
				<p>
					When childrean are exposed to exceptional books,if they have the chance to discover amazing books,they can develop much more than just a deeper appreciation of word and art.Such books can foster understanding and greater appreciation of the multi-cultural world in which we live.
				</p>
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