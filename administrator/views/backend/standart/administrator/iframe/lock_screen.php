<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>Tekplus Admin Control Panel | Locked Profile</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="<?php echo BASE_ASSET ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo BASE_ASSET ?>/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="<?php echo BASE_ASSET ?>/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="<?php echo BASE_ASSET ?>/css/pages/lock.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/favicon/favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
    
    <div class="page-lock">
		<div class="page-logo">
			<a class="brand" href="/">
                            <img src="/asset/img/logo.png<?php echo '?v='.VERSION ?>" alt="" style="width: 210px" />
			</a>
		</div>
        <?php if (isset($msg)) {
    echo $msg;
} ?>
		<div class="page-body">
			<img class="page-lock-img" src="<?php echo $clsUser->getImage($oneUser['user_id'], 200, 200, 'image', '/files/User/noavatar.jpg') ?>" alt="" />
			<div class="page-lock-info">
				<h1><?php echo $oneUser['fullname'] ?></h1>
				<span><?php echo $oneUser['email'] ?></span>
				<span><em style="color: #FFF;">Tài khoản của bạn đang tạm thời đăng xuất, hãy nhập mật khẩu để tiếp tục</em></span>
				<form class="form-search" action="" method="post">
					<div class="input-append">
						<input name="user_pass" type="password" class="m-wrap" placeholder="Mật khẩu" />
						<button type="submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i></button>
					</div>
					<div class="relogin">
						<a href="/iframe/login?u=<?php echo rawurlencode($_GET['u']) ?>">Không phải <?php echo $oneUser['fullname'] ?> ?</a>
					</div>
                    <input name="user_name" type="hidden" value="<?php echo $oneUser['username'] ?>" />
				</form>
			</div>
		</div>
		<div class="page-footer" style="color: #eee;">
			<?php echo date('Y') ?> &copy; <a href="#" style="color: #EEE" target="_blank"><?=DOMAIN_NAME?></a> - Admin Dashboard Control Panel.
		</div>
	</div>

    
    
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   <script src="<?php echo BASE_ASSET ?>/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
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
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo BASE_ASSET ?>/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_ASSET ?>/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo BASE_ASSET ?>/scripts/app.js" type="text/javascript"></script>      
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  $.backstretch([
    	        "<?php echo BASE_ASSET ?>img/bg/"+Math.floor((Math.random()*20)+1)+".png",
    	        "<?php echo BASE_ASSET ?>img/bg/"+Math.floor((Math.random()*20)+1)+".png",
                "<?php echo BASE_ASSET ?>img/bg/"+Math.floor((Math.random()*20)+1)+".png",
                "<?php echo BASE_ASSET ?>img/bg/"+Math.floor((Math.random()*20)+1)+".png",
    	        "<?php echo BASE_ASSET ?>img/bg/"+Math.floor((Math.random()*20)+1)+".png"
    	        ], {
    	          fade: 1000,
    	          duration: 8000
    	    });
            
            /*var address = document.location.href;
            var n = address.indexOf(":88");
            if(n==-1) {
                address = address.replace(".vn", ".vn:88");
                window.location = address;
            }*/
            
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>