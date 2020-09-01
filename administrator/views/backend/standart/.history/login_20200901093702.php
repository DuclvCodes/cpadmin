<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
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
	<meta name="msapplication-TileImage" content="/favicon/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<title>Admin Control Panel | Login Form</title>
	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
      });
    </script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!--begin::Global Theme Styles -->
	<link href="<?=BASE_ASSETV2 ?>vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?=BASE_ASSETV2 ?>demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?=BASE_ASSET ?>css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="/asset/plugins/toastr/build/toastr.css" />
	<link rel="shortcut icon" href="/favicon/favicon.ico" />
    <script src='https://www.google.com/recaptcha/api.js?hl=vi'></script>
</head>
<!-- END HEAD -->

<!-- begin::Body -->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
	<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
		<!-- begin:: Page -->
			<div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(<?=BASE_ASSETV2 ?>app/media/img//bg/bg-2.jpg);">
					<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
						<div class="m-login__container">
							<div class="m-login__logo">
								<a href="#">
									<img src="/asset/img/logo.png<?php echo '?v='.VERSION ?>" width="247px">
								</a>
							</div>
							<div class="m-login__signin">
								<div class="m-login__head">
									<h3 class="m-login__title">Đăng nhập hệ thống CMS</h3>
								</div>
								<form class="m-login__form m-form" action="" method="post" autocomplete="off">
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" autocomplete="off" placeholder="Tên đăng nhập" name="user_name" value="" tabindex="1"/>
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="password" autocomplete="off" placeholder="Mật khẩu" name="user_pass" tabindex="2" />
									</div>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
									<div class="row m-login__form-sub">
										<div class="col m--align-left m-login__form-left">
											<label class="m-checkbox  m-checkbox--light">
												<input type="checkbox" name="remember"> Remember me
												<span></span>
											</label>
										</div>
									</div>
									<div class="m-login__form-action">
										<button id="" type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign In</button>
									</div>
								</form>
							</div>
							
							<div class="m-login__forget-password">
								<div class="m-login__head">
									<h3 class="m-login__title">Quên mật khẩu ?</h3>
									<div class="m-login__desc">Nhập thông tin của bạn để chúng tôi khởi tạo lại:</div>
								</div>
								<form class="m-login__form m-form" action="">
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
									</div>
									<div class="m-login__form-action">
										<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Gửi</button>&nbsp;&nbsp;
										<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Hủy</button>
									</div>
								</form>
							</div>
							<div class="m-login__account">
								<span class="m-login__account-msg">
									Quên mật khẩu ?
								</span>&nbsp;&nbsp;
								<p class="m-link m-link--light m-login__account-link">Liên hệ bộ phận kĩ thuật hoặc thư ký tòa soạn để cấp lại mật khẩu<a href="javascript:;"  id="m-login__forget-password" class=""></a>.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin::Global Theme Bundle -->
		<script src="<?=BASE_ASSETV2 ?>vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?=BASE_ASSETV2 ?>demo/default/base/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		<script src="<?=BASE_ASSETV2 ?>snippets/custom/pages/user/login.js" type="text/javascript"></script>
		<script src="/asset/plugins/toastr/toastr.js" type="text/javascript"></script>
		<!--end::Page Scripts -->

		<script type="text/javascript">
		$(document).ready(function(){
			
			toastr.options = {
				"positionClass": "toast-top-center",
			}

			//flash message
			var f_message = "<?= $this->session->flashdata('f_message'); ?>";
			var f_type = "<?= $this->session->flashdata('f_type'); ?>";
			if (f_message.length > 0) {
				toastr[f_type](f_message);
			}

		});
		</script>
	</body>
</html>