<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Chèn video - Tekplus CMS</title>
    
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/giaoducthoidai/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/giaoducthoidai/asset/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/giaoducthoidai/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/giaoducthoidai/asset/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css?v=7" rel="stylesheet" type="text/css"/>
    
    <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="../../tiny_mce_popup.js"></script>
    <script type="text/javascript" src="../../tiny_mce.js"></script>
    <script type="text/javascript" src="../../utils/form_utils.js"></script>
    <script type="text/javascript" src="../../utils/validate.js"></script>
    <script type="text/javascript" src="../../utils/editable_selects.js"></script>
    <script type="text/javascript" src="js/dialog.js"></script>
    <script type="text/javascript" src="js/jquery.knob.js"></script>
    <script type="text/javascript" src="js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="js/jquery.fileupload.js"></script>
    
    <script type="text/javascript" src="js/script.js?v=9"></script>
    
</head>
<body class="images">
    <div id="upload" style="margin: 0; background: #fff;">
        <div class="box-drop-drag" id="drop" style="display: none;margin-top: 50px;">
            <input class="m-wrap" type="text" name="filename" id="filename" style="width: 167px;" placeholder="tên File ..."/>
            <button type="submit" id="submitfile" class="btn green" style="height: 34px; outline: none;"><i class="icon-ok"></i>Xử lý file</button>
            <button type="button" id="btn_old_upload" class="btn" style="height: 34px; margin-left: 10px;"><i class="icon-upload-alt"> Upload bằng trình duyệt</i></button>
        </div>
    </div>
    <form id="upload2" action="/api/uploadVideo" method="post" enctype="multipart/form-data" style="margin: 0;">
        <div class="box-drop-drag" id="drop" style="display: none;">
            <input type="file" accept=".mp4" name="upl" value="" class="hide" id="inp_upload" />
        </div>
    </form>
    <img id="loading" style="border: none;margin: 59px 0; display: none;" src="img/loading_icon.gif" />
    <div class="list_uploading" style="display: none;">
        <ul id="js_append_html"><li class="workingvideo"></li></ul>
        <div style="text-align: center;"><a style="display: none;" id="btn_insert" href="#" title="" class="btn blue">Chèn vào bài</a><a style="display: none;" id="btn_insert2" href="#" title="" class="btn blue">Chèn vào bài</a></div>
        <br />
    </div>
    <div id="history">
        <form action="" method="get" style="margin: 6px;">
            <button type="button" id="btn_back_upload" class="btn" style="height: 34px;"><i class="icon-upload-alt"> Upload</i></button>
            <select class="m-wrap" name="all_user" style="width: 123px;">
                <option value="0">Video của tôi</option>
                <option value="1">Tất cả mọi người</option>
            </select>
            <select class="m-wrap" name="year" style="width: 60px;">
                <option value="">Năm</option>
            </select>
            <select class="m-wrap" name="month" style="width: 60px;">
                <option value="">Tháng</option>
            </select>
            <select class="m-wrap" name="day" style="width: 60px;">
                <option value="">Ngày</option>
            </select>
            <input class="m-wrap" type="text" name="keyword" style="width: 167px;" placeholder="từ khóa ..." />
            <button type="submit" class="btn green" style="height: 34px; outline: none;"><i class="icon-ok"></i></button>
            <input type="hidden" name="page" value="1" />
        </form>
        <ul class="list_img"></ul>
    </div>
</body>
</html>