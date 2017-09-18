<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:71:"D:\phpStudy\WWW\taishu\public/../application/admin\view\user\index.html";i:1471185368;s:67:"D:\phpStudy\WWW\taishu\public/../application/admin\view\layout.html";i:1471187102;s:72:"D:\phpStudy\WWW\taishu\public/../application/admin\view\public\head.html";i:1470056120;s:74:"D:\phpStudy\WWW\taishu\public/../application/admin\view\public\header.html";i:1471187268;s:75:"D:\phpStudy\WWW\taishu\public/../application/admin\view\public\sidebar.html";i:1471187533;s:74:"D:\phpStudy\WWW\taishu\public/../application/admin\view\public\script.html";i:1470057792;}*/ ?>
<!doctype html>
<html class="no-js fixed-layout">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Amaze UI Admin index Examples</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="/static/assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="/static/assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="/static/assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head> 
<body>

<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->


<header class="am-topbar am-topbar-inverse admin-header">
  <div class="am-topbar-brand">
    <strong>Amaze UI</strong> <small>后台管理模板</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> 管理员 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
          <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
          <li><a href="<?php echo url('/admin/user/logout'); ?>"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header> 
<div class="am-cf admin-main">
  <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list">
     <?php if(is_array($sidebar) || $sidebar instanceof \think\Collection): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;if(!isset($value['sub'])): ?>
        <li><a href="<?php echo $value['url']; ?>"><span class="am-icon-bars"></span><?php echo $value['title']; ?></a></li>
        <?php else: ?>
        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-<?php echo $value['id']; ?>'}"><span class="am-icon-bars"></span> <?php echo $value['title']; ?> <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub <?php if(session('menuPid1')==$value['id']): ?>am-in<?php endif; ?> " id="collapse-<?php echo $value['id']; ?>">
            <?php if(is_array($value['sub']) || $value['sub'] instanceof \think\Collection): $i = 0; $__LIST__ = $value['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>  
            
            <li id='sidebar'><a href="<?php echo url($vo['url']); if($value['id']==session('menuPid2')): ?>?fid=<?php echo $vo['fid']; endif; ?>"><span class="am-icon-puzzle-piece"></span> <?php echo $vo['title']; ?></a></li>
            
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li>        
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ul>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p>时光静好，与君语；细水流年，与君同。—— Amaze UI</p>
        </div>
      </div>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div>
    </div>
  </div> 
  <!-- sidebar end -->
  <!-- content start -->
  <div class="admin-content">
    <div class="admin-content-body">
	  
	  <div class="am-cf am-padding">
         <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">后台管理</strong> / <small>用户列表</small></div>
      </div>

      
<div class="am-container">
	<div class="am-panel am-panel-default am-table">
	  <div class="am-panel-hd">
	    <h3 class="am-panel-title">用户列表</h3>
	  </div>

	  <table class="am-table am-table-bordered am-table-striped am-table-hover am-table-compact">
		    <thead>
		        <tr>
		            <th>用户名</th>
		            <th>昵称</th>
		            <th>创建时间</th>
		            <th>操作</th>
		        </tr>
		    </thead>
		    <tbody>
		       <?php if(is_array($data) || $data instanceof \think\Collection): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?>
		        <tr class="">
		            <td><?php echo $value['user']; ?></td>
		            <td><?php echo $value['name']; ?></td>
		            <td><?php echo $value['create_time']; ?></td>
		            <td>
                      <a href="<?php echo url('/admin/user/edit'); ?>?id=<?php echo $value['id']; ?>">编辑</a> | 
                      <a href="<?php echo url('/admin/user/del'); ?>?id=<?php echo $value['id']; ?>">删除</a>
		           </td>		            
		        </tr>
		       <?php endforeach; endif; else: echo "" ;endif; ?>      
		    </tbody>
	  </table>
	</div>
</div>

    </div>
	
	<footer class="admin-content-footer">
	  <hr>
	  <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
	</footer>
  </div>
<!-- content end -->
</div>
<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/static/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/static/assets/js/amazeui.min.js"></script>
<script src="/static/assets/js/app.js"></script> 

<script>
      
</script>

</body>
</html>
