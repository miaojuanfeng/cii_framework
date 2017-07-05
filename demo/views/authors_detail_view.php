<?php $this->load->view('header');?>
	<section class="wrap catalogues" id="contain">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="<?=('main')?>"><i class="glyphicon glyphicon-home text-success"></i></a></li>
				<li><a href="<?=('books')?>">Books</a></li>
				<li class="active">Mr Brown's</li>
			</ol>
			<div class="col-sm-12 clearfix no-padding">
				<div class="col-sm-4">
					<img src="<?=('assets/img/people1.jpg')?>" alt="" class="img-responsive" width="100%">
				</div>
				<div class="col-sm-8">
					<h3 class="text-success">ANNA MORGUNOVA</h3>
					<div class="brief">
						<p>
							<span>Anna Morgunova studied art in Moscow in her native Pussia,specializing in book illustration, for which she has won numerous awards. Her richly detailed style,influenced by the great artists of Modernism and Symbolism,is one that is uniquely her own,and uniquely Russian,She is a talent to watch.this is her first picture book for minedition.</span>
						</p>
					</div>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="line"></div>
			</div>
			<div class="col-sm-12 clearfix no-padding works">
				<div class="col-xs-12">
					<h4>
						<span>Related it<b class="text-success">e</b>ms</span>
					</h4>
				</div>
				<div class="col-sm-3 brief text-center">
					<a href="javascript:;">
						<img src="<?=('assets/img/hug.jpg')?>" alt="" class="img-responsive" width="100%">
					</a>
					<p>SANTA CLAUS ALL ABOUT ME</p>
                    <p>
	                    <span>Author:Juliette Atkinson</span> <br>
	                    <span>Illustrator:Juliette Atkinson</span> <br>
	                    <span>ISBN:978-988-15126-5-9</span> <br>
                    </p>
                    <p><span>US $17.99 | Can $21.99</span></p>
                    <p><button class="btn btn-light"> <i class="icon-star text-success"></i>ADD TO WISH LISTS</button></p>
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