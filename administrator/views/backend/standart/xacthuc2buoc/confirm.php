<!DOCTYPE html>
<html>
<head>
    <title>Xác thực đăng nhập 2 bước của Google cho tòa soạn phapluatplus.vn</title>
    <link rel="stylesheet" type="text/css" href="/asset/css/xacthuc2buoc.css" charset="utf-8" />
</head>
<body>
	<div id="container">
		<h1>Xác thực đăng nhập 2 bước của Google</h1>
		<div id='device'>

<p>Hãy nhập mã xác thực của Google Authenticator trên điện thoại của bạn.</p>
<div id="img">
<img src='<?php echo $qrCodeUrl; ?>' />
</div>

<form method="post" action="/xacthuc2buoc/confirm">
<label>Enter Google Authenticator Code</label>
<input type="text" name="code" />
<input type="submit" class="button"/>
</form>
</div>
<div style="text-align:center">
	<h3>Download và sử dụng phần mềm miễn phí của Google trên SmartPhone</h3>
<a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank"><img class='app' src="/asset/images/iphone.png" /></a>

<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><img class="app" src="/asset/images/android.png" /></a>
</div>
</div>
</body>
</html>