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
    <header class="header bg-success">
        <div class="wrap clearfix">
            <div class="pull-left">
                <a href="<?=('about')?>" class="about">ABOUT US</a>
                <a href="<?=('contact')?>" class="contact">CONTACT US</a>
            </div>
            <div class="pull-right">
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown"><img src="<?=('assets/img/America.jpg')?>" alt="" height="16">United States
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#"><img src="<?=('assets/img/Germany.jpg')?>" alt="" height="16">Germany</a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#"><img src="<?=('assets/img/France.jpg')?>" alt="" height="16">France</a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#"><img src="<?=('assets/img/China.jpg')?>" alt="" height="16">United Kingdom/Hong Kong</a>
                        </li>
                    </ul>
                </div>
                <a href="javascript:;" class="out-link facebook"></a>
                <a href="javascript:;" class="out-link twitter"></a>
                <a href="javascript:;" class="out-link pad"></a>
                <a href="javascript:;" class="out-link camera"></a>
            </div>
        </div>

        <!-- 手机菜单 -->
        <div id="navbar">
          <a href="javascript:;" class="icon-reorder menubtn"></a>
          <a href="<?=('main')?>" class="pull-right">min<b class="text-dark">e</b>dition</a>
          <!-- use captain icon for toggle menu -->
          <div id="hamburgermenu" class="bg-success">
            <ul>
              <li><a href="<?=('news')?>">NEWS</a></li>
              <li><a href="<?=('catalogues')?>">CATALOGUES</a></li>
              <li><a href="<?=('books')?>">BOOKS</a></li>
              <li><a href="<?=('authors')?>">AUTHORS</a></li>
              <li><a href="<?=('reviews')?>">REVIEWS</a></li>
              <li><a href="<?=('introduction')?>">INTRODUCTION</a></li>
              <li><a href="<?=('about')?>">ABOUT US</a></li>
              <li><a href="<?=('contact')?>">CONTACT US</a></li>
            </ul>
          </div>
        </div>
        <div class="overlay"></div>
    </header>
    <nav class="nav">
        <div class="wrap">
            <div class="col-md-12 clearfix no-padding">
                <div class="col-sm-4">
                    <!-- <a href="javascript:;" class="logo"></a> -->
                    <a href="<?=('main')?>" title="minedition">
                        <img src="<?=('assets/img/logo.jpg')?>" alt="" class="img-responsive logo" width="250">
                    </a>
                </div>
                
                <div class="col-sm-8 clearfix">
                    <div class="col-xs-12">
                        <form class="bs-example bs-example-form" role="form">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        All 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:;">功能</a></li>
                                        <li><a href="javascript:;">另一个功能</a></li>
                                        <li><a href="javascript:;">其他</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:;">分离的链接</a></li>
                                    </ul>
                                </div>
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                <input type="text" class="form-control" placeholder="search for books">
                            </div>
                        </form>
                    </div>
                    <!-- <div class="col-xs-3 wish">
                        <i class="icon-star text-success"></i>
                        <span>WISH LISTS</span>
                    </div> -->
                </div>
                <!-- <div class="col-sm-12 clearfix">
                    <div class="col-xs-2 text-center current">
                        <a href="<?=('news')?>">NEWS</a>
                    </div>
                    <div class="col-xs-2 text-center">
                        <a href="<?=('catalogues')?>">CATALOGUES</a>
                    </div>
                    <div class="col-xs-2 text-center">
                        <a href="<?=('books')?>">BOOKS</a>
                    </div>
                    <div class="col-xs-2 text-center">
                        <a href="<?=('authors')?>">ILLUSTRATORS / AUTHORS</a>
                    </div>
                    <div class="col-xs-2 text-center">
                        <a href="<?=('reviews')?>">REVIEWS</a>
                    </div>
                    <div class="col-xs-2 text-center">
                        <a href="<?=('introduction')?>">INTRODUCTION</a>
                    </div>
                </div> -->

                <!-- 滑动菜单导航代码 -->
                <div class="col-sm-12">
                    <ul class="nav-list">
                        <li>
                            <div>
                                <a href="<?=('news')?>" class="current">NEWS</a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="<?=('catalogues')?>">CATALOGUES</a>
                            </div>
                            <ul class="second-menu">
                                <li><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                            </ul>
                        </li>
                        <li>
                            <div>
                                <a href="<?=('books')?>">BOOKS</a>
                            </div>
                            </li>
                        <li>
                            <div>
                                <a href="<?=('authors')?>">AUTHORS</a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="<?=('reviews')?>">REVIEWS</a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="<?=('introduction')?>">INTRODUCTION</a>
                            </div>
                        </li>
                        <!-- <li class="slider"></li> -->
                    </ul>
                </div>

            </div>
        </div>
        <div class="nav-bg"></div>
    </nav>
