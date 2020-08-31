<!DOCTYPE html>
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
    <link href="/asset/css/image-crop.css" rel="stylesheet" type="text/css" />
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <style>
    body.image {font-family: Arial;}
    .nav_radio label {display: inline-block;margin-right: 8px;}
    #img_preview {max-width: 100% !important; max-height: 100% !important; width: auto !important; height: auto !important; position: absolute !important; top: 0; left: 0; bottom: 0; right: 0; margin: auto !important;}
    </style>
</head>
<script type="text/javascript">
var news_id = <?=$news_id?>;
</script>
<body class="image">
<div style="padding: 15px !important; ">
    <div class="tools" style="margin-bottom: 40px;">
        <div class="button-group">
            <button id="btn_resize" type="button" class="btn gray">Resize</button>
            <button id="btn_crop" type="button" class="btn gray">Crop</button>
            <a href="/tinymce/image?news_id=<?=$news_id?>" class="btn blue" style="float: right;">Thay ảnh khác</a>
        </div>
        <div class="resize" style="display: none;">
            <button type="button" class="btn" disabled="disabled">Resize:</button>
            <input id="resize_w" type="text" class="m-wrap" style="width: 35px; text-align: center; margin-bottom: 0;" placeholder="W" />
            <button type="button" class="btn" disabled="disabled">X</button>
            <input id="resize_h" type="text" class="m-wrap" style="width: 35px; text-align: center; margin-bottom: 0;" placeholder="H" />
            <button type="button" class="btn red btn_ok"><i class="icon-ok"></i> OK</button>
            <button type="button" class="btn gray btn_cancel">Cancel</button>
        </div>
        <div class="crop" style="display: none;">
            <button type="button" class="btn" disabled="disabled">Crop:</button>
            <button type="button" class="btn red btn_ok"><i class="icon-ok"></i> OK</button>
            <button type="button" class="btn gray btn_cancel">Cancel</button>
            <input type="hidden" name="crop_x" id="crop_x" />
            <input type="hidden" name="crop_y" id="crop_y" />
            <input type="hidden" name="crop_w" id="crop_w" />
            <input type="hidden" name="crop_h" id="crop_h" />
        </div>
        <div class="paint" style="display: none;">
            <button type="button" class="btn" disabled="disabled">Paint:</button>
            <span>Loading ...</span>
        </div>
    </div>
    
    <div style="width: 100%; height: 343px; text-align: center; background: #eee; position: relative;">
    <img id="img_preview" src="" />
    </div>
    <!--  <label><input type="checkbox" name="wm" value="1" id="myCheck"  onclick="myFunction()"/> Đóng dấu ảnh trắng ở góc</label> -->
    <div>
    <textarea id="caption" name="caption" style="margin-top: 8px;" class="m-wrap span12" placeholder="Caption ..."></textarea>
    </div>

</div>
<div class="modal-footer">
    <div class="nav_radio" style="float: left;">
        <label><input type="radio" name="align" value="none" /> none</label>
        <label><input type="radio" name="align" value="left" /> Trái</label>
        <label><input type="radio" name="align" value="center" /> Giữa</label>
        <label><input type="radio" name="align" value="right" /> Phải</label>
        <label><input type="radio" name="align" value="large" /> Lớn</label>
        <label><input type="radio" name="align" value="full" /> Full</label>
    </div>
    <button type="button" id="btn_cancel" class="btn">Cancel</button>
    <button type="button" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Update</button>
</div>



<script src="/asset/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
<script src="/asset/plugins/jcrop/js/jquery.Jcrop.min.js" type="text/javascript"></script>

<script src="/asset/tinymce/editimage.js?v=<?=time()?>" type="text/javascript"></script>
</body>
</html>