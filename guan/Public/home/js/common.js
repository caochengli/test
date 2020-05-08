

/**
 * Created by Administrator on 2018/5/3.
 */
var app = {
    basic: {
       caseImgHeight:0,
        logoHeight:0,
       wechatHeight:0,
        length:0,
        logo:"",
        logo1:"",
        wechat:"",
        wechat1:"",
        num1:'',
        num2:'',
        num3:'',
        num4:'',
        index:1,
        winHeight:0,

    },
    getLoad: function(offset,style,elem1,elem2,height){
        if(style==1){
           elem2.css({
                "height":offset,
                "backgroundPosition":"0 100%",
                "bottom":0,
                "top":""
            })
            elem1.css({
                "backgroundPosition":"0 0",
                "top":0,
                "bottom":"",
                "height":height-offset
            })
        }
        if(style==0){
            elem2.css({
             "height":height-offset,
             "bottom":0,
             "top":"",
             "backgroundPosition":"0 100%"
             /*"zIndex":20*/
             })
             elem1.css({
             "height":offset,
             "top":0,
             "bottom":"",
             "backgroundPosition":"0 0"
             })
        }
        if(style==-1){
            elem1.css({
                    "height":height-offset,
                    "bottom":0,
                    "top":"",
                    "backgroundPosition":"0 100%"
                    /*"zIndex":20*/
                }
            )
            elem2.css({
                    "height":offset,
                    /*"zIndex":10*/
                    "top":0,
                    "bottom":"",
                    "backgroundPosition":"0 0"
                }
            )
        }
    },
    calcH:function (height) {
        var imgH = height/2-60+'px';
        $('.case .right-case .item .image').height(imgH);
    },
    countFuc:function (num1,num2,num3,num4) {
        var num1Txt = num1.text();
        var num2Txt = num2.text();
        var num3Txt = num3.text();
        var num4Txt = num4.text();
        var num1Run = new countUp("num_1", 0, num1Txt, 0, 4);
        var num2Run = new countUp("num_2", 0, num2Txt, 0, 3);
        var num3Run = new countUp("num_3", 0, num3Txt, 0, 4);
        var num4Run = new countUp("percent", 0, num4Txt, 0, 2);
        if(!num1Run.error){
            num1Run.start();
            num2Run.start();
            num3Run.start();
            num4Run.start();
        }

        var num =98 * 3.6;
        //alert(num);
        if (num<=180) {
            $('.circle_income').find('.right').css('transform', "rotate(" + num + "deg)");
        } else {
            $('.circle_income').find('.right').css('transform', "rotate(180deg)");
            $('.circle_income').find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
        };
    },
    whatclick:function (index,len) {
        $('.what_nav li').eq(index-1).find('a').addClass('act');
        $('.what_nav li').eq(index-1).siblings().find('a').removeClass('act');
        var rate = -((index-1)/len)*100+'%';
        $('.whatDo .content').css('transform',"translateX("+rate+")");
        $('.toggle-box .index').text("0"+index);
        $('.toggle-box .toggle-bt span i').css('left',(index-1)*((1/len)*100)+'%');
    },
    toggleLink:function (len) {
        app.basic.index++;
        $('.fr-link .cont').css("marginTop",-(app.basic.index-1)*17+'px');
        if(app.basic.index>=len){
            app.basic.index=0;
        }
    },
    sendStatus: 0,
    setServicePopupTimer: function(a){
        setTimeout(function () {
            $(".servicePopup").css({"-webkit-transform": "translate3d(-50%,-50%,0)", transform: "translate3d(-50%,-50%,0)"})
        }, a)
    },
    closeServicePopup: function(){
        $(".servicePopup").css({
            "-webkit-transform": "translate3d(-50%,-2000px,0)",
            transform: "translate3d(-50%,-2000px,0)"
        })
    }
};
$(function () {
    app.basic.logo=$('.top-header .logo');
    app.basic.logo1=$('.top-header .logo1');
    app.basic.wechat=$('.top-header .wechat');
    app.basic.wechat1=$('.top-header .wechat1');
    app.basic.num1=$('#num_1');
    app.basic.num2=$('#num_2');
    app.basic.num3=$('#num_3');
    app.basic.num4=$('#percent');
    app.basic.length=$('.whatDo .content li').length;
    app.basic.caseImgHeight=$('.case .left-case').height();
    app.basic.logoHeight = $('.logo-area').height();
    app.basic.wechatHeight = $('.wechat-box').height();
    app.basic.winHeight = $(window).height();
   // var height = $('.case .left-case').height();
    $(window).load(function () {
        app.calcH(app.basic.caseImgHeight);
        $('.ban').height(app.basic.winHeight);
        $('.service-box .video-box').height(app.basic.winHeight);
        scrollEvent();
        // 弹窗邀请
        try {
            var urlhash = window.location.hash;
            if (!urlhash.match("fromapp"))
            {
                if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i)))
                {
                    window.location= website;//手机网站的地址
                }else{
                    app.setServicePopupTimer(1E2);
                }
            }
        }
        catch(err)
        {
        }
    });
    $(window).resize(function () {
        app.basic.caseImgHeight=$('.case .left-case').height();
        app.basic.winHeight = $(window).height();
        $('.ban').height(app.basic.winHeight);
        app.calcH(app.basic.caseImgHeight);
        $('.service-box .video-box').height(app.basic.winHeight);
    });

    // 绑定二维码事件
    /*$('.wechat-box a.bok').mouseenter(function(){
        $('.wechat-box').find('span.qrcode').css({
            'right': '90%',
            'opacity': 1
        });
    }).mouseleave(function(){
        $('.wechat-box').find('span.qrcode').css({
            'right': 0,
            'opacity': 0
        });
    });*/

    // 发送邮件
    $('.dosendmail').click(function(){
        var the = $(this);
        if(app.sendStatus == 1){
            return false;
        }
        var your_name = $.trim($('#your_name').val());
        var your_telno = $.trim($('#your_telno').val());
        var your_content = $.trim($('#your_content').val());

        // 姓名正则+手机号正则
        var regName =/^[\u4e00-\u9fa5]{2,4}$/;
        var mobileRegex =  /^(((1[3456789][0-9]{1})|(15[0-9]{1}))+\d{8})$/;

        if(!regName.test(your_name)){
            alert('姓名格式输入错误');
            return false;
        }

        if(!mobileRegex.test(your_telno)){
            alert('手机号码格式输入错误');
            return false;
        }

        app.sendStatus = 1;
        the.html('<img src="/Public/admin/dist/img/loading.gif" width="20" />');

        $.ajax({
            url: '/index.php/Help/sendMail',
            type: 'POST',
            data: {
                name: your_name,
                telno: your_telno,
                content: your_content
            },
            success: function(res){
                if(res.status == 0){
                    alert('邮件发送失败');
                    location.reload();
                }else{
                    the.html('信息提交成功');
                }
            }
        });

    });

   $('.integrity').appear();
   var b=false;
   $('.integrity').on('appear',function () {
       if(b==false){
            b=true;
            $('.integrity .content').css({'opacity':1,'top':0});
            app.countFuc(app.basic.num1,app.basic.num2,app.basic.num3,app.basic.num4);
       }
   })
    $('.cate').appear();
    //var b=false;
    $('.cate').on('appear',function () {
        $('.cate .list').css({'opacity':1,'top':0});
    })
    $('.case').appear();
    //var b=false;
    $('.case').on('appear',function () {
        $('.case .content').css({'opacity':1,'top':0});
    })
    $('.whatDo').appear();
    //var b=false;
    $('.whatDo').on('appear',function () {
        $('.whatDo .contents').css({'opacity':1,'top':0});
    })
    $('.news').appear();
    //var b=false;
    $('.news').on('appear',function () {
        $('.news .news-list').css({'opacity':1,'top':0});
    })
    $('.fr-box').appear();
    //var b=false;
    $('.fr-box').on('appear',function () {
        $('.fr-box .fr_list').css({'opacity':1,'top':0});
    })

    $('.form-box').appear();

    $('.form-box').on('appear',function () {
        $('.form-box .content').css({'opacity':1,'top':0});
    })
    $('.footer').appear();

    $('.footer').on('appear',function () {
        $('.footer .content').css({'opacity':1,'top':0});
    })

    $('.service-list .image-box .image').appear();
    $('.service-list .image-box .image').on('appear',function () {
        $(this).css({'opacity':1,'top':0});
        var index = $(this).index();
        $('.service-list .right-box .item').eq(index).css({'opacity':1,'top':0});
    })

    $('.what_nav li').each(function () {
        $(this).find('a').click(function () {
            var index = $(this).attr('data-index');
            app.whatclick(index,app.basic.length);
        })
    })
    $('.toggle-bt .next-btn').click(function () {
        var indexItem = $('.what_nav li a.act').attr('data-index');
        var index = parseInt(indexItem)+1;
        if(index>4){
            index=1;
        }
        app.whatclick(index,app.basic.length);
    })
    $('.toggle-bt .prev-btn').click(function () {
        var indexItem = $('.what_nav li a.act').attr('data-index');
        var index = parseInt(indexItem)-1;
        if(index<1){
            index=4;
        }
        app.whatclick(index,app.basic.length);
    })
    var timer;
    function autoplay() {
        var index = parseInt($('.what_nav li a.act').attr('data-index'));
        timer = setInterval(function () {
            index++;
            if(index>4){
                index=1;
            }
            app.whatclick(index,app.basic.length);
        },5000)
    }
    autoplay();

   $('.whatDo').hover(function () {
       clearInterval(timer)
   },function () {
       var index = parseInt($('.what_nav li a.act').attr('data-index'));
       timer = setInterval(function () {
           index++;
           if(index>4){
               index=1;
           }
           app.whatclick(index,app.basic.length);
       },5000)
   });

   $('.fix-menu').click(function () {
       fixnavShow();
   })
    $('.fix-nav .close_nav').click(function () {
        $('.pop-box').removeClass('act');
        $('.fix-nav').css("left","-40%");
        setTimeout(function () {
            $('.fix-nav li').css({'top':'50px',"opacity":0});
        },500)
    })
    $('.detail-nav a').click(function(){

        $(this).addClass('act').siblings().removeClass('act');
        var id = $(this).attr('data-id');
        $('#'+id).removeClass('hidden').siblings('.pro_detail_text').addClass('hidden');
    });
    $('.fix-nav .mobile_close_nav').click(function () {
        $('.pop-box').removeClass('act');
        $('.fix-nav').css("left","-80%");
        setTimeout(function () {
            $('.fix-nav li').css({'top':'50px',"opacity":0});
        },500)
    })

    $('.dropdown').click(function () {
        dropdown();
    })

    $('.mobile-header .open_munu').click(function () {
        fixnavShow();
    })
    
    $('.toggle-link').click(function () {
        var len = $('.fr-link .cont li').length;
        app.toggleLink(len);
    })
})
var scrollEvent = function () {
    var banner = $('.banner');
    var whatDo = $('.whatDo');
    var news = $('.news');
    var team = $('.team-box');
    var caseBox = $('.case-box');
    var childBan = $('.child-banner');
    if(banner.length){
        var banTop = banner.height();
        // console.log(banTop);
        if(banTop-top<73 && banTop-top>18){
            var offset =app.basic.logoHeight-(banTop-top-28);
            app.getLoad(offset,1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
        }else if(top>banTop ){
            $('.top-header .logo1').css({
                "height":app.basic.logoHeight,
            });
        }else if(top-banTop<-73){
            $('.top-header .logo1').css(
                "height","0"
            )
            $('.top-header .logo').css({
                "height":app.basic.logoHeight
            })
        }
        if(banTop-top<28){
            $('.fix-menu').addClass('act');
        }else{
            $('.fix-menu').removeClass('act');
        }
        if(banTop-top>10 && banTop-top<70){
            var offsetwechat =app.basic.wechatHeight-(banTop-top-10);
            app.getLoad(offsetwechat,1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
        }else if(top>banTop ){
            $('.top-header .wechat1').css({
                "height":app.basic.wechatHeight,
            })
        }else if(top-banTop<-70){
            $('.top-header .wechat1').css(
                "height","0"
            )
            $('.top-header .wechat').css({
                "height":app.basic.wechatHeight
            })
        }
        if(banTop-top<=40){
            $('.wechat-box').addClass('red');
        }else{
            $('.wechat-box').removeClass('red');
        }

        var swpHandel = $('.banner .swiper-wrapper');
        if(swpHandel.length){
            var swiper = new Swiper('.banner', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                autoplay: 2000,
                loop:true
            });
        }

    }
    if(whatDo.length){
        var whatTop = whatDo.offset().top;
        if(whatTop-top<73 && whatTop-top>18){
            var offset1 = whatTop-top-28;

            app.getLoad(offset1,-1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
        }else if(whatTop-top<18){
            $('.top-header .logo').css(
                "height",app.basic.logoHeight
            )
            $('.top-header .logo1').css({
                    "height":0
                }
            )
        }


        if(whatTop-top<70 && whatTop-top>10){
            var offsetwechat_1 = whatTop-top-10;

            app.getLoad(offsetwechat_1,-1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
        }else if(whatTop-top<10){
            $('.top-header .wechat').css(
                "height",app.basic.wechatHeight
            )
            $('.top-header .wechat1').css({
                    "height":0
                }
            )
        }

        if(whatTop-top<=40){
            $('.wechat-box').removeClass('red');
        }
    }
    if(news.length){
        var newsTop = news.offset().top;
        if(newsTop-top<73 && newsTop-top>18){
            var offset2 = newsTop-top-28;
            app.getLoad(offset2,0,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
        }else if(newsTop-top<18){
            $('.top-header .logo1').css(
                "height",45
            )
            $('.top-header .logo').css({
                    "height":0
                }
            )
        }

        if(newsTop-top<70 && newsTop-top>10){
            var offsetwechat_2 = newsTop-top-10;
            app.getLoad(offsetwechat_2,0,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
        }else if(newsTop-top<10){
            $('.top-header .wechat1').css(
                "height",app.basic.wechatHeight
            )
            $('.top-header .wechat').css({
                    "height":0
                }
            )
        }
        if(newsTop-top<=40){
            $('.wechat-box').addClass('red');
        }
    }
    if(childBan.length){
        var childBanTop = childBan.height();
        if(childBanTop-top<73 && childBanTop-top>18){
            var offset_child =app.basic.logoHeight-(childBanTop-top-28);

            app.getLoad(offset_child,1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
        }else if(top>childBanTop ){
            $('.top-header .logo1').css({
                "height":app.basic.logoHeight,
            });


        }else if(top-childBanTop<-73){
            $('.top-header .logo1').css(
                "height","0"
            )
            $('.top-header .logo').css({
                "height":app.basic.logoHeight
            })
        }
        if(childBanTop-top<28){
            $('.fix-menu').addClass('act');
        }else{
            $('.fix-menu').removeClass('act');
        }

        if(childBanTop-top>10 && childBanTop-top<70){
            var offset_c_wechat =app.basic.wechatHeight-(childBanTop-top-10);
            app.getLoad(offset_c_wechat,1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
        }else if(top>childBanTop ){
            $('.top-header .wechat1').css({
                "height":app.basic.wechatHeight,
            })


        }else if(top-childBanTop<-70){
            $('.top-header .wechat1').css(
                "height","0"
            )
            $('.top-header .wechat').css({
                "height":app.basic.wechatHeight
            })
        }

        if(childBanTop-top<=40){
            $('.wechat-box').addClass('red');
        }else{
            $('.wechat-box').removeClass('red');
        }
    }

    $(window).scroll(function () {
        var top = $(window).scrollTop();
        if(banner.length){
            var banTop = banner.height();
            if(banTop-top<73 && banTop-top>18){
                var offset =app.basic.logoHeight-(banTop-top-28);

              app.getLoad(offset,1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
            }else if(top>banTop ){
                $('.top-header .logo1').css({
                    "height":app.basic.logoHeight,
                })


            }else if(top-banTop<-73){
                $('.top-header .logo1').css(
                    "height","0"
                )
                $('.top-header .logo').css({
                    "height":app.basic.logoHeight
                })
            }
            if(banTop-top<28){
                $('.fix-menu').addClass('act');
            }else{
                $('.fix-menu').removeClass('act');
            }


            if(banTop-top>10 && banTop-top<70){
                var offsetwechat =app.basic.wechatHeight-(banTop-top-10);
                app.getLoad(offsetwechat,1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
            }else if(top>banTop ){
                $('.top-header .wechat1').css({
                    "height":app.basic.wechatHeight,
                })


            }else if(top-banTop<-70){
                $('.top-header .wechat1').css(
                    "height","0"
                )
                $('.top-header .wechat').css({
                    "height":app.basic.wechatHeight
                })
            }

            if(banTop-top<=40){
                $('.wechat-box').addClass('red');
            }else{
                $('.wechat-box').removeClass('red');
            }
        }
        if(whatDo.length){
            if(whatTop-top<73 && whatTop-top>18){
                var offset1 = whatTop-top-28;
                app.getLoad(offset1,-1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
            }else if(whatTop-top<18){
                $('.top-header .logo').css(
                    "height",app.basic.logoHeight
                )
                $('.top-header .logo1').css({
                        "height":0
                    }
                )
            }


            if(whatTop-top<70 && whatTop-top>10){
                var offsetwechat_1 = whatTop-top-10;

                app.getLoad(offsetwechat_1,-1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
            }else if(whatTop-top<10){
                $('.top-header .wechat').css(
                    "height",app.basic.wechatHeight
                )
                $('.top-header .wechat1').css({
                        "height":0
                    }
                )
            }

            if(whatTop-top<=40){
                $('.wechat-box').removeClass('red');
            }
        }
        if(news.length){
            if(newsTop-top<73 && newsTop-top>18){
                var offset2 = newsTop-top-28;
                app.getLoad(offset2,0,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
            }else if(newsTop-top<18){
                $('.top-header .logo1').css(
                    "height",45
                )
                $('.top-header .logo').css({
                        "height":0
                    }
                )
            }

            if(newsTop-top<70 && newsTop-top>10){
                var offsetwechat_2 = newsTop-top-10;
                app.getLoad(offsetwechat_2,0,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
            }else if(newsTop-top<10){
                $('.top-header .wechat1').css(
                    "height",app.basic.wechatHeight
                )
                $('.top-header .wechat').css({
                        "height":0
                    }
                )
            }
            if(newsTop-top<=40){
                $('.wechat-box').addClass('red');
            }
        }
        if(team.length){
            var teamTop = team.offset().top;
            if(teamTop-top<73 && teamTop-top>18){
                var offset_t =app.basic.logoHeight-(teamTop-top-28);

                app.getLoad(offset_t,1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
            }else if(top>teamTop ){
                $('.top-header .logo1').css({
                    "height":app.basic.logoHeight,
                })


            }else if(top-teamTop<-73){
                $('.top-header .logo1').css(
                    "height","0"
                )
                $('.top-header .logo').css({
                    "height":app.basic.logoHeight
                })
            }
            if(teamTop-top<28){
                $('.fix-menu').addClass('act');
            }else{
                $('.fix-menu').removeClass('act');
            }


            if(teamTop-top>10 && teamTop-top<70){
                var offset_t_wechat =app.basic.wechatHeight-(teamTop-top-10);
                app.getLoad(offset_t_wechat,1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
            }else if(top>teamTop ){
                $('.top-header .wechat1').css({
                    "height":app.basic.wechatHeight,
                })


            }else if(top-teamTop<-70){
                $('.top-header .wechat1').css(
                    "height","0"
                )
                $('.top-header .wechat').css({
                    "height":app.basic.wechatHeight
                })
            }

            if(teamTop-top<=40){
                $('.wechat-box').addClass('red');
            }else{
                $('.wechat-box').removeClass('red');
            }
        }

        if(childBan.length){
            if(childBanTop-top<73 && childBanTop-top>18){
                var offset_child =app.basic.logoHeight-(childBanTop-top-28);

                app.getLoad(offset_child,1,app.basic.logo,app.basic.logo1,app.basic.logoHeight);
            }else if(top>childBanTop ){
                $('.top-header .logo1').css({
                    "height":app.basic.logoHeight,
                });


            }else if(top-childBanTop<-73){
                $('.top-header .logo1').css(
                    "height","0"
                )
                $('.top-header .logo').css({
                    "height":app.basic.logoHeight
                })
            }
            if(childBanTop-top<28){
                $('.fix-menu').addClass('act');
            }else{
                $('.fix-menu').removeClass('act');
            }
            if(childBanTop-top>10 && childBanTop-top<70){
                var offset_c_wechat =app.basic.wechatHeight-(childBanTop-top-10);
                app.getLoad(offset_c_wechat,1,app.basic.wechat,app.basic.wechat1,app.basic.wechatHeight);
            }else if(top>childBanTop ){
                $('.top-header .wechat1').css({
                    "height":app.basic.wechatHeight,
                })


            }else if(top-childBanTop<-70){
                $('.top-header .wechat1').css(
                    "height","0"
                )
                $('.top-header .wechat').css({
                    "height":app.basic.wechatHeight
                })
            }

            if(childBanTop-top<=40){
                $('.wechat-box').addClass('red');
            }else{
                $('.wechat-box').removeClass('red');
            }
        }
    })
}

var dropdown = function () {
    var top = $(window).scrollTop();
    console.log(top);
    var banner = $('.banner');

    var cate=$('.cate');
    if(cate.length){
        var cateTop = cate.offset().top;
    }
    var cas = $('.case');
    if(cas.length){
        var casTop = cas.offset().top;
    }
    var whatDo = $('.whatDo');
    if(whatDo.length){
        var whatDoTop = whatDo.offset().top;
    }
    var fr = $('.fr-box');
    if(fr.length){
        var frTop = fr.offset().top;
    }
    var integrity = $('.integrity');
    if(integrity.length){
        var integrityTop = integrity.offset().top;
    }
    var news = $('.news');
    if(news.length){
        var newsTop = news.offset().top;
    }
    if(top<cateTop-100){
        $('html,body').animate({scrollTop:cateTop},500);
    }else if(top>=Math.floor(cateTop) && top<casTop-100){
        $('html,body').animate({scrollTop:casTop},500);
    }else if(top>=Math.floor(casTop) && top<whatDoTop-100){
        $('html,body').animate({scrollTop:whatDoTop},500);
    }else if(top>=Math.floor(whatDoTop) && top<newsTop-100){
        $('html,body').animate({scrollTop:newsTop},500);
    }else if(top>=Math.floor(newsTop) && top<frTop-100){
        $('html,body').animate({scrollTop:frTop},500);
    }else if(top>=Math.floor(frTop) && top<integrityTop-100){
        $('html,body').animate({scrollTop:integrityTop},500);
    }
}

var fixnavShow = function () {
    var len = $('.fix-nav li').length;
    $('.fix-nav').css("left",0);
    setTimeout(function () {
        Enter($(".fix-nav li").eq(0), 'top', 0, len, 300, 200);
    },500)
    $('.pop-box').addClass('act');
}
