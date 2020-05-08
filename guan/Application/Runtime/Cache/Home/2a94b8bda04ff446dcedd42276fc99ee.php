<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <title><?php echo (seoFun('t',$pageArr['seo_title'])); ?></title>
    <link rel="shortcut icon" type="img/ico" href="/Public/home/images/favicon.ico" />
    <meta name="Keywords" content="<?php echo (seoFun('k',$pageArr['seo_keyword'])); ?>">
    <meta name="description" content="<?php echo (seoFun('d',$pageArr['seo_desc'])); ?>"/>
    <meta name="copyright" content="<?php echo C('SITE_META_COPYRIGHT');?>" />
    <link href="/Public/home/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/Public/home/css/swiper.min.css" rel="stylesheet" type="text/css">
    <link href="/Public/home/css/commen.css" rel="stylesheet" type="text/css">
    <link href="/Public/home/css/public.css" rel="stylesheet" type="text/css">
    
    <link href="/Public/home/css/index.css" rel="stylesheet" type="text/css">
    
    <link href="/Public/home/css/media.css" rel="stylesheet" type="text/css">
    <script src="/Public/home/js/jquery-1.7.2.min.js"></script>
    <script src="/Public/home/js/vue.min.js"></script>
    <script src="/Public/home/js/jquery.appear.min.js"></script>
    <script src="/Public/home/js/swiper.min.js"></script>
    <script src="/Public/home/js/countup.min.js"></script>
    <script src="/Public/home/js/move.js"></script>
    <script src="/Public/home/js/common.js"></script>
</head>
<body>
<!--#header-->
<header class="top-header">
    <aside class="logo-area">
        <a class="logo bok" href="/index.html"></a>
        <a class="logo1 bok" href="javascript:void(0)"></a>
    </aside>
    <article class="container-box">
        <div class="text-logo pull-left">
            <a href="/index.html">
                <img src="/Public/home/images/text-logo.png" class="img-responsive">
            </a>
        </div>
        <ul class="nav-list pull-right">
            <li><a href="/case/index.html">客户案例</a></li>
            <li><a href="/serv/h5/index.html">响应式网站</a></li>
            <li><a href="/serv/applets/index.html">微信小程序开发</a></li>
            <li><a href="/serv/app/index.html">移动端设计</a></li>
            <li><a href="/serv/vi/index.html">视觉平面</a></li>
            <li><a href="/serv/video/index.html">影视制作</a></li>
            <li><a href="/serv/sale/index.html">网络营销</a></li>
            <li><a href="/about/index.html">公司</a></li>
            <li><a href="/news/index.html">知识</a></li>
            <li><a href="/contact/index.html">联系</a></li>
        </ul>
    </article>
    <aside class="wechat-box">
        <a class="wechat bok" href="javascript:void(0)"></a>
        <a class="wechat1 bok" href="javascript:void(0)"></a>
        <span class="trans qrcode">
            <img src="<?php echo C('SITE_WX_IMG');?>" width="100">
        </span>
    </aside>
