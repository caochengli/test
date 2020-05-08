<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo C('SYS_TITLE');?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/Public/admin/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/Public/admin/dist/css/font/css/font-awesome.min.css">
  <!-- Theme style -->
  


  <link rel="stylesheet" href="/Public/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/Public/admin/dist/css/skins/_all-skins.min.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo C('SYS_SHORT_TITLE_EN');?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo C('SYS_SHORT_TITLE');?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="/admin.php" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo C('SYS_LOGO');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ($userinfo['username']); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo C('SYS_LOGO');?>" class="img-circle" alt="User Image">
                <p>欢迎您 <?php echo ($userinfo['username']); ?><small>当前时间是：<?php echo date('Y-m-d H:i:s');?></small></p>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
            <li><a href="javascript:void(0);" data-toggle="control-sidebar" id="clearCache">清空缓存</a></li>
            <li class="active"><a href="javascript:void(0);" data-toggle="control-sidebar" id="creatIndexHtml">生成首页</a></li>
            <li><a href="javascript:void(0);" data-toggle="control-sidebar" id="creatSiteMap">SiteMap</a></li>
          <li>
            <a href="javascript:void(0);" data-toggle="control-sidebar" class="signout">退出 <i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo C('SYS_LOGO');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ($userinfo['username']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> 当前在线</a>          
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li>
           <a href="/admin.php">
              <i class="fa fa-home"></i> <span>主页</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
           </a>
           <ul class="treeview-menu">
              <li><a href="/admin.php"><i class="fa fa-angle-right"></i> 系统主页</a></li>
              <li><a href="/index.php" target="_blank"><i class="fa fa-angle-right"></i> 站点主页</a></li>
           </ul>
        </li>
        <?php if(is_array($navbar)): $i = 0; $__LIST__ = $navbar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rsnav): $mod = ($i % 2 );++$i;?><li class="<?php if($rsnav['role'] == CONTROLLER_NAME): ?>active<?php elseif(($rsnav['role'] == 'Content' AND CONTROLLER_NAME == 'Package')): ?>active<?php endif; ?> <?php if(is_array($rs['submenu'])): ?>treeview<?php endif; ?>">
          <a href="<?php echo ($rsnav['url']); ?>">
            <i class="fa <?php echo ($rsnav['icon']); ?>"></i> <span><?php echo ($rsnav['name']); ?></span>
            <?php if(is_array($rsnav['submenu']) OR $rsnav['isc'] == 1): ?><span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <?php else: ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span><?php endif; ?>
          </a>
          <?php if($rsnav['isc'] == 1): $category = setcate($focusid); ?>
                  <ul class="treeview-menu">
                     <?php if(is_array($category)): foreach($category as $key=>$cates): ?><li class="<?php echo ($cates['cls']); ?>">
                           <a href="<?php echo ($cates['url']); ?>">
                              <i class="fa fa-angle-right"></i> <?php echo ($cates['name']); ?>                   
                           </a>
                           <?php if(is_array($cates[submenu])): ?><ul class="treeview-menu">
                                 <?php if(is_array($cates[submenu])): foreach($cates[submenu] as $key=>$chd): ?><li class="<?php echo ($chd['cls']); ?>">
                                       <a href="<?php echo ($chd['url']); ?>"><i class="fa fa-angle-right"></i> <?php echo ($chd['name']); ?></a>
                                       <?php if(is_array($chd[submenu])): ?><ul class="treeview-menu">
                                             <?php if(is_array($chd[submenu])): foreach($chd[submenu] as $key=>$chdrs): ?><li class="<?php echo ($chdrs['cls']); ?>">
                                                   <a href="<?php echo ($chdrs['url']); ?>"><i class="fa fa-angle-right"></i> <?php echo ($chdrs['name']); ?></a>
                                                   <?php if(is_array($chdrs[submenu])): ?><ul class="treeview-menu">
                                                         <?php if(is_array($chdrs[submenu])): foreach($chdrs[submenu] as $key=>$noders): ?><li <?php if($noders[id] == $focusid): ?>class="active"<?php endif; ?>>
                                                            <a href="<?php echo ($noders['url']); ?>"><i class="fa fa-angle-right"></i> <?php echo ($noders['name']); ?></a>
                                                         </li><?php endforeach; endif; ?>
                                                      </ul><?php endif; ?>
                                                </li><?php endforeach; endif; ?>
                                          </ul><?php endif; ?>
                                    </li><?php endforeach; endif; ?>
                              </ul><?php endif; ?>
                        </li><?php endforeach; endif; ?>
                  </ul><?php endif; ?>
          <?php if(is_array($rsnav['submenu'])): ?><ul class="treeview-menu">
                <?php if(is_array($rsnav['submenu'])): foreach($rsnav['submenu'] as $key=>$vo): ?><li class="<?php if($vo['role'] == CONTROLLER_NAME.'/'.ACTION_NAME): ?>active<?php endif; ?>"><a href="<?php echo ($vo['url']); ?>"><i class="fa fa-angle-right"></i> <?php echo ($vo['name']); ?></a>
                    <?php if(is_array($vo['submenu'])): ?><ul class="treeview-menu">
                           <?php if(is_array($vo['submenu'])): foreach($vo['submenu'] as $key=>$im): ?><li><a href="<?php echo ($im['url']); ?>"><i class="fa fa-angle-right"></i> <?php echo ($im['name']); ?></a></li><?php endforeach; endif; ?>
                        </ul><?php endif; ?>
                </li><?php endforeach; endif; ?>
              </ul><?php endif; ?>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- Main content -->
    <section class="content">
       
    <div class="row">
        <div class="col-xs-12">
            <form name="import_form" id="import_form" class="form-horizontal" method="post" action="">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#default" data-toggle="tab">基本</a></li>
                        <li><a href="#other" data-toggle="tab">其它</a></li>
                    </ul>
                    <div class="tab-content form-horizontal">

                        <div class="active tab-pane" id="default">
                            <div class="form-group">
                                <label for="SITE_TITLE" class="col-sm-2 control-label">站点名称：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_TITLE" value="<?php echo C('SITE_TITLE');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_URL" class="col-sm-2 control-label">网址：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_URL" value="<?php echo C('SITE_URL');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_KEYWORDS" class="col-sm-2 control-label">关键词：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_KEYWORDS"><?php echo C('SITE_KEYWORDS');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_DESC" class="col-sm-2 control-label">描述：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_DESC"><?php echo C('SITE_DESC');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_META_COPYRIGHT" class="col-sm-2 control-label">meta copayright：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_META_COPYRIGHT"><?php echo C('SITE_META_COPYRIGHT');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_POP_KEYS" class="col-sm-2 control-label">业务概述：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_POP_KEYS"><?php echo C('SITE_POP_KEYS');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_LOGO" class="col-sm-2 col-xs-12 control-label">Logo：</label>
                                <div class="col-sm-3 col-xs-8">
                                    <p><input type="text" class="form-control" name="SITE_LOGO" id="SITE_LOGO"
                                              value="<?php echo C('SITE_LOGO');?>"/></p>
                                    <p>
                                        <button type="button" class="btn btn-danger upload_button" id="file_upload_01"
                                                data-input="SITE_LOGO" data-img="SITE_LOGO_PIC">上传
                                        </button>
                                        <i class="pull-right" id="loading" style="display:none;"><img
                                                src="/Public/admin/dist/img/loading.gif"/></i></p>
                                </div>
                                <div class="col-sm-1 col-xs-4">
                                    <img src="<?php echo C('SITE_LOGO');?>" id="SITE_LOGO_PIC" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_PHONE" class="col-sm-2 control-label">固定电话：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_WORK_PHONE" value="<?php echo C('SITE_WORK_PHONE');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_AREA" class="col-sm-2 control-label">省市区：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_WORK_AREA" value="<?php echo C('SITE_WORK_AREA');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_ADDRESS" class="col-sm-2 control-label">地址：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_WORK_ADDRESS"><?php echo C('SITE_WORK_ADDRESS');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_EMAIL" class="col-sm-2 control-label">邮箱：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_WORK_EMAIL" value="<?php echo C('SITE_WORK_EMAIL');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_QQ" class="col-sm-2 control-label">QQ：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_WORK_QQ" value="<?php echo C('SITE_WORK_QQ');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_QQ_DEV" class="col-sm-2 control-label">QQ(开发咨询)：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_WORK_QQ_DEV" value="<?php echo C('SITE_WORK_QQ_DEV');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WORK_TOUCHMAN" class="col-sm-2 control-label">联系人：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input class="form-control" name="SITE_WORK_TOUCHMAN" value="<?php echo C('SITE_WORK_TOUCHMAN');?>">
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WX_IMG" class="col-sm-2 col-xs-12 control-label">个人微信：</label>
                                <div class="col-sm-3 col-xs-8">
                                    <p><input type="text" class="form-control" name="SITE_WX_IMG" id="SITE_WX_IMG"
                                              value="<?php echo C('SITE_WX_IMG');?>"/></p>
                                    <p>
                                        <button type="button" class="btn btn-danger upload_button" id="file_upload_02"
                                                data-input="SITE_WX_IMG" data-img="SITE_WX_IMG_PIC">上传
                                        </button>
                                        <i class="pull-right" id="loading" style="display:none;"><img
                                                src="/Public/admin/dist/img/loading.gif"/></i></p>
                                    <p>
                                        <small class="text-muted">建议尺寸：200/200(px)</small>
                                    </p>
                                </div>
                                <div class="col-sm-1 col-xs-4">
                                    <img src="<?php echo C('SITE_WX_IMG');?>" id="SITE_WX_IMG_PIC" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_WAP_IMG" class="col-sm-2 col-xs-12 control-label">官方微信：</label>
                                <div class="col-sm-3 col-xs-8">
                                    <p><input type="text" class="form-control" name="SITE_WAP_IMG" id="SITE_WAP_IMG"
                                              value="<?php echo C('SITE_WAP_IMG');?>"/></p>
                                    <p>
                                        <button type="button" class="btn btn-danger upload_button" id="file_upload_03"
                                                data-input="SITE_WAP_IMG" data-img="SITE_WAP_IMG_PIC">上传
                                        </button>
                                        <i class="pull-right" id="loading" style="display:none;"><img
                                                src="/Public/admin/dist/img/loading.gif"/></i></p>
                                    <p>
                                        <small class="text-muted">建议尺寸：200/200(px)</small>
                                    </p>
                                </div>
                                <div class="col-sm-1 col-xs-4">
                                    <img src="<?php echo C('SITE_WAP_IMG');?>" id="SITE_WAP_IMG_PIC" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_COPYRIGHT" class="col-sm-2 control-label">版权：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_COPYRIGHT"><?php echo C('SITE_COPYRIGHT');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_PRE_KEYWORDS" class="col-sm-2 control-label">顶部关键词：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <textarea class="form-control" name="SITE_PRE_KEYWORDS"><?php echo C('SITE_PRE_KEYWORDS');?></textarea>
                                </div>
                                <div class="pad-t-sm col-sm-6 col-xs-12"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="other">
                            <div class="form-group">
                                <label for="SITE_NOBANNER" class="col-sm-2 col-xs-12 control-label">通栏图片：</label>
                                <div class="col-sm-3 col-xs-8">
                                    <p><input type="text" class="form-control" name="SITE_NOBANNER" id="SITE_NOBANNER" value="<?php echo C('SITE_NOBANNER');?>"/></p>
                                    <p>
                                        <button type="button" class="btn btn-danger upload_button" id="file_upload_09" data-input="SITE_NOBANNER" data-img="SITE_NOBANNER_PIC">上传</button>
                                        <i class="pull-right" id="loading" style="display:none;"><img src="/Public/admin/dist/img/loading.gif"/></i>
                                    </p>
                                </div>
                                <div class="col-sm-1 col-xs-4">
                                    <img src="<?php echo C('SITE_NOBANNER');?>" id="SITE_NOBANNER_PIC" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_BREADCUT" class="col-sm-2 control-label">面包屑分割：</label>
                                <div class="col-sm-1 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_BREADCUT" value="<?php echo C('SITE_BREADCUT');?>">
                                </div>
                                <div class="col-sm-9 col-xs-12 lh-set small text-muted">首页 <?php echo C('SITE_BREADCUT');?> 关于我们</div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_SHARE_TITLE" class="col-sm-2 control-label">分享标题：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_SHARE_TITLE" value="<?php echo C('SITE_SHARE_TITLE');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_SHARE_URL" class="col-sm-2 control-label">分享网址：</label>
                                <div class="col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="SITE_SHARE_URL" value="<?php echo C('SITE_SHARE_URL');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SITE_SHARE_PIC" class="col-sm-2 col-xs-12 control-label">分享图片：</label>
                                <div class="col-sm-3 col-xs-8">
                                    <p><input type="text" class="form-control" name="SITE_SHARE_PIC" id="SITE_SHARE_PIC" value="<?php echo C('SITE_SHARE_PIC');?>"/></p>
                                    <p>
                                        <button type="button" class="btn btn-danger upload_button" id="file_upload_07" data-input="SITE_SHARE_PIC" data-img="SITE_SHARE_PIC_PIC">上传</button>
                                        <i class="pull-right" id="loading" style="display:none;"><img src="/Public/admin/dist/img/loading.gif"/></i>
                                    </p>
                                </div>
                                <div class="col-sm-1 col-xs-4">
                                    <img src="<?php echo C('SITE_SHARE_PIC');?>" id="SITE_SHARE_PIC_PIC" class="img-responsive"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clearfix"><button type="button" class="btn btn-info btn-sub-fm">确认修改</button></div>
            </form>
        </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer small">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.5
    </div>
    Copyright &copy; 2018-2020 <a href="<?php echo C('SYS_COPYRIGHT');?>" target="_blank"><?php echo C('SYS_COPYRIGHT');?></a>. All rights reserved.
  </footer>
  <!-- Control Sidebar -->
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="/Public/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/Public/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="/Public/admin/dist/js/ajaxupload.3.5.js"></script>
<script src="/Public/admin/dist/js/common.js"></script>
<script language="javascript" src="/Public/admin/tips/jquery.tips.js"></script>
<script language="javascript">
$(function(){
   $('a.signout').click(function(){
      $.ajax({
		url : "<?php echo U('/Login/logout');?>",
		type : "POST",
		success : function(d){		   
		   $.fn.tips({type:d.type,content:d.content,url:d.url});
		}
	  });
   });
    $('#clearCache').click(function(){
        var the = $(this);
        $.ajax({
            url : "/admin.php/Common/clearCache.html",
            type : "GET",
            beforeSend: function(){
                the.html('<img src="/Public/admin/dist/img/loading.gif" width="18">');
            },success: function(d){
                if(d){
                    $.fn.tips({'type':'ok','content':'缓存清空成功','url':''});
                }else{
                    $.fn.tips({'type':'error','content':'缓存清空失败','url':''});
                }
                the.html('清空缓存');
            }
        });
    });
    $('#creatIndexHtml').click(function(){
        $(this).html('<img src="/Public/admin/dist/img/loading.gif" width="16">');
        $.get('/admin.php/MakeHtml/setIndex',function(res){
            if(parseInt(res.bytes)>0){
                $.fn.tips({'type':'ok','content':'生成首页成功'});
            }else{
                $.fn.tips({'type':'error','content':'生成首页失败'});
            }
            $('#creatIndexHtml').html('生成首页');
        });
    });
    $('#creatSiteMap').click(function(){
        var the = $(this);
        $.ajax({
            url : "/admin.php/Sitemap/index.html",
            type : "GET",
            beforeSend: function(){
                the.html('<img src="/Public/admin/dist/img/loading.gif" width="18">');
            },success: function(res){
                if(res.type === 'ok'){
                    $.fn.tips({'type':'ok','content':'网站地图生成成功','url':''});
                }else{
                    $.fn.tips({'type':'error','content':'网站地图生成失败','url':''});
                }
                the.html('生成网站地图');
            }
        });
    });
});
</script>

    <script language="javascript">
        $(function () {
            $('.btn-sub-fm').click(function () {

                var data = $("#import_form").serialize();
                //alert(data);
                $.ajax({
                    url: "<?php echo U('/Role/updateconfig');?>",
                    type: "POST",
                    data: data,
                    success: function (d) {
                        var d = $.parseJSON(d);
                        $.fn.tips({type: d.type, content: d.content, url: d.url});
                    }
                });

            });
        });
    </script>

<script src="/Public/admin/dist/js/app.min.js"></script>
</body>
</html>