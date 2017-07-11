<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body style="background-color: #bbb;">
    <?php require_once 'header_view.php' ?>
    <div class="wrapper404">
        <div class="container404">
            <h1 class="title404">系统升级 敬请期待。。。。</h1>
        </div>        
    </div>  
            
    <div class="content_bg"></div>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/modules.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/theme.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script>
        jQuery(document).ready(function(){
            "use strict";
            jQuery('.wrapper404').css('margin-top', -1*(jQuery('.wrapper404').height()/2)+(jQuery('header.main_header').height()-30)/2);
        });
        jQuery(window).resize(function(){
            "use strict";
            jQuery('.wrapper404').css('margin-top', -1*(jQuery('.wrapper404').height()/2)+(jQuery('header.main_header').height()-30)/2);
        });
    </script>
</body>
</html>