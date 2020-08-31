<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập 2 bước của Google</title>
        <link rel="stylesheet" type="text/css" href="/asset/css/xacthuc2buoc.css" charset="utf-8" />
    </head>
    <body>
        <div id="container">
            <h1>Kiểm tra thông tin tài khoản</h1>
        <div id="login">
        <h3>Đăng nhập</h3>
        <form method="post" action="/xacthuc2buoc/login" name="login">
            <label>Tên đăng nhập hoặc email</label>
            <input type="text" name="usernameEmail" autocomplete="off" />
            <label>Mật khẩu</label>
            <input type="password" name="password" autocomplete="off"/>
            <div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
            <input type="submit" class="button" name="loginSubmit" value="Login">
        </form>
        </div>
        </div>

    </body>
</html>