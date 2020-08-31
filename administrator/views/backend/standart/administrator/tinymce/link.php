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
		<div class="controls">
			<input type="text" class="m-wrap span12" name="title" placeholder="Tiêu đề" />
		</div>
	</div>
	<div class="control-group">
        <label class="control-label">Nhập địa chỉ đích</label>
		<div class="controls">
			<input type="text" class="m-wrap" name="link" placeholder="http://example.com" style="width: 90%;width: calc(100% - 122px);" />
			<button type="submit" class="btn green"><i class="icon-ok"></i> Cập nhật</button>
		</div>
        <label class="control-label"><input type="checkbox" name="tab" value="1" checked="checked" /> Mở liên kết trong tab mới</label>
        <label class="control-label"><input type="checkbox" name="index" value="1" checked="checked" /> Chặn Google index link này (nofollow)</label>
        <p style="padding: 15px 0 0; margin: 0;">+ <a href="#frm_news" class="btn_open_hide">Hoặc liên kết đến nội dung đã tồn tại</a></p>
	</div>
</form>

<div id="frm_news" class="parent hide">
    <div class="control-group">
		<div class="controls">
			<input type="text" class="m-wrap" name="k" placeholder="Từ khóa ..." style="width: calc(100% - 252px); float: left; margin-right: 3px;" />
            		<button id="btn_search" type="button" class="btn gray"><i class="icon-search"></i></button>
            <div style="clear: both;"></div>
		</div>
        <div id="wrap_search" class="scoller"></div>
	</div>
    <p style="padding: 0; margin: 0;">+ <a href="#frm_link" class="btn_open_hide">Nhập địa chỉ đích</a></p>
</div>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<script src="/asset/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

<script src="/asset/tinymce/link.js?v=<?=time()?>" type="text/javascript"></script>

</body>
</html>