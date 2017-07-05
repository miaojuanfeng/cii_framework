$(document).ready(function(){
  var W = $(window).width();
  // 手机导航
  //$(function(){
    var menuwidth  = 180; // 边栏宽度
    var menuspeed  = 400; // 边栏滑出耗费时间
    
    var $bdy       = $('body');
    var $container = $('#pgcontainer');
    var $burger    = $('#hamburgermenu');
    var negwidth   = "-"+menuwidth+"px";
    var poswidth   = menuwidth+"px";
    
    //$(window).resize(function() { console.log('b');
    //  if(W<768){
        // $('#navbar').css('display','block');

        $('.menubtn').on('click',function(e){
          if($bdy.hasClass('openmenu')) {
            jsAnimateMenu('close');
          } else {
            jsAnimateMenu('open');
          }
        });
        
        $('.overlay').on('click', function(e){
          if($bdy.hasClass('openmenu')) {
            jsAnimateMenu('close');
          }
        });
        
        function jsAnimateMenu(tog) {
          if(tog == 'open') {
            $bdy.addClass('openmenu');
            
            $container.animate({marginRight: negwidth, marginLeft: poswidth}, menuspeed);
            $burger.animate({width: poswidth}, menuspeed);
            $('.overlay').animate({left: poswidth}, menuspeed);
          }
          
          if(tog == 'close') {
            $bdy.removeClass('openmenu');
            
            $container.animate({marginRight: "0", marginLeft: "0"}, menuspeed);
            $burger.animate({width: "0"}, menuspeed);
            $('.overlay').animate({left: "0"}, menuspeed);
          }
        }
    //  }
    //});
  //});

  // var foot_h = $(".footer .col-sm-8").height();
  // $(".footer .col-sm-4").css("line-height",foot_h+'px');
  // $(window).resize(function() {
  //   if( W>1200 ){
  //     var foot_h = $(".footer .col-sm-8").height();
  //     $(".footer .col-sm-4").css("line-height",foot_h+'px');
  //   };

  //   if( W<768 ){
  //     var foot_h = $(".footer .col-sm-8").height();
  //     $(".footer .col-sm-4").css("line-height",1);
  //   };

  // });
  
  // if( W<768 ){
  //   var foot_h = $(".footer .col-sm-8").height();
  //   $(".footer .col-sm-4").css("line-height",1);
  // };
  
});

;(function ($) {
  $.fn.extend({
    ImgLoading: function (options) {
      var defaults = {
        errorimg: "http://www.oyly.net/Images/default/Journey/journeydetail.png",
        loadimg: "http://www1.ytedu.cn/cnet/dynamic/presentation/net_23/images/loading.gif",
        Node: $(this).find("img"),
        timeout: 1000
      };
      var options = $.extend(defaults, options);
      var Browser = new Object();
      var plus = {
        BrowserVerify:function(){
          Browser.userAgent = window.navigator.userAgent.toLowerCase();
          Browser.ie = /msie/.test(Browser.userAgent);
          Browser.Moz = /gecko/.test(Browser.userAgent);
        },
        EachImg: function () {
          defaults.Node.each(function (i) {
            var img = defaults.Node.eq(i);
            plus.LoadEnd(Browser, img.attr("imgurl"), i, plus.LoadImg);
          })
        },
        LoadState:function(){
          defaults.Node.each(function (i) {
            var img = defaults.Node.eq(i);
            var url = img.attr("src");
            img.attr("imgurl", url);
            img.attr("src",defaults.loadimg);
          })
        },
        LoadEnd: function (Browser, url, imgindex, callback) {
          var val = url;
          var img = new Image();
          if (Browser.ie) {
            img.onreadystatechange = function () {
              if (img.readyState == "complete" || img.readyState == "loaded") {
                callback(img, imgindex);
              }
            }
          } else if (Browser.Moz) {
            img.onload = function () {
              if (img.complete == true) {
                callback(img, imgindex);
              }
            }
          }
          img.onerror = function () { img.src = defaults.errorimg }
          img.src = val;
        },
        LoadImg: function (obj, imgindex) {
          setTimeout(function () {
            defaults.Node.eq(imgindex).attr("src", obj.src);
          }, defaults.timeout);
        }
      }
      plus.LoadState();
      plus.BrowserVerify();
      plus.EachImg();
    }
  }); 
})(jQuery);