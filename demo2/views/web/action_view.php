<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body>
    <?php require_once 'header_view.php' ?>
    
    <div class="gallery_kenburns">
        <canvas id="kenburns">
            <p>Your browser doesn't support canvas!</p>
        </canvas>
    </div>    
    <div class="content_bg"></div>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/modules.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/theme.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script type="text/javascript">
        gallery_set = [
            '<?=base_url('assets/img/gallery/kenburns/1.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/2.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/3.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/4.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/5.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/6.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/7.jpg')?>',
            '<?=base_url('assets/img/gallery/kenburns/8.jpg')?>'
        ]
        jQuery(document).ready(function(){
            "use strict";
            jQuery('html').addClass('without_border');
            jQuery('#kenburns').attr('width', window_w);
            jQuery('#kenburns').attr('height', window_h-header.height());
            jQuery('#kenburns').kenburns({
                images: gallery_set,
                frames_per_second: 30,
                display_time: 5000,
                fade_time: 1000,
                zoom: 1.2,
                background_color:'#000000'
            });
            jQuery('#kenburns').css('top', header.height()+'px');
        });
    
        function kenburns_resize() {
            "use strict";
            jQuery('.gallery_kenburns').append('<canvas id="kenburns"><p>Your browser does not support canvas!</p></canvas>');
            jQuery('#kenburns').attr('width', window_w);
            jQuery('#kenburns').attr('height', window_h-header.height());
                jQuery('#kenburns').kenburns({
                    images: gallery_set,
                    frames_per_second: 30,
                    display_time: 5000,
                    fade_time: 1000,
                    zoom: 1.2,
                    background_color:'#000000'
                });             
                jQuery('#kenburns').css('top', header.height()+'px');
        }
        jQuery(window).resize(function(){ 
            "use strict";
            jQuery('#kenburns').remove();
            setTimeout('kenburns_resize()',300);
        });                         
    </script>
</body>
</html>