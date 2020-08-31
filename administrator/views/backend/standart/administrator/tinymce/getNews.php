<!DOCTYPE html>
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/bootstrap-daterangepicker/daterangepicker.css" />
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="/asset/scripts/jquery.ui.datepicker-vn.js"></script>
    <style>
    body.link {padding: 15px 15px 0 !important; font-family: Arial;}
    body.link .ajax_searchNews {margin: 0;}
    body.link .ajax_searchNews .title {width: 323px; white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;}
    </style>
</head>

<body class="link">

<form action="" method="post" id="frm_link" class="parent" style="margin-bottom: 0;">
    <div class="control-group">
        <label class="control-label">Nhập địa chỉ đích</label>
        <div class="controls">
            <input type="text" class="m-wrap" name="link" placeholder="http://example.com" style="width: 90%;width: calc(100% - 122px);" />
            <input type="hidden" name="news_id" value="<?=$_GET['news_id']?>">
            <button type="submit" class="btn green"><i class="icon-ok"></i> Cập nhật</button>
        </div>
        
    </div>
</form>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<script src="/asset/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

<script src="/asset/tinymce/getNews.js?v=<?=time()?>" type="text/javascript"></script>
<div id="loading" style="display: none;">
  <p><img src="/asset/img/ajax-loading.gif" /> Please Wait</p>
</div>
</body>
</html>