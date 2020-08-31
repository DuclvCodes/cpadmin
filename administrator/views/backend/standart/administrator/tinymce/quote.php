<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style.css?v=0.0.1" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <style>
    body.block {font-family: Arial; overflow: hidden;}
    .nav_radio {float: left; margin-top: 7px;}
    .nav_radio label {display: inline-block; margin-right: 8px;}
    </style>
</head>

<body class="block">

<div style="padding: 15px;">
    <textarea name="info" class="m-wrap span12" style="height: 180px;" placeholder="Nội dung trích dẫn"></textarea>
    <input type="text" name="fullname" class="m-wrap span12" placeholder="Tên nhân vật" />
</div>

<div id="js_wrap_quote" class="hide">
    <div class="quote-inner tkpNoEdit" style="float: left; display: block; width: 165px; margin: 5px 13px 0 0; padding: 0; /*border-top: 8px solid #E0E0E0;*/">
        <div class="tkpEdit"><figure class="tkpNoEdit"><img src="/asset/images/no-image.png" width="500" height="375" /></figure></div>
        <blockquote class="quote tkpEdit" style="border: none; font-size: 17px; line-height: 20px; margin: 0 0 8px; padding: 28px 0 0; max-width: 100%; color: #000;font-weight: bold;font-family: Arial;background: url(/asset/images/quote.png) no-repeat;"></blockquote>
        <p class="tkpEdit" style="font-size: 13px; color: #666; text-align: right;"></p>
    </div>
</div>

<div class="modal-footer">
    <div class="nav_radio">
        <label><input type="radio" name="type" value="left" checked="checked"/> Căn trái</label>
        <label><input type="radio" name="type" value="center" /> Căn giữa</label>
        <label><input type="radio" name="type" value="right"/> Căn phải</label>
    </div>
    <button type="button" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Chèn</button>
</div>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<script src="/asset/tinymce/quote.js?v=<?=time();?>" type="text/javascript"></script>

</body>
</html>