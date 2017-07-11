<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body>
    <?php require_once 'header_view.php' ?>
    
    <div class="fw_content_wrapper">
        <div class="fw_content_padding">
            <div class="content_wrapper noTitle">
                <div class="container">
                    <div class="content_block row no-sidebar">
                        <div class="fl-container ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="posts-block ">
                                        <div class="contentarea">
                                            <div class="row">
                                                <div class="col-sm-8 first-module module_number_1 module_cont pb0 module_text_area">
                                                    <div class="bg_title"><h2 class="headInModule">关于km(About Us)</h2></div>
                                                    <div class="module_content">
                                                        <?=$page->page_content?>
                                                    </div>
                                                </div><!-- .module_cont -->

                                                <div class="col-sm-4 module_number_2 module_cont pb0 pl27 module_text_area">
                                                    <div class="module_content">
                                                        <p><img src="<?=base_url('assets/uploads/page/'.$page->page_id)?>" alt="" width="460" height="406" /></p>
                                                    </div>
                                                </div><!-- .module_cont -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="fixed_bg bg1"></div> -->
           
    <div class="content_bg"></div>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/modules.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/theme.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script>
        jQuery(document).ready(function(){
            "use strict";
            centerWindow();
            if (window_w > 760) {
                jQuery('html').addClass('without_border');
            }
        });
        jQuery(window).load(function(){
            "use strict";
            centerWindow();
        });
        jQuery(window).resize(function(){
            "use strict";
            centerWindow();
            setTimeout('centerWindow()',500);
            setTimeout('centerWindow()',1000);
        });
        function centerWindow() {
            "use strict";
            setTop = (window_h - jQuery('.fw_content_wrapper').height() - header.height())/2+header.height();
            if (setTop < header.height()+50) {
                jQuery('.fw_content_wrapper').addClass('fixed');
                jQuery('body').addClass('addPadding');
                jQuery('.fw_content_wrapper').css('top', header.height()+50+'px');
            } else {
                jQuery('.fw_content_wrapper').css('top', setTop +'px');
                jQuery('.fw_content_wrapper').removeClass('fixed');
                jQuery('body').removeClass('addPadding');
            }
        }
    </script>
</body>
</html>