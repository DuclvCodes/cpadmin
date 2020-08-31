<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <style>
    body.block {font-family: Arial; overflow: hidden;}
    #wrap_quote {padding: 15px; height: 230px; overflow: hidden;font-family: Arial; font-size:14px; line-height:25px;color:#111;}
    #js_wrap_quote blockquote {max-width: 98%; float: none !important;}
    .nav_radio {float: left; margin-top: 7px;}
    .nav_radio label {display: inline-block; margin-right: 8px;}
    </style>
</head>

<body class="block">
<div id="js_wrap_quote" class="hide"><blockquote style="display: block; width: 165px; background:#D5EDF9; border: none; text-align: justify;padding: 8px; margin: 0 8px 0 0; font-size: 13px; line-height: 18px;"></blockquote></div>
<div id="wrap_quote">
    <textarea name="info" class="m-wrap span12" style="height: 230px;"></textarea>
</div>

<div class="modal-footer">
    <div class="nav_radio">
        <label><input type="radio" name="type" value="left" checked="checked"/> Căn trái</label>
        <label><input type="radio" name="type" value="bottom"/> Ngang</label>
        <label><input type="radio" name="type" value="right"/> Căn phải</label>
    </div>
    <button type="button" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Chèn</button>
</div>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<script src="/asset/tinymce/info.js?v=<?=time()?>" type="text/javascript"></script>

</body>
</html>