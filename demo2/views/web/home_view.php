<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body>
	<?php require_once 'header_view.php' ?>

    <div class="slider"></div>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/modules.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/theme.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/js/videojs-ie8.min.js')?>"></script>
    <script src="<?=base_url('assets/js/video.js')?>"></script>
    <script>
		jQuery(document).ready(function(){
			"use strict";
			jQuery('html').addClass('hasPag');
			
			jQuery('.fs_share').click(function(){
				jQuery('.fs_fadder').removeClass('hided');
				jQuery('.fs_sharing_wrapper').removeClass('hided');
				jQuery('.fs_share_close').removeClass('hided');
			});
			jQuery('.fs_share_close').click(function(){
				jQuery('.fs_fadder').addClass('hided');
				jQuery('.fs_sharing_wrapper').addClass('hided');
				jQuery('.fs_share_close').addClass('hided');
			});
			jQuery('.fs_fadder').click(function(){
				jQuery('.fs_fadder').addClass('hided');
				jQuery('.fs_sharing_wrapper').addClass('hided');
				jQuery('.fs_share_close').addClass('hided');
			});
			
			jQuery('.close_controls').click(function(){
				if (jQuery(this).hasClass('open_controls')) {
					jQuery('.fs_controls').removeClass('hide_me');
					jQuery('.fs_title_wrapper ').removeClass('hide_me');
					jQuery('.fs_thmb_viewport').removeClass('hide_me');
					jQuery('header.main_header').removeClass('hide_me');
					jQuery(this).removeClass('open_controls');
				} else {		
					jQuery('header.main_header').addClass('hide_me');
					jQuery('.fs_controls').addClass('hide_me');
					jQuery('.fs_title_wrapper ').addClass('hide_me');
					jQuery('.fs_thmb_viewport').addClass('hide_me');
					jQuery(this).addClass('open_controls');
				}
			});
			
			jQuery('.main_header').removeClass('hided');
			jQuery('html').addClass('without_border');			
		});
	</script> 

	<?php
	if( $isMobile ){
	?>
	<!-- 图片代码开始 -->
	<script type="text/javascript">
		gallery_set = [
			{image: "<?=base_url('assets/img/gallery/slider/1.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/1.jpg')?>", alt: "SEASHORE", title: "SEASHORE", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},
			{image: "<?=base_url('assets/img/gallery/slider/2.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/2.jpg')?>", alt: "Colors", title: "Colors", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/3.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/3.jpg')?>", alt: "Forest", title: "Forest", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/4.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/4.jpg')?>", alt: "Coffee", title: "Coffee", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/5.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/5.jpg')?>", alt: "Dude", title: "Dude", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},
			{image: "<?=base_url('assets/img/gallery/slider/6.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/6.jpg')?>", alt: "Summer", title: "Summer", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/7.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/7.jpg')?>", alt: "Skate", title: "Skate", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},
			{image: "<?=base_url('assets/img/gallery/slider/8.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/8.jpg')?>", alt: "Forest", title: "Forest", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/9.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/9.jpg')?>", alt: "Mountains", title: "Mountains", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/10.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/10.jpg')?>", alt: "Seashore", title: "Seashore", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/11.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/11.jpg')?>", alt: "Pier", title: "Pier", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/12.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/12.jpg')?>", alt: "Desert", title: "Desert", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/13.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/13.jpg')?>", alt: "Mountains", title: "Mountains", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/14.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/14.jpg')?>", alt: "Tourist", title: "Tourist", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/15.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/15.jpg')?>", alt: "Fog", title: "Fog", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/16.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/16.jpg')?>", alt: "Desert", title: "Desert", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},			
			{image: "<?=base_url('assets/img/gallery/slider/17.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/17.jpg')?>", alt: "Seashore", title: "Seashore", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"},		
			{image: "<?=base_url('assets/img/gallery/slider/18.jpg')?>", thmb: "<?=base_url('assets/img/gallery/slider/thumbs/18.jpg')?>", alt: "Stones", title: "Stones", description: "Discover elegant solution for your online portfolio", titleColor: "#ffffff", descriptionColor: "#ffffff"}
		]
		
		jQuery(document).ready(function(){
			"use strict";
			jQuery('body').fs_gallery({
				fx: 'fade', /*fade, zoom, slide_left, slide_right, slide_top, slide_bottom*/
				fit: 'no_fit',
				slide_time: 3300, /*This time must be < then time in css*/
				autoplay: 1,
				show_controls: 1,
				slides: gallery_set
			});
		});
	</script>
	<!-- 图片代码结束 -->
	<?php
	}else{
	?>
	<!-- 视频代码开始 -->
    <section class="video">
        <video id="my-video1" class="video-js vjs-big-play-centered" preload="auto" autoplay width="1920" height="1080">
            <source src="<?=base_url('assets/video/KM.mp4')?>" type='video/mp4'>
        </video>
    </section>
    <!-- <video id="video" autoplay="autoplay">
	    <source src="<?=base_url('assets/video/KM.mov')?>" type="video/mp4">
	</video> -->
    <script>
       (function($){
            var list = [
                {name:"KM", url: "<?=base_url('assets/video/KM.mov')?>", lastTime:0},
                {name:"shichang", url: "<?=base_url('assets/video/KM.mov')?>", lastTime:0},
            ];

            var resetVideoSize = function(myPlayer){
                var videoJsBoxWidth = $(".video-js").width();
                var ratio = 1920/1080;
                var videoJsBoxHeight = videoJsBoxWidth/ratio;
                myPlayer.height(videoJsBoxHeight);
            }
            var myPlayer = videojs("my-video1").ready(function(){

                this.width("100%");
                resetVideoSize(myPlayer);
            });
            $(window).on("resize", function(){
                resetVideoSize(myPlayer); 
            });
        })(jQuery)
    </script>
    <!-- 视频代码结束 -->
    <?php
    }
    ?>
    <script type="text/javascript" src="<?=base_url('assets/js/fs_gallery.js')?>"></script>
</body>
</html>