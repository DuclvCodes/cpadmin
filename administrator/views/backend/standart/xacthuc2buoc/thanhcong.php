<!DOCTYPE html>
<html>
<head>
    <title>Xác thực đăng nhập 2 bước của Google cho tòa soạn <?=DOMAIN_NAME?></title>
    <link rel="stylesheet" type="text/css" href="/asset/css/xacthuc2buoc.css" charset="utf-8" />
</head>
<body>
	<div id="container">
<h1>Xin chào <?php echo $userDetails['fullname']; ?></h1>

<br/>
Bạn đang sử dụng tài khoản với username là <h2><?php echo $userDetails['username']; ?></h2> <br/>
Bạn đã xác thực thành công, hãy liên hệ với ban quản trị để chấp nhận và bật tính năng xác thực 2 bước của bạn lên <br/>
<h4><a href="/xacthuc2buoc/logout">Logout</a></h4>
</div>
</body>
</html>