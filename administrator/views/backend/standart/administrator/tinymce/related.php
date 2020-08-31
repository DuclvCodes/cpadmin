<!DOCTYPE html>
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
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
    #frm_news {padding: 15px !important;}
    body.block .ajax_searchNews {margin: 0;}
    body.block .ajax_searchNews .title {width: 323px; white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;}
    .visible {visibility: hidden;}
    .nav_radio {float: left; margin-top: 7px;}
    .nav_radio label {display: inline-block; margin-right: 8px;}
    #wrap_html {height: 200px;}
    ._related_1404022217 {border-top: 3px solid #E0E0E0; margin-top: 12px; margin-bottom: 12px;}
    ._related_1404022217_letter {border-top: 3px solid #c32c2c;display: inline-block;margin-top: -3px !important;line-height: 26px !important;font-family: Arial !important;font-size: 14px !important;margin-bottom: 3px !important;padding: 0;}
    ._related_1404022217_title {text-decoration: none;font-family: Arial !important;font-size: 12px !important;line-height: 16px !important;margin: 8px 0 !important;display: block;font-weight: bold;color: #333 !important; text-align: left !important;}
    ._related_1404022217_title:hover {text-decoration: underline;}
    ._related_1404022217_photo {display: block;}
    ._related_1404022217_left {float: left; width: 140px; margin-right: 12px;}
    ._related_1404022217_right {float: right; width: 140px; margin-left: 12px;}
    ._related_1404022217_bottom {display: inline-block;width: 100%;}
    ._related_1404022217_bottom ._related_1404022217_item {float: left;width: 22.5%;margin-right: 2%;overflow: hidden;border: none;padding: 0;}
    ._related_1404022217_bottom ._related_1404022217_item_last {margin-right: 0 !important;}
    ._related_1404022217_bottom ._related_1404022217_title {line-height: 18px;color: #3b5998 !important;}
    </style>
</head>

<body class="block">

<form action="" method="post" id="frm_news" style="margin-bottom: 0;">
    <div class="control-group">
		<div class="controls">
			<input type="text" class="m-wrap" name="k" placeholder="Từ khóa ..." style="width: calc(100% - 252px); float: left; margin-right: 3px;" />
            <button type="submit" class="btn blue" style="outline: none;"><i class="icon-search"></i></button>
            <div style="clear: both;"></div>
            <div class="nav_radio">
                <label><div class="radio"><span><input type="radio" name="news_type" value="news_title"></span></div> Tin chỉ tiêu đề</label>
                <label><div class="radio"><span class="checked"><input type="radio" name="news_type" value="news_image" checked="checked"></span></div> Tin kèm ảnh</label>
            </div>
            <div style="clear: both;"></div>
		</div>
        <div id="wrap_search" class="scoller" style="height: 200px;"></div>
	</div>
    <div id="wrap_html">
        <div class="tkpNoEdit _related_1404022217 _related_1404022217_bottom visible">
            <div><strong class="_related_1404022217_letter tkpEdit">Tin nên đọc</strong></div>
        </div>
    </div>
    <div style="clear: both;"></div>
</form>

<div class="modal-footer visible">
    <div class="nav_radio">
        <label><input type="radio" name="type" value="_related_1404022217_left" /> Căn trái</label>
        <label><input type="radio" name="type" value="_related_1404022217_bottom" checked="checked" /> Ngang</label>
        <label><input type="radio" name="type" value="_related_1404022217_right" /> Căn phải</label>
    </div>
    <button type="button" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Chèn vào nội dung</button>
</div>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
<script src="/asset/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

<script type="text/javascript">
var news_id = ;
</script>
<script src="/asset/tinymce/related.js?v=<?=time()?>" type="text/javascript"></script>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("a .btn_remove_").click(function(){
           $(".suggest_child").remove();
        });
    });
</script>