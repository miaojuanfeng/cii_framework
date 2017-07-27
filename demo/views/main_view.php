<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>minedition</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <link rel="stylesheet" href="<?=('assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=('assets/css/font-awesome.min.css')?>">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="<?=('assets/css/idangerous.swiper.css')?>">
    <link rel="stylesheet" href="<?=('assets/css/style.css')?>">
    <!--[if lte IE 9]>
        <script src="<?=('assets/js/respond.min.js')?>"></script>
        <script src="<?=('assets/js/html5.js')?>"></script>
    <![endif]-->
    <script src="<?=('assets/js/jquery-1.10.1.min.js')?>"></script>
    <script src="<?=('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?=('assets/js/jquery.min.js')?>"></script>
    <!-- Swiper JS -->
    <script src="<?=('assets/js/idangerous.swiper.min.js')?>"></script>
    <script src="<?=('assets/js/common.js')?>"></script>
</head>
<body>
    <header class="header">
        <div class="wrap clearfix">
            <div class="pull-left">
                <a href="<?=('about')?>" class="about">ABOUT US</a>
                <a href="<?=('contact')?>" class="contact">CONTACT US</a>
            </div>
            <div class="pull-right">
                <a href="javascript:;" class="out-link facebook"></a>
                <a href="javascript:;" class="out-link twitter"></a>
                <a href="javascript:;" class="out-link pad"></a>
                <a href="javascript:;" class="out-link camera"></a>
            </div>
        </div>

        <!-- 手机菜单 -->
        <div id="navbar">
          <a href="javascript:;" class="icon-reorder menubtn"></a>
          <a href="<?=('main')?>" class="pull-right">min<b class="text-success">e</b>dition</a>
          <!-- use captain icon for toggle menu -->
          <div id="hamburgermenu">
            <ul>
              <li><a href="<?=('news')?>">NEWS</a></li>
              <li><a href="<?=('catalogues')?>">CATALOGUES</a></li>
              <li><a href="<?=('books')?>">BOOKS</a></li>
              <li><a href="<?=('authors')?>">AUTHORS</a></li>
              <li><a href="<?=('reviews')?>">REVIEWS</a></li>
              <li><a href="<?=('introduction')?>">INTRODUCTION</a></li>
              <li><a href="javascript:;">ABOUT US</a></li>
              <li><a href="<?=('contact')?>">CONTACT US</a></li>
            </ul>
          </div>
        </div>
        <div class="overlay"></div>
    </header>
    <section class="banner">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><span class="swiper-banner banner1"></span></div>
                <div class="swiper-slide"><span class="swiper-banner banner2"></span></div>
                <div class="swiper-slide"><span class="swiper-banner banner3"></span></div>
            </div>
            <div class="pagination"></div>
        </div>
        
    </section>
    <section class="title wrap">
        <div class="row clearfix">
            <div class="col-sm-3">
                <a href="javascript:;">
                    <h2 class="text-center">min<b class="text-warning">e</b>dition</h2>
                    <p class="text-warning text-center">Germany</p>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="javascript:;">
                    <h2 class="text-center">min<b class="text-primary">e</b>dition</h2>
                    <p class="text-primary text-center">France</p>
                </a>
            </div>
            <div class="col-sm-3 current">
                <a href="<?=('news')?>">
                    <h2 class="text-center">min<b class="text-success">e</b>dition</h2>
                    <p class="text-success text-center">United States</p>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="javascript:;">
                    <h2 class="text-center">min<b class="text-danger">e</b>dition</h2>
                    <p class="text-danger text-center">United Kingdom/Hong Kong</p>
                </a>
            </div>
        </div>

        <div class="copyright clearfix">
            <div class="col-sm-6">Designed be Cheers Communication Ltd.</div>
            <div class="col-sm-6 text-right">@2017 Michael Neugebauer Edition,Inc.All rights reserved.</div>
        </div>

    </section>
</body>
<!-- Initialize Swiper -->
<script>
var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true,
    autoplay: 3000
})

</script>
</html>