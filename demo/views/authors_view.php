<?php $this->load->view('header');?>
	<section class="wrap catalogues">
		<!-- <div class="united-bg">
			<img src="<?=('assets/img/united-bg.png')?>" alt="" class="img-responsive" width="300">
		</div> -->
		<div class="row">
			<ol class="clearfix">
				<li class="letter current"><a href="javascript:;">A</a></li>
				<li class="letter"><a href="javascript:;">B</a></li>
				<li class="letter"><a href="javascript:;">C</a></li>
				<li class="letter"><a href="javascript:;">D</a></li>
				<li class="letter"><a href="javascript:;">E</a></li>
				<li class="letter"><a href="javascript:;">F</a></li>
				<li class="letter"><a href="javascript:;">G</a></li>
				<li class="letter"><a href="javascript:;">H</a></li>
				<li class="letter"><a href="javascript:;">I</a></li>
				<li class="letter"><a href="javascript:;">J</a></li>
				<li class="letter"><a href="javascript:;">K</a></li>
				<li class="letter"><a href="javascript:;">L</a></li>
				<li class="letter"><a href="javascript:;">M</a></li>
				<li class="letter"><a href="javascript:;">N</a></li>
				<li class="letter"><a href="javascript:;">O</a></li>
				<li class="letter"><a href="javascript:;">P</a></li>
				<li class="letter"><a href="javascript:;">Q</a></li>
				<li class="letter"><a href="javascript:;">R</a></li>
				<li class="letter"><a href="javascript:;">S</a></li>
				<li class="letter"><a href="javascript:;">T</a></li>
				<li class="letter"><a href="javascript:;">U</a></li>
				<li class="letter"><a href="javascript:;">V</a></li>
				<li class="letter"><a href="javascript:;">W</a></li>
				<li class="letter"><a href="javascript:;">X</a></li>
				<li class="letter"><a href="javascript:;">Y</a></li>
				<li class="letter"><a href="javascript:;">Z</a></li>
			</ol>
			<div class="col-sm-12">
				<ul class="authors clearfix">
					<li class="text-center array">A</li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people1"></span>
						<p>Anna Morgunova</p>
					</a></li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people2"></span>
						<p>Antoine Guilloppe</p>
					</a></li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people3"></span>
						<p>Aesop</p>
					</a></li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people4"></span>
						<p>Ayano Imai</p>
					</a></li>
				</ul>
				<ul class="authors clearfix">
					<li class="text-center array">B</li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people4"></span>
						<p>Barbara Ortelli</p>
					</a></li>
				</ul>
				<ul class="authors clearfix">
					<li class="text-center array">C</li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people1"></span>
						<p>Anna Morgunova</p>
					</a></li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people2"></span>
						<p>Antoine Guilloppe</p>
					</a></li>
				</ul>
				<ul class="authors clearfix">
					<li class="text-center array">E</li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people1"></span>
						<p>Anna Morgunova</p>
					</a></li>
				</ul>
				<ul class="authors clearfix">
					<li class="text-center array">F</li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people1"></span>
						<p>Anna Morgunova</p>
					</a></li>
					<li class="text-center"><a href="<?=('authorsdetail')?>">
						<span class="people people2"></span>
						<p>Antoine Guilloppe</p>
					</a></li>
				</ul>
			</div>
		</div>
		
	</section>
	<section class="foot-ban">
		<img src="<?=('assets/img/house.jpg')?>" alt="" class="img-responsive" width="100%">
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