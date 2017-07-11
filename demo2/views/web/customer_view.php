<!DOCTYPE html>
<html class="fullscreen_page sticky_menu">
<head>
    <?php require_once 'meta_view.php' ?>
    <title>KANGMEI INTERNATIONAL</title>
</head>
<body>
    <?php require_once 'header_view.php' ?>
    
    <div class="fullscreen_block hided">
        <ul class="optionset" data-option-key="filter">
            <li class="selected"><a href="#filter" data-option-value="*">All Works</a></li>
            <li><a data-option-value=".advertisement" href="#filter" title="View all post filed under advertisement">Advertisement</a></li>
            <li><a data-option-value=".cities" href="#filter" title="View all post filed under cities">Cities</a></li>
            <li><a data-option-value=".fashion" href="#filter" title="View all post filed under fashion">Fashion</a></li>
            <li><a data-option-value=".nature" href="#filter" title="View all post filed under nature">Nature</a></li>
            <li><a data-option-value=".portrait" href="#filter" title="View all post filed under portrait">Portrait</a></li>
            <li><a data-option-value=".stuff" href="#filter" title="View all post filed under stuff">Stuff</a></li>
        </ul>
        <div class="fs_blog_module image-grid">
            <div class="blogpost_preview_fw element stuff">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/1.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Lorem ipsum dolor</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>7715</span></div>                            
                            <div class="gallery_likes gallery_likes_add already_liked">
                                <i class="stand_icon icon-heart"></i>
                                <span>129</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element advertisement">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>" >
                            <img src="<?=base_url('assets/img/portfolio/grid/2.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Integer ante odio</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>1187</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>132</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div> 
            <div class="blogpost_preview_fw element stuff">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/3.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Sed cursus ante</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>4786</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>113</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element fashion">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/4.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Nulla quis sem at</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>5558</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>77</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element nature">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/5.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Duis sagittis ipsum</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>2692</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>26</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div> 
            <div class="blogpost_preview_fw element portrait">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/6.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Praesent mauris</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>5262</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>40</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element advertisement">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>" >
                            <img src="<?=base_url('assets/img/portfolio/grid/7.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Fusce nec tellus</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>5858</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>41</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element fashion portrait">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/8.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Class aptent taciti</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>2411</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>23</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element stuff">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/9.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Sed dignissim nunc</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>2684</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>31</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element nature">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/10.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Class aptent taciti</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>2228</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>25</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element fashion portrait">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>" >
                            <img src="<?=base_url('assets/img/portfolio/grid/11.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Nunc feugiat mi</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>1283</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>25</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element stuff">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>" >
                            <img src="<?=base_url('assets/img/portfolio/grid/12.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Integer euismod lacus</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>1110</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>23</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div> 
            <div class="blogpost_preview_fw element nature">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/13.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Vestibulum ante</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>1442</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>15</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element cities stuff">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/14.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Donec lacus nunc</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>2206</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>16</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>
            <div class="blogpost_preview_fw element advertisement">
                <div class="fw_preview_wrapper">
                    <div class="gallery_item_wrapper">
                        <a href="<?=base_url('customer/detail')?>">
                            <img src="<?=base_url('assets/img/portfolio/grid/15.jpg')?>" alt="" class="fw_featured_image" width="540">
                            <div class="gallery_fadder"></div>
                            <span class="gallery_ico"><i class="stand_icon icon-eye"></i></span>
                        </a>
                    </div>
                    <div class="grid-port-cont">
                        <h6><a href="<?=base_url('customer/detail')?>">Integer lacinia massa</a></h6>
                        <div class="block_likes">
                            <div class="post-views"><i class="stand_icon icon-eye"></i> <span>1945</span></div>                            
                            <div class="gallery_likes gallery_likes_add">
                                <i class="stand_icon icon-heart-o"></i>
                                <span>29</span>
                            </div>                                          
                        </div>                            
                    </div>                                            
                </div>
            </div>      
        </div>                       
    </div>
    <div class="preloader"></div>     
    <footer class="fullwidth">
        <div class="footer_wrapper">
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
    <script type="text/javascript" src="<?=base_url('assets/js/jquery.isotope.min.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/sorting.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            "use strict";
            setTimeout(function(){
                jQuery('.fullscreen_block').removeClass('hided');
            },2500);
            setTimeout("jQuery('.preloader').remove()", 2700);          
        }); 
    </script>      
</body>
</html>