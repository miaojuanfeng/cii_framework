<?php $this->load->view('header');?>
	<section class="wrap contacts">
		<!-- <div class="contact-bg">
			<img src="<?=('assets/img/contact-bg.png')?>" alt="" class="img-responsive" width="250">
		</div> -->
		<div class="row clearfix">
			<div class="col-sm-6 comment">
				<h4>
					<span>Comm<b class="text-success">e</b>nt</span>
				</h4>
				<p>We're always happy to take your Comments and queations.</p>
				<form class="form-horizontal" role="form">
				  <div class="form-group">
				    <label for="subject">Subject</label>
				    <input type="text" class="form-control" id="subject" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="name">Full Name</label>
				    <input type="text" class="form-control" id="name" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="email">E-mail</label>
				    <input type="email" class="form-control" id="email" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="comment">Comment</label>
				    <textarea name="" id="" cols="30" rows="8" class="form-control"></textarea>
				  </div>
				  <div class="form-group text-right">
				    <button type="submit" class="btn btn-success">SUBMIT</button>
				  </div>
				</form>
			</div>
			<div class="col-sm-1"></div>
			<div class="col-sm-5 clearfix contact">
				<h4>
					<span>Contact Us</span>
				</h4>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					</p>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					</p>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					</p>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					</p>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					</p>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="text-success">Michael Neugebauer Edition</div>
					<p>
						<span>Am Gerstenfeld 622941 Bargtehelde</span>
					<p>
						<label for="">Tel</label>
						<span>:04532/268700</span>
					</p>
					<p>
						<label for="">Fax</label>
						<span>:04532/268701</span>
					</p>
				</div>
			</div>
		</div>
	</section>
	<section class="foot-ban">
		<img src="<?=('assets/img/rainbow.jpg')?>" alt="" class="img-responsive" width="100%">
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