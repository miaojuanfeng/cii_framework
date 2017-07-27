<?php $this->load->view('header');?>
	<section class="wrap catalogues" id="contain">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="<?=('main')?>"><i class="glyphicon glyphicon-home text-success"></i></a></li>
				<li><a href="<?=('books')?>">Books</a></li>
				<li class="active">Mr Brown's Fantasic Hat</li>
			</ol>
			<div class="col-sm-12 clearfix no-padding">
				<div class="col-sm-4 text-center">
					<img src="<?=('assets/img/hat.jpg')?>" alt="" class="img-responsive" width="100%">
					<div class="row">
						<div class="col-sm-6 text-center bd-right">
							<span><i class="icon-book text-success"></i> VIEW ENTIRE BOOK</span>
						</div>
						<div class="col-sm-6 text-center">
							<span><i class="icon-file text-success"></i> VIEW AI SHEET</span>
						</div>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="clearfix">
						<h3 class="text-success pull-left">MR.BROWN'S FANTASIC HAT <br>
							<span>ISBN:978=988-8240-84-5</span>
						</h3>
						<button class="btn btn-light pull-right"> <i class="icon-star text-success"></i>ADD TO WISH LISTS</button>
					</div>
					
					<div class="brief">
						<p>US $17.99 | Can $21.99</p>
						<p>
							<span class="relevant-name">Author</span>
							<span>: Ayano Imai</span>
						</p>
						<p>
							<span class="relevant-name">Illustrator</span>
							<span>: Ayano Imai</span>
						</p>
						<p>
							<span class="relevant-name">Information</span>
							<span>: 8.6X13",32 pages,
						</p>
						<p>
							<span class="relevant-name"></span>
							<span style="text-indent: 8px;">Color throughout. Laminated hardcover</span>
						</p>
						<ul>
							<li><small class="bg-success"></small>Eccentric and captivating tale.</li>
							<li><small class="bg-success"></small>Eccentric and captivating tale.</li>
							<li><small class="bg-success"></small>Eccentric and captivating tale.</li>
						</ul>
						<p><span>Who needs friends?So Mr.Brown thinks to himself.He thinks all the he nedds is his comfortable house and his smart hat.</span></p>
						<p><span>Who needs friends?So Mr.Brown thinks to himself.He thinks all the he nedds is his comfortable house and his smart hat.</span></p>
					</div>
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