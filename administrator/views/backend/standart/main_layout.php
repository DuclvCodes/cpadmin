<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="vi" />
        
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    	<meta content="" name="description" />
    	<meta content="" name="author" />
        <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <title><?=DOMAIN_NAME ?> <?php echo isset($title_page) ? ' - '.$title_page : ''; ?></title>
        
        <link href="<?php echo BASE_ASSET ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>css/style-metro.css" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>css/style.css?v=<?=VERSION?>" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>css/style-responsive.css" rel="stylesheet" type="text/css"/>
    	<link href="<?php echo BASE_ASSET ?>css/themes/light.css" rel="stylesheet" type="text/css" id="style_color"/>
    	<link href="<?php echo BASE_ASSET ?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/select2/select2_metro.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/chosen-bootstrap/chosen/chosen.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/data-tables/DT_bootstrap.css" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-timepicker/compiled/timepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-modal/css/bootstrap-modal.css"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-colorpicker/css/colorpicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/gritter/css/jquery.gritter.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/jquery-tags-input/jquery.tagsinput.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/clockface/css/clockface.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/mCustomScrollbar/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_ASSET ?>plugins/jquery-multi-select/css/multi-select-metro.css" />
        <link rel="stylesheet" type="text/css" href="/asset/plugins/toastr/build/toastr.css" />
        <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_ASSET ?>plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_ASSET ?>scripts/jquery.ui.datepicker-vn.js"></script>
        <script type="text/javascript" src="/asset/tinymce/tinymce.min.js"></script>
        <script src="/asset/plugins/toastr/toastr.js" type="text/javascript"></script>
    </head>
    
    <body class="page-header-fixed <?=(isset($_COOKIE['SMALL_MENU']) && $_COOKIE['SMALL_MENU']=='ON')?'page-sidebar-closed':''?>">
    
        <div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<a class="brand" href="<?='http://'.DOMAIN?>" target="_blank"><?=(DEVICE=='desktop')?DOMAIN_NAME:DOMAIN_SHORTNAME?></a>
			<!-- END LOGO -->
            <div class="navbar hor-menu hidden-phone hidden-tablet">
				<div class="navbar-inner">
					<ul class="nav">
                        <?php $mod = current_method()['mod']; ?>
                        <?php $act = current_method()['act']; ?>
                        <?php if ($clsUser->permission('chart')) {
    ?><li <?=($mod=='chart')?'class="active"':''?>><a href="/chart"><i class="icon-bar-chart"></i> Thống kê<span class="selected"></span></a></li><?php
} ?>
                        <?php if ($clsUser->permission('report')) {
        ?><li <?=($mod=='report')?'class="active"':''?>><a href="/report"><i class="icon-list-alt"></i> Báo cáo<span class="selected"></span></a></li><?php
    } ?>
                        <li <?=($mod=='chart'&&$act=='news')?'class="active"':''?> class="hidden-tablet"><a href="/chart/news"><i class="icon-cloud"></i> Bài viết<span class="selected"></span></a></li>
                        <?php if ($clsUser->permission('home')) {
        ?>
                            <li <?=($mod=='history')?'class="active"':''?>><a href="/history"><i class="icon-time"></i> Lịch sử<span class="selected"></span></a></li>
                            <li <?=($mod=='video')?'class="active"':''?>><a href="/video"><i class="icon-time"></i> Video<span class="selected"></span></a></li>
                            <!--<li <?=($mod=='files')?'class="active"':''?>><a href="/files"><i class="icon-time"></i> Files<span class="selected"></span></a></li>-->
                        <?php
    } ?>
                            </ul>
				</div>
			</div>
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
			<img src="<?php echo BASE_ASSET ?>img/menu-toggler.png" alt="" />
			</a>          
			<!-- END RESPONSIVE MENU TOGGLER -->            
			<!-- BEGIN TOP NAVIGATION MENU -->              
			<ul class="nav pull-right">
                
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user">
					<a id="tkp_my_profile" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    					<img src="<?php echo $clsUser->getImage($me['user_id'], 29, 29, 'image', '/files/user/noavatar.jpg') ?>?v=1" width="29" height="29" />
    					<span class="username" data-id="<?=$me['user_id']?>"><?php echo $me['fullname'] ?></span>
    					<i class="icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/user/profile"><i class="icon-user"></i> Hồ sơ cá nhân</a></li>
						<?php if ($me['group_id']==5) {
        ?>
                            <li class="divider"></li>
                            <li><a href="/user"><i class="icon-group"></i> Quản lý nhân sự</a></li>
                            <li><a href="/setting"><i class="icon-cogs"></i> Cài đặt</a></li>
                        <?php
    } ?>
                        <?php if ($clsUser->permission('ads')) {
        ?><li><a href="/ads"><i class="icon-bullhorn"></i> Quản lý quảng cáo</a></li><?php
    } ?>
                        <?php if ($clsUser->permission('ssh')) {
        ?><li><a href="/ssh"><i class="icon-css3"></i> Command Line</a></li><?php
    } ?>
                        <li class="divider"></li>
						<li><a href="javascript:;" id="trigger_fullscreen"><i class="icon-move"></i> Toàn màn hình</a></li>
						<li><a href="/user/lock_screen"><i class="icon-lock"></i> Khóa màn hình</a></li>
						<li><a href="/user/logout"><i class="icon-off"></i> Thoát</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU --> 
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
        <?= $template['partials']['content']; ?>
        <div class="footer">
	<div class="footer-inner">
		Powered by <a href="https://www.phapluatplus.vn" title=""><b style="color: #c32c2c;">Pháp Luật Plus </b></a> © 2016-<?php echo date('Y') ?>
        </div>
	<div class="footer-tools">
		<span class="go-top">
		<i class="icon-angle-up"></i>
		</span>
	</div>
        </div>

