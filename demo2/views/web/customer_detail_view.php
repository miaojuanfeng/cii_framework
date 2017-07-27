<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body>
    <?php require_once 'header_view.php' ?>
    
    <div class="main_wrapper">
    	<div class="content_wrapper">
            <div class="container simple-post-container">
                <div class="content_block no-sidebar row">
                    <div class="fl-container ">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="posts-block simple-post">
                                    <div class="contentarea">
                                        <div class="row">
                                            <div class="col-sm-12 module_cont module_blog module_none_padding module_blog_page">
                                                <div class="prev_next_links">
                                                    <div class="fleft"><a href="javascript:void(0)">Previous Post</a></div>
                                                    <div class="fright"><a href="javascript:void(0)">Next Post</a></div>
                                                </div>
                                                <div class="blog_post_page sp_post">
                                                    <div class="pf_output_container">
                                                        <div class="slider-wrapper theme-default ">
                                                            <div class="nivoSlider">
                                                                <img src="<?=base_url('assets/img/portfolio/1170_563/1.jpg')?>" alt="" />
                                                                <img src="<?=base_url('assets/img/portfolio/1170_563/2.jpg')?>" alt="" />
                                                                <img src="<?=base_url('assets/img/portfolio/1170_563/3.jpg')?>" alt="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="blogpreview_top">
                                                        <div class="box_date">
                                                            <span class="box_month">Mar</span>
                                                            <span class="box_day">03</span>
                                                        </div>
                                                        <!-- <div class="listing_meta">
                                                            <span>in <a href="javascript:void(0)">Portrait</a></span>
                                                            <span><a href="javascript:void(0)">3 comments</a></span>
                                                            <span class="preview_skills">Time spent: 12 hours</span><span class="preview_skills">Camera: Canon EOS 5D Mark II</span>
                                                        </div> -->
                                                        <div class="author_ava"><img alt="" src="<?=base_url('assets/img/avatar/2.jpg')?>" class="avatar" height="72" width="72" /></div>
                                                    </div>
                                                    <h3 class="blogpost_title">Simple Fullwidth Image Post</h3>
                                                </div><!--.blog_post_page -->

                                            </div>

                                        </div>

                                    </div><!-- .contentarea -->
                                </div>
                            </div>
                    	</div>
                    	<div class="clear"></div>
                	</div><!-- .fl-container -->
                    <div class="clear"></div>
                </div>
            </div><!-- .container -->
        </div><!-- .content_wrapper -->
	</div><!-- .main_wrapper -->
        
    <footer>
        <div class="footer_wrapper container">
            <div class="copyright">Copyright &copy; 2020 Oyster HTML Template. All Rights Reserved.</div>
            <!-- <div class="socials_wrapper">
                <ul class="socials_list">
                	<li><a class="ico_social_dribbble" target="_blank" href="http://dribbble.com/" title="Dribbble"></a></li>
                    <li><a class="ico_social_gplus" target="_blank" href="https://plus.google.com/" title="Google+"></a></li>
                    <li><a class="ico_social_vimeo" target="_blank" href="https://vimeo.com/" title="Vimeo"></a></li>
                    <li><a class="ico_social_pinterest" target="_blank" href="http://pinterest.com" title="Pinterest"></a></li>
                    <li><a class="ico_social_facebook" target="_blank" href="http://facebook.com" title="Facebook"></a></li>
                    <li><a class="ico_social_twitter" target="_blank" href="http://twitter.com" title="Twitter"></a></li>
                    <li><a class="ico_social_instagram" target="_blank" href="http://instagram.com" title="Instagram"></a></li>
            	</ul>
            </div> -->
            <div class="clear"></div>
        </div>
    </footer> 
    	    
	<div class="content_bg"></div>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/modules.js')?>"></script>    
    <script type="text/javascript" src="<?=base_url('assets/js/theme.js')?>"></script>    
	<script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>    
    <script>
		jQuery(document).ready(function(){
			"use strict";			
			jQuery('.commentlist').find('li').each(function(){
				if (jQuery(this).find('ul').size() > 0) {
					jQuery(this).addClass('has_ul');
				}
			});
			jQuery('.form-allowed-tags').width(jQuery('#commentform').width() - jQuery('.form-submit').width() - 13);
			
			jQuery('.pf_output_container').each(function(){
				if (jQuery(this).html() == '') {
					jQuery(this).parents('.blog_post_page').addClass('no_pf');
				} else {
					jQuery(this).parents('.blog_post_page').addClass('has_pf');
				}
			});			
						
		});
		jQuery(window).resize(function(){
			"use strict";
			jQuery('.form-allowed-tags').width(jQuery('#commentform').width() - jQuery('.form-submit').width() - 13);
		});
	</script>
</body>
</html>