</header>
<!--#end header-->
<section id="appRoot">
    
    <!--#banner-->
    <section class="banner swiper-container">
        <aside class="swiper-wrapper">
            <?php if(is_array($rssup)): $i = 0; $__LIST__ = $rssup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?><a href="<?php echo ($rs['links']); ?>" class="bok swiper-slide"><img src="<?php echo ($rs['pic']); ?>" class="img-responsive"></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </aside>
        <div class="swiper-pagination"></div>
        <article class="container-box"></article>
    </section>
    <!--#end banner-->
    <!--#cate-->
    <section class="cate">
        <article class="container-box">
            <div class="pub-title">
                <div class="title">十年，追求极致的视觉设计与交互体验砥砺前行</div>
                <div class="com">TEN YEARS, PURSUE THE ULTIMATE VISUAL DESIGN AND INTERACTIVE EXPERIENCE TO ADVANCE.</div>
            </div>
            <div class="list clearfix trans">
                <a class="bok item" href="/serv/h5/index.html">
                    <div class="cont">
                        <div class="image trans">
                            <img src="/Public/home/images/itm-1.png" class="img-responsive">
                            <div class="change-img">
                                <img src="/Public/home/images/itm-1-1.png" class="img-responsive">
                            </div>
                        </div>
                        <div class="text">
                            <div class="t">响应式网站</div>
                            <div class="com">WEB</div>
                        </div>
                    </div>
                </a>
                <a class="bok item" href="/serv/vi/index.html">
                    <div class="cont">
                        <div class="image trans">
                            <img src="/Public/home/images/itm-2.png" class="img-responsive">
                            <div class="change-img">
                                <img src="/Public/home/images/itm-2-2.png" class="img-responsive">
                            </div>
                        </div>
                        <div class="text">
                            <div class="t">视觉平面</div>
                            <div class="com">BRAD VI</div>
                        </div>
                    </div>
                </a>
                <a class="bok item" href="/serv/app/index.html">
                    <div class="cont">
                        <div class="image trans">
                            <img src="/Public/home/images/itm-3.png" class="img-responsive">
                            <div class="change-img">
                                <img src="/Public/home/images/itm-3-3.png" class="img-responsive">
                            </div>
                        </div>
                        <div class="text">
                            <div class="t">移动端终端设计</div>
                            <div class="com">MOBILE</div>
                        </div>
                    </div>
                </a>
                <a class="bok item" href="/serv/applets/index.html">
                    <div class="cont">
                        <div class="image trans">
                            <img src="/Public/home/images/itm-4.png" class="img-responsive">
                            <div class="change-img">
                                <img src="/Public/home/images/itm-4-4.png" class="img-responsive">
                            </div>
                        </div>
                        <div class="text">
                            <div class="t">微信小程序开发</div>
                            <div class="com">WECHAT</div>
                        </div>
                    </div>
                </a>
                <a class="bok item" href="/serv/sale/index.html">
                    <div class="cont">
                        <div class="image trans">
                            <img src="/Public/home/images/itm-5.png" class="img-responsive">
                            <div class="change-img">
                                <img src="/Public/home/images/itm-5-5.png" class="img-responsive">
                            </div>
                        </div>
                        <div class="text">
                            <div class="t">网络营销</div>
                            <div class="com">SEO</div>
                        </div>
                    </div>
                </a>
            </div>
        </article>
    </section>
    <!--#case-->
    <section class="case">
        <article class="container-box">
            <div class="content trans">
                <div class="pub-title">
                    <div class="title">与您分享一些不同的</div>
                    <div class="com">SHARE SOME DIFFERENT THINGS WITH YOU</div>
                </div>
                <div class="case-list">
                    <aside class="left-case">
                        <?php if(is_array($caselist)): $i = 0; $__LIST__ = array_slice($caselist,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="item bok" href="<?php echo ($vo['links']); ?>">
                            <div class="image">
                                <img src="<?php echo ($vo['one_pic']); ?>" class="img-responsive">
                                <div class="cover"></div>
                            </div>
                            <div class="com trans"><?php echo ($vo['title']); ?></div>
                        </a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </aside>
                    <aside class="right-case clearfix">
                        <?php if(is_array($caselist)): $i = 0; $__LIST__ = array_slice($caselist,1,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="item bok" href="<?php echo ($vo['links']); ?>">
                            <div class="image">
                                <img src="<?php echo ($vo['defaultpic']); ?>" class="img-responsive">
                                <div class="cover"></div>
                            </div>
                            <div class="com trans"><?php echo ($vo['title']); ?></div>
                        </a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </aside>
                </div>
                <a href="/case/index.html" class="loadMore bok f-eng trans">LOAD MORE</a>
            </div>
        </article>

    </section>
    <!--#whatDo-->
    <section class="whatDo">
        <article class="container-box">
            <div class="contents trans">
                <aside class="nav-box clearfix">
                    <img src="/Public/home/images/icon_1.png">
                    <ul class="what_nav">
                        <li><a href="javascript:void(0)" class="act" data-index="1">大客户定制</a></li>
                        <li><a href="javascript:void(0)" data-index="2">强的流程化管理</a></li>
                        <li><a href="javascript:void(0)" data-index="3">快速反映机制</a></li>
                        <li><a href="javascript:void(0)" data-index="4">全方位深入支持</a></li>
                    </ul>
                    <a href="##" class="more f-eng pull-right in-line">MORE</a>
                </aside>
                <aside class="over">
                    <div class="bg">
                        <div class="toggle-box">
                            <div class="num">
                                <span class="index">01</span>/<span class="total">04</span>
                                <div class="toggle-bt">
                                    <a href="javascript:void(0)" class="prev-btn"><i class="icon">&#xe9ff;</i></a>
                                    <span><i class="trans"></i></span>
                                    <a href="javascript:void(0)" class="next-btn"><i class="icon">&#xea00;</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="clearfix content trans">
                        <li class="trans">
                            <div class="num">01</div>
                            <div class="image"><img src="/Public/home/images/what-1.jpg" class="img-responsive"></div>
                            <div class="cont">
                                <div class="tit"><span>大客户定制</span></div>
                                <div class="com">大客户定制项目，由专业的团队来服务，成立项目组，三次内部头脑风暴，提交两套以上的方案，根据双方拟定时间进度表,完成项</div>
                            </div>
                        </li>
                        <li class="trans">
                            <div class="num">02</div>
                            <div class="image"><img src="/Public/home/images/what-1.jpg" class="img-responsive"></div>
                            <div class="cont">
                                <div class="tit"><span>强的流程化管理</span></div>
                                <div class="com">大客户定制项目，由专业的团队来服务，成立项目组，三次内部头脑风暴，提交两套以上的方案，根据双方拟定时间进度表,完成项</div>
                            </div>
                        </li>
                        <li class="trans">
                            <div class="num">03</div>
                            <div class="image"><img src="/Public/home/images/what-1.jpg" class="img-responsive"></div>
                            <div class="cont">
                                <div class="tit"><span>快速反映机制</span></div>
                                <div class="com">大客户定制项目，由专业的团队来服务，成立项目组，三次内部头脑风暴，提交两套以上的方案，根据双方拟定时间进度表,完成项</div>
                            </div>
                        </li>
                        <li class="trans">
                            <div class="num">04</div>
                            <div class="image"><img src="/Public/home/images/what-1.jpg" class="img-responsive"></div>
                            <div class="cont">
                                <div class="tit"><span>全方位深入支持</span></div>
                                <div class="com">大客户定制项目，由专业的团队来服务，成立项目组，三次内部头脑风暴，提交两套以上的方案，根据双方拟定时间进度表,完成项</div>
                            </div>
                        </li>
                    </ul>
                </aside>
            </div>
        </article>
    </section>
    <!--#news-->
    <section class="news clearfix">
        <article class="container-box">
            <aside class="news-list clearfix trans">

                <a class="item bok" :href="item.links" v-for="(item, index) in articleList">
                    <div class="title ellip bok trans">{{item.title}}</div>
                    <div class="com">{{item.shortcontent}}</div>
                    <div class="time">{{item.addtime}}</div>
                    <div class="line_more trans"></div>
                </a>

            </aside>
            <a href="/news/index.html" class="loadMore bok f-eng trans clearfix">LOAD MORE</a>
        </article>
    </section>
    <!--#customer-->
<section class="fr-box">
    <article class="container-box">
        <aside class="fr_list trans">
            <div class="list clearfix">
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_1.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_1_1.png" class="img-responsive change">
                    </div>

                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_2.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_2_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_3.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_3_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_4.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_4_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_5.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_5_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_6.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_6_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!-- <img src="/Public/home/images/link_7.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_7_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_8.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_8_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_9.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_9_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_10.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_10_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!-- <img src="/Public/home/images/link_11.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_11_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_12.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_12_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!-- <img src="/Public/home/images/link_13.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_13_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!--<img src="/Public/home/images/link_14.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_14_1.png" class="img-responsive change">
                    </div>
                </a>
                <a class="item" href="##">
                    <div class="bg trans">
                        <!-- <img src="/Public/home/images/link_15.jpg" class="img-responsive common">-->
                        <img src="/Public/home/images/link_15_1.png" class="img-responsive change">
                    </div>
                </a>
            </div>
        </aside>
    </article>
</section>
    <!--#integrity-->
    <section class="integrity  clearfix">
        <article class="container-box">
            <div class="content clearfix trans">
                <aside class="rate">
                    <div class="img-icon pos-ab"><img src="/Public/home/images/icon_2.png"></div>
                    <div class="circle_income">
                        <div class="pie_left"><div class="left trans"></div></div>
                        <div class="pie_right"><div class="right trans"></div></div>
                        <div class="mask">
                            <div class="percent"><span id="percent">98</span>%</div>
                            <div class="eng-txt f-eng">REPEAT BUSINESS</div>
                            <div class="china-txt">回头客户</div>
                        </div>
                    </div>
                    <div class="com f-eng text-center">
                        OF CLIENTS<br/>
                        PERCENTAGE OF CLIENTS WHO USE <span class="co-red">US AGAIN</span>
                    </div>
                </aside>

                <aside class="num-info">
                    <div class="contents clearfix">
                        <div class="item">
                            <div class="cont">
                                <div class="num co-red" id="num_1">12</div>
                                <div class="com">年视觉设计经验</div>
                                <div class="eng-com f-eng">BRAND IMPETUS OF LISTED ENTERPRISE GROUPS</div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="cont">
                                <div class="num co-red" id="num_2">1695</div>
                                <div class="com">合作客户信心选择<i class="icon pos-ab"></i></div>
                                <div class="eng-com f-eng">COOPERATIVE CUSTOMER CONFIDENCE</div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="cont">
                                <div class="num co-red"><span id="num_3">6</span>大保障</div>
                                <div class="com">项目完成后提供:设计文件 + 代码 +空间 + 域名 + 售后维护 + 优化培训</div>
                                <div class="eng-com f-eng">THE SIX SECURITY</div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </article>
    </section>
    <script language="JavaScript">
        var jwvue = new Vue({
            el: '#appRoot',
            data: {
                cateId: 139,
                articleList: [],
                status: 0,
                page: 1,
                pageSize: 6
            },
            methods: {
                getArticleList: function(){
                    if(this.status == 1){
                        return false;
                    }
                    this.status = 1;
                    $.ajax({
                        'url': '/index.php/Help/getArticleUserAjax',
                        'type': 'POST',
                        'data': {
                            'cateid': this.cateId,
                            'page': this.page,
                            'pagesize': this.pageSize
                        },
                        'success': function(res){
                            if(res.length == 0){
                                //jwvue.$data.pageMax = true;
                            }else{
                                jwvue.$data.page += 1;
                                jwvue.$data.articleList = jwvue.$data.articleList.concat(res);
                            }
                            jwvue.$data.status = 0;
                        }
                    });
                }
            },
            created: function(){
                this.getArticleList();
            }
        });
    </script>
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?01cf2aac86151ae906ea9461f02a9b31";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>


</section>
<!--#footer form-box-->
<section class="form-box">
    <article class="container-box">
        <div class="content trans">
            <h1 class="title">填写您的项目需求给我们。</h1>
            <div class="row fm-area">
                <aside class="col-md-2">
                    <input type="text" name="your_name" id="your_name" class="form-control" placeholder="称呼姓名">
                </aside>
                <aside class="col-md-2">
                    <input type="tel" name="your_telno" id="your_telno" class="form-control" placeholder="联系电话">
                </aside>
                <aside class="col-md-6">
                    <input type="text" class="form-control" name="your_content" id="your_content" placeholder="描述你的需求，如网站、微信、APP、电商、平面、影视">
                </aside>
                <aside class="col-md-2">
                    <a href="javascript:void(0)" class="sub-bt dosendmail">提交项目需求</a>
                </aside>
            </div>
            <h5 class="com">*请认真填写需求信息，我们会在24小时内与您取得联系。</h5>
        </div>
    </article>
</section>
<!--#footer-->
<footer class="footer">
    <a name="footer"></a>
    <article class="container-box">
        <div class="content trans">
            <address class="contact-box clearfix">
                <aside class="item">
                    <div class="tit">联系地址</div>
                    <div class="cont">
                        <?php echo C('SITE_WORK_AREA');?><br/><?php echo C('SITE_WORK_ADDRESS');?>
                    </div>
                </aside>
                <aside class="item">
                    <div class="tit">致电策划顾问</div>
                    <div class="cont">
                        <?php echo C('SITE_WORK_PHONE');?>
                    </div>
                </aside>
                <aside class="contact-bt">
                    <a href="javascript:void(0)" class="trans">
                        <i class="icon">&#xe613;</i>
                        <span class="pops trans">
                            <?php echo C('SITE_WORK_PHONE');?>
                        </span>
                    </a>
                    <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('SITE_WORK_QQ');?>&site=qq&menu=yes" class="trans" target="_blank">
                        <i class="icon">&#xe601;</i>
                        <span class="pops trans">点我聊天</span>
                    </a>
                    <a href="javascript:void(0)" class="trans">
                        <i class="icon">&#xe660;</i>
                        <span class="pops trans">
                            <img src="<?php echo C('SITE_WAP_IMG');?>" width="100">
                        </span>
                    </a>
                </aside>
            </address>
            <div class="ft-btm clearfix">
                <div class="copyright pull-left">©2018 九五策划 ALL RIGHTS RESERVED. 皖ICP备07001687号　</div>
                <div class="fr-link pull-right">
                    <span class="t">友情链接：</span>
                    <div class="list">
                        <ul class="cont trans">
                            <li>
                                <?php if(is_array($rsfriend)): foreach($rsfriend as $k=>$vo): ?><a href="<?php echo ($vo['links']); ?>" title="<?php echo ($vo['title']); ?>"><?php echo ($vo['title']); ?></a>
                                    <?php if((($k+1)%5) == 0): ?></li><li><?php endif; endforeach; endif; ?>
                            </li>
                        </ul>
                    </div>
                    <a href="javascript:void(0)" class="toggle-link"><i class="icon">&#xe6bd;</i></a>
                </div>
            </div>
        </div>
    </article>
</footer>
<!--#dropdown-->
<a class="dropdown trans" href="javascript:void(0)">
    <i class="icon trans">&#xe6cb;</i>
</a>
<!--#fix-nav mobile-->
<section class="fix-nav trans">
    <article class="content">
        <ul>
            <li class="logo">
                <img src="/Public/home/images/logo-text.png" class="img-responsive">
            </li>
            <li class="act"><a href="/index.html" class="trans">首页</a></li>
            <li><a href="/case/index.html" class="trans">客户案例</a></li>
            <li><a href="/serv/h5/index.html" class="trans">响应式网站</a></li>
            <li><a href="/serv/applets/index.html" class="trans">微信小程序开发</a></li>
            <li><a href="/serv/app/index.html" class="trans">移动端设计</a></li>
            <li><a href="/serv/vi/index.html" class="trans">视觉平面</a></li>
            <li><a href="/serv/video/index.html" class="trans">影视制作</a></li>
            <li><a href="/serv/sale/index.html" class="trans">网络营销</a></li>
            <li><a href="/about/index.html" class="trans">公司</a></li>
            <li><a href="/news/index.html" class="trans">知识</a></li>
            <li><a href="/contact/index.html" class="trans">联系</a></li>
            <li class="contact">
                <a href="tel:0551-65397195" class="trans"><i class="icon">&#xe613;</i></a>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('SITE_WORK_QQ');?>&site=qq&menu=yes" class="trans" target="_blank"><i class="icon">&#xe601;</i></a>
                <a href="javascript:void(0);" class="trans"><i class="icon">&#xe660;</i></a>
            </li>
        </ul>
        <a class="bok close_nav" href="javascript:void(0)">
            <i class="icon">&#xe623;</i>
        </a>
        <a class="bok mobile_close_nav" href="javascript:void(0)">
            <i class="icon">&#xe623;</i>
        </a>
    </article>
</section>
<section class="pop-box trans"></section>
<!--#mobile header-->
<section class="mobile-header">
    <article class="container-box clearfix">
        <aside class="logo"><img src="/Public/home/images/logo-text_1.png" class="img-responsive"></aside>
        <a href="javascript:void(0)" class="open_munu bok">
            <i class="icon">&#xe617;</i>
        </a>
    </article>
</section>
<a class="fix-menu" href="javascript:void(0)">
    <i class="icon">&#xe617;</i>
</a>
<!--servicePopup begin-->
<div class="servicePopup">
    <div class="cont">
        <div class="title">免费咨询服务顾问<br>
            获得专属《策划方案》及报价详情</div>
        <div class="keywords">
            <?php echo C('SITE_POP_KEYS');?>
        </div>
        <div class="telphone"><?php echo C('SITE_WORK_PHONE');?></div>
        <div class="btns clearfix">
            <a target="_blank" class="btn serviceBtn" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('SITE_WORK_QQ');?>&site=qq&menu=yes">设计咨询</a>
            <a target="_blank" class="btn serviceBtn" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('SITE_WORK_QQ_DEV');?>&site=qq&menu=yes">开发咨询</a>
            <div class="btn closeBtn" onClick="app.closeServicePopup();" >稍后再说</div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script language="JavaScript">
    $(function(){
        $('.fix-nav').niceScroll({
            railoffset: {
                'left': '40%'
            }
        });
    });
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?01cf2aac86151ae906ea9461f02a9b31";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>