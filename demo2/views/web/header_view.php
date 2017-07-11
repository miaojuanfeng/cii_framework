<header class="main_header">
    <div class="header_wrapper">
        <div class="logo_sect">
            <a href="index.html" class="logo"><embed src="<?=base_url('assets/img/logo.svg')?>" class="logo_def" type="image/svg+xml" pluginspage="http://www.adobe.com/svg/viewer/install/" /><!-- <img src="img/retina/logo.png" alt="" class="logo_retina"> --></a>
            <div class="slogan">KANGMEI INTERNATIONAL</div>
        </div>                       
        <div class="header_rp">
            <nav>
                <div class="menu-main-menu-container">
                    <ul id="menu-main-menu" class="menu">
                        <li class="<?php if( $this->router->class == 'home' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url()?>"><span>Home</span><span class="hover_show">首页</span></a>
                            <!-- <ul class="sub-menu">
                                <li class="current-menu-item"><a href="index.html"><span>Slider</span><span class="hover_show">（滑块）</span></a></li>
                                <li><a href="portfolio_masonry.html"><span>Masonry Portfolio</span><span class="hover_show">（砌体组合）</span></a></li>
                                <li><a href="horizontal_striped.html"><span>Horizontal Striped</span><span class="hover_show">（横向条纹）</span></a></li>
                                <li><a href="vertical_striped.html"><span>Vertical Striped</span><span class="hover_show">（垂直条纹）</span></a></li>                                    
                                <li><a href="revolution_slider.html"><span>Revolution Slider</span><span class="hover_show">（革命滑块）</span></a></li>
                                <li><a href="bg_image.html"><span>Image BG</span><span class="hover_show">（图像背景）</span></a></li>
                                <li><a href="bg_video.html"><span>Video BG</span><span class="hover_show">（视频背景）</span></a></li>
                                <li><a href="bg_youtube_video.html"><span>Youtube BG</span><span class="hover_show">（YouTube背景）</span></a></li>
                            </ul>       -->                      
                        </li>
                        <li class="<?php if( $this->router->class == 'about' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('about')?>"><span>About Us</span><span class="hover_show">关于我们</span></a>
                            <!-- <ul class="sub-menu">
                                <li><a href="gallery_kenburns.html"><span>Kenburns</span></a></li>
                                <li><a href="gallery_flow.html"><span>Flow</span></a></li>
                                <li><a href="gallery_ribbon.html"><span>Ribbon</span></a></li>
                                <li><a href="gallery_photo_listing.html"><span>Photo Listing</span></a></li>
                                <li><a href="gallery_grid.html"><span>Grid</span></a></li>
                                <li><a href="gallery_grid_with_margin.html"><span>Grid 2</span></a></li>
                                <li><a href="gallery_masonry.html"><span>Masonry</span></a></li>
                                <li><a href="gallery_masonry_with_margin.html"><span>Masonry 2</span></a></li>
                            </ul>    -->                         
                        </li>
                        <li class="<?php if( $this->router->class == 'show' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('show')?>"><span>Show</span><span class="hover_show">展示</span></a>
                            <!-- <ul class="sub-menu">
                                <li><a href="fullscreen_blog.html"><span>Fullscreen</span></a></li>
                                <li class="menu-item-has-children">
                                    <a href="#"><span>Standard</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="blog_with_right_sidebar.html"><span>Right Sidebar</span></a></li>
                                        <li><a href="blog_with_left_sidebar.html"><span>Left Sidebar</span></a></li>
                                        <li><a href="fullwidth_blog.html"><span>Fullwidth</span></a></li> 
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#"><span>Posts Variants</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="fullwidth_image_post.html"><span>Fullwidth Post</span></a></li>
                                        <li><a href="vimeo_video_post.html"><span>Right Sidebar</span></a></li>
                                        <li><a href="post_with_left_sidebar.html"><span>Left Sidebar</span></a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </li>
                        <li class="<?php if( $this->router->class == 'action' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('action')?>"><span>Action</span><span class="hover_show">行动</span></a>                                
                            <!-- <ul class="sub-menu">
                                <li><a href="about.html"><span>About</span></a></li>
                                <li><a href="full_width.html"><span>Full Width</span></a></li>
                                <li><a href="before_after.html"><span>Before/After</span></a></li>
                                <li><a href="coming_soon.html"><span>Coming Soon</span></a></li>
                                <li><a href="404.html"><span>404 Error</span></a></li>
                            </ul> -->
                        </li>
                        <li class="<?php if( $this->router->class == 'customer' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('customer')?>"><span>Customer</span><span class="hover_show">客户</span></a>
                            <!-- <ul class="sub-menu">
                                <li><a href="shortcodes.html"><span>Shortcodes</span></a></li>
                                <li><a href="typography.html"><span>Typography</span></a></li>
                                <li><a href="bootstrap_items.html">Bootstrap Items</a></li>
                            </ul> -->
                        </li>                            
                        <li class="<?php if( $this->router->class == 'join' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('join')?>"><span>Join Us</span><span class="hover_show">加入我们</span></a>
                            <!-- <ul class="sub-menu">
                                <li><a href="contacts_fullscreen.html"><span>Fullscreen</span></a></li>
                                <li><a href="contact_with_sidebar.html"><span>With Sidebar</span></a></li>
                                <li><a href="contact_fullwidth.html"><span>Fullwidth</span></a></li>
                            </ul>   -->
                        </li> 
                        <li class="<?php if( $this->router->class == 'join2' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('join2')?>"><span>Join Us 2</span><span class="hover_show">加入我们2</span></a>
                        </li> 
                        <li class="<?php if( $this->router->class == 'contact' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('contact')?>"><span>Contact Us</span><span class="hover_show">联系我们</span></a>
                            <!-- <ul class="sub-menu">
                                <li><a href="portfolio_grid1.html"><span>Grid Style 1</span></a></li>
                                <li><a href="portfolio_grid2.html"><span>Grid Style 2</span></a></li>
                                <li><a href="portfolio_masonry_listing.html"><span>Masonry Style</span></a></li>
                                <li><a href="portfolio_standard.html"><span>Isotope</span></a></li>
                                <li class="menu-item-has-children">
                                    <a href="#"><span>Columns</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="portfolio_1col.html"><span>1 Column</span></a></li>
                                        <li><a href="portfolio_2col.html"><span>2 Columns</span></a></li>
                                        <li><a href="portfolio_3col.html"><span>3 Columns</span></a></li>
                                        <li><a href="portfolio_4col.html"><span>4 Columns</span></a></li>   
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#"><span>Fullscreen Posts</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="fullscreen_ribbon_post.html"><span>Ribbon</span></a></li>
                                        <li><a href="fullscreen_post_without_info.html"><span>Without Info</span></a></li>
                                        <li><a href="fullscreen_post_with_info.html"><span>With Info</span></a></li>
                                        <li><a href="fullscreen_video_post_without_info.html"><span>Video Post</span></a></li>
                                        <li><a href="fullscreen_post_sidebar.html"><span>With Sidebar</span></a></li>                                        
                                    </ul>
                                </li> 
                                <li class="menu-item-has-children">
                                    <a href="#"><span>Simple Posts</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="simple_fullwidth_image_post.html"><span>Image</span></a></li>
                                        <li><a href="video_post_with_gallery.html"><span>Video</span></a></li>
                                        <li><a href="simple_image_post.html"><span>With Sidebar</span></a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </li>   
                        <li class="<?php if( $this->router->class == 'contact2' ){ echo "current-menu-parent"; } ?> menu-item-has-children">
                            <a href="<?=base_url('contact2')?>"><span>Contact Us 2</span><span class="hover_show">联系我们</span></a>
                        </li>                     
                    </ul>
                </div>
                <!-- <div class="search_fadder"></div>
                <div class="header_search">
                    <form name="search_form" method="get" action="#" class="search_form">
                        <input type="text" name="s" value="" placeholder="Search the site..." class="field_search">
                    </form> 
                </div>    -->             
            </nav>            
            <!-- <a class="search_toggler" href="#"></a> -->
        </div>
        <div class="clear"></div>
    </div>
</header>