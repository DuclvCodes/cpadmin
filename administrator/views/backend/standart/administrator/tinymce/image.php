<!DOCTYPE html>
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
        <meta content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/asset/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    
    <link rel="stylesheet" type="text/css" href="/asset/plugins/bootstrap-daterangepicker/daterangepicker.css" />
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="/asset/scripts/jquery.ui.datepicker-vn.js"></script>
    <style>
    body.image {padding: 15px !important; font-family: Arial;}
    body.image .tab_btn {margin-bottom: 15px;}
    body.image #tab-4 {border: 1px solid rgba(0,0,0,0.03);border-radius: 3px;background: rgba(0,0,0,0.03);padding: 23px;}
    body.image .meet-our-team {position: relative;}
    body.image .meet-our-team svg {display: none; position: absolute; top: 3px; left: 3px; fill: #FFF; cursor: pointer;}
    body.image .meet-our-team.s0:hover svg.orgUxc {display: inline-block;}
    body.image .meet-our-team.s1 svg.rqet2b {display: inline-block; opacity: 0.8;}
    body.image .meet-our-team.s1:hover svg.rqet2b {display: none;}
    body.image .meet-our-team.s1:hover svg.orgUxc {display: inline-block;}
    body.image .meet-our-team.active svg.eoYPIb {display: inline-block;}
    body.image .meet-our-team.active svg.orgUxc {display: inline-block; fill: #4285f4;}
    body.image .meet-our-team .team-info {white-space: nowrap; overflow: hidden; -ms-text-overflow: ellipsis; -o-text-overflow: ellipsis; text-overflow: ellipsis;}
    body.image .meet-our-team .btn_remove {position: absolute; top: 0; right: 0; color: #FFF; text-decoration: none; cursor: pointer;width: 20px; height: 20px; text-align: center; opacity: 0.5;}
    body.image .meet-our-team .btn_remove:hover {opacity: 1;}
    body.image .meet-our-team .btn_remove:hover i:before {cursor: pointer;}
    body.image #my-awesome-dropzone {position: relative;}
    body.image #my-awesome-dropzone label {position: absolute; left: 0; bottom: -30px;}
    </style>
</head>

<body class="image">
<div class="row-fluid tab_btn">
	<a href="#tab-1" class="btn <?php if ($_GET['tab'] == 1 or $_GET['tab'] == '') {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-plus icon-white"></i> Tải lên</a>
	<a href="#tab-2" class="btn <?php if ($_GET['tab'] == 2) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-picture icon-white"></i> Đã tải lên từ bài này</a>
    <a href="#tab-3" class="btn <?php if ($_GET['tab'] == 3) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-picture icon-white"></i> Tất cả</a>
    <a href="#tab-4" class="btn <?php if ($_GET['tab'] == 4) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-download-alt icon-white"></i> Chèn từ URL</a>
    <a href="#" id="btn_insert_content" class="btn green pull-right" style="display: none;"><i class="icon-signout"></i> Chèn vào bài</a>
</div>

<div id="tab-1" class="tab_content <?php if ($_GET['tab'] == 1 or $_GET['tab'] == '') {
    echo '';
} else {
    echo 'hide';
}?>">
    <form action="/tinymce/image?news_id=<?=$news_id?>" method="post" enctype="multipart/form-data" class="dropzonez" id="my-awesome-dropzone">
        <input type="hidden" name="wm" value="0" />
        <label><input type="checkbox" name="wm" value="1" /> Đóng dấu ảnh trắng ở góc</label>
        <input type="hidden" name="wm2" value="0" />
        <label style="bottom: -55px;"><input type="checkbox" name="wm2" value="1" /> Đóng dấu ảnh trắng ở giữa</label>
        <input type="hidden" name="wm3" value="0" />
        <label style="bottom: -81px;"><input type="checkbox" name="wm3" value="1" /> Đóng dấu ảnh màu ở góc</label>
        <input type="hidden" name="wm4" value="0" />
        <label style="bottom: -106px;"><input type="checkbox" name="wm4" value="1" /> Đóng dấu ảnh màu ở giữa</label>
        <div class="dz-default dz-message" data-dz-message=""><span>Drop files here to upload</span></div>
    </form>
</div>

<div id="tab-2" class="tab_content <?php if ($_GET['tab'] == 2) {
    echo '';
} else {
    echo 'hide';
}?>">
    <div style="min-height: 390px;">    
        <div class="row-fluid">
        <?php if ($listImageCurrent) {
    foreach ($listImageCurrent as $key=>$imageC) {
        ?>
            <div class="span3" style="width: 23% !important;float:left !important;">
                <div class="meet-our-team s0" id="oneImage_<?=$imageC['id']?>">
                    <a href="<?=MEDIA_DOMAIN.$imageC['file']; ?>" data-width="" data-height="" class="btn_Insert"><img src="<?=$imageC['thumb']; ?>" alt="" /></a>
                    <div class="team-info">
                            <p><a href="#" title="" class="editable" data-pk="<?=$imageC['id']?>" data-placement="right" data-original-title="Nhập Caption"><?=$imageC['name']; ?></a></p>
                    </div>
                    <a href="#" class="btn_remove" data-id="<?=$imageC['id']?>"><i class="icon-remove"></i></a>
                </div>
                </div>
                <?php
    }
} ?>
    	    </div>
    </div>        
    <div class="row-fluid">
        <div class="span12">
                <div class="pagination">
                    <ul>
                        <?php if ($paging) {
    foreach ($paging as $one) {
        ?>
                        <li class="<?php if ($cursorPage==$one[0]) {
            echo 'active';
        } ?>"><a href="<?php echo getLinkReplateGET(array('page'=>$one[0])) ?>"><?php echo $one[1] ?></a></li>
                        <?php
    }
} ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<div id="tab-3" class="tab_content <?php if ($_GET['tab'] == 3) {
    echo '';
} else {
    echo 'hide';
}?>">
        <div style="min-height: 390px;">        
            <div class="row-fluid">
                
                    <?php if ($listImage) {
    foreach ($listImage as $key2=>$image) {
        ?>
                    <div class="span3" style="width: 23% !important; float:left !important">
                        <div class="meet-our-team s0" id="oneImage_<?=$image['id']?>">
                            <a href="<?=MEDIA_DOMAIN.$image['file']; ?>" data-width="1250" data-height="833" class="btn_Insert"><img src="<?=$image['thumb']; ?>" alt="" /></a>
                            <div class="team-info" style="width: 150px;">
                                    <p><a href="#" title="" class="editable" data-pk="<?=$image['id']?>" data-placement="right" data-original-title="Nhập Caption"><?=$image['name']; ?></a></p>
                            </div>
                            <svg width="24px" height="24px" class="rqet2b" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path></svg>
                            <svg width="24px" height="24px" class="eoYPIb" viewBox="0 0 24 24"><circle cx="12.5" cy="12.2" r="8.292"></circle></svg>
                            <svg width="24px" height="24px" class="orgUxc" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                            <a href="#" class="btn_remove" data-id="<?=$image['id']?>"><i class="icon-remove"></i></a>
                        </div>
                        </div>
                        <?php
    }
} ?>
                    </div>
        </div>        
        <div class="row-fluid">
                <div class="span12">
                    <form class="control" method="get" action="/tinymce/image" style="margin:20px 0 0;float: left;">
                        <input type="hidden" name="news_id" value="<?=$news_id?>" />
                        <input type="hidden" name="tab" value="3" />
                        <input autofocus="true" name="q" value="<?=$_GET['q']?>" type="text" placeholder="từ khóa ..." class="m-wrap" style="padding: 4px !important;" />
                        <button class="btn mini green" style="padding: 8px;height: 30px;"><i class="icon-arrow-right"></i> Tìm kiếm</button>
                    </form>
                <div class="pagination pull-right">
                    <ul>
                        <?php if ($pagingAll) {
    foreach ($pagingAll as $one) {
        ?>
                        <li class="<?php if ($cursorPage==$one[0]) {
            echo 'active';
        } ?>"><a href="<?php echo getLinkReplateGET(array('page'=>$one[0],'tab'=>3)) ?>"><?php echo $one[1] ?></a></li>
                        <?php
    }
} ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<div id="tab-4" class="tab_content <?php if ($_GET['tab'] == 4) {
    echo '';
} else {
    echo 'hide';
}?>">
    <form action="" method="post" id="form-username">
		<div class="control-group">
			<div class="controls">
				<input type="text" class="m-wrap" name="image" style="width: 60%; background: #FFF;" placeholder="http://example.com/image.jpg" />
				<button type="submit" class="btn green"><i class="icon-ok"></i> Download</button>
				<div class="help-block">Nhập đường dẫn ảnh và nhấn Download để tải ảnh về hệ thống.</div>
			</div>
		</div>
	</form>
</div>

<script src="/asset/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<link href="/asset/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
<script src="/asset/plugins/dropzone/dropzone.min.js"></script>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<link href="/asset/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js" type="text/javascript"></script>

<script type="text/javascript">
var news_id = <?=$news_id?>;
var max_width = 1250;
</script>
<script src="/asset/tinymce/image.min.js?v=<?=time()?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('body.image .meet-our-team .btn_remove').click(function(){
        if(confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
            var obj = $(this).parents('.span3');
            var id = $(this).attr('data-id');
            $.ajax({
        		type: "POST",
        		url: '/tinymce/image',
                        data: 'name=delete&id='+id,
        		dataType: "html",
        		success: function(msg){
                    if(msg=='1') obj.remove();
                    else alert('Lỗi xóa ảnh');
        		},
                error: function(request,error) {
                    alert("Can't do because: " + error);
                }
        	});
        }
        return false;
    });
});
</script>
</body>
</html>