<script type="text/javascript">
$(document).ready(function(){
    $('#form_default').submit(function(){
        var is_error = false;
        $(this).find('.required').each(function(){
            var val = $(this).val();
            if(!val || val=='' || val=='0') {
                $(this).parents('.control-group').addClass('error');
                is_error = true;
            }
        });
        if(is_error==true) {
            $(this).find('.error:eq(0) .required').focus();
            alert('Vui lòng nhập đủ những thông tin bắt buộc');
            return false;
        }
    });
    $('#form_default .required').each(function(){
        var e = $(this).parents('.control-group');
        $(this).keyup(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
        $(this).change(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    window.addEventListener('offline',function(evt) { 
        $('#alert_disconnect_network').show(); 
    });
    window.addEventListener('online',function(evt) { 
        $('#alert_disconnect_network').hide(); 
    });
    $('#alert_system button.close').click(function(){
        $('#alert_system').fadeOut();
    });
    toastr.options = {
        "positionClass": "toast-top-right",
      }

      //flash message
      var f_message = "<?= $this->session->flashdata('f_message'); ?>";
      var f_type = "<?= $this->session->flashdata('f_type'); ?>";
      if (f_message.length > 0) {
        toastr[f_type](f_message);
      }

});
</script>

<div id="tkp_chat_extention"></div>
<div id="alert_disconnect_network" class="alert alert-block alert-error fade in" style="position: fixed;left: 50%;top: 52px;width: 300px;margin-left: -150px; display: none;">
    <button type="button" class="close" data-dismiss="alert"></button>
    <h1 class="alert-heading">Oops! <span style="font-size: 24px;">Mất kết nối mạng</span></h1>
</div>
<div class="alert" id="alert_system" style="display: none;"><button class="close"></button><div></div></div>
<div id="progress" class="done"><dt></dt><dd></dd></div>
    
    
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	
	<script src="<?php echo BASE_ASSET ?>/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<!--[if lt IE 9]>
	<script src="<?php echo BASE_ASSET ?>/plugins/excanvas.min.js"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/data-tables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/data-tables/DT_bootstrap.js"></script>
    
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    
    <!--<script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="<?php echo BASE_ASSET ?>/scripts/form-validation.js"></script>-->
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-modal/js/bootstrap-modal.js" ></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" ></script>
    <script src="<?php echo BASE_ASSET ?>/scripts/ui-modals.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/gritter/js/jquery.gritter.js" ></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/jquery-tags-input/jquery.tagsinput.min.js" ></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/clockface/js/clockface.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/mCustomScrollbar/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    
    <script src="<?php echo BASE_ASSET ?>scripts/field_path.js"></script>
    
	<script src="<?php echo BASE_ASSET ?>scripts/app.js"></script>
    <script src="<?php echo BASE_ASSET ?>scripts/alert_box.js"></script>
    <script src="<?php echo BASE_ASSET ?>js/script.js"></script>
    
    <!--<script src="<?=PCMS_URL?>:8000/socket.io/socket.io.js"></script>
    <script type="text/javascript">var socket=null; if(typeof io == 'object') socket = io.connect('<?=PCMS_URL?>:8000'); var domain = 'cms.<?=DOMAIN?>'; var chat_key = '<?=MEMCACHE_NAME?>';</script>
    <script type="text/javascript" src="<?php echo BASE_ASSET ?>/scripts/chats.js"></script>-->
    
</body>
    
    
</html>