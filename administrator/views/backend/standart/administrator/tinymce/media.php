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
    <link rel="stylesheet" type="text/css" href="/asset/plugins/dropzone/css/dropzone.css"/>
    <link rel="stylesheet" type="text/css" href="/asset/plugins/bootstrap-daterangepicker/daterangepicker.css" />
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="/asset/scripts/jquery.ui.datepicker-vn.js"></script>
    <style>
    body.media {padding: 15px !important; font-family: Arial;}
    body.media .tab_btn {margin-bottom: 15px;}
    body.media #tab-4, body.media #tab-5 {border: 1px solid rgba(0,0,0,0.03);border-radius: 3px;background: rgba(0,0,0,0.03);padding: 23px;}
    body.media h3 {font-family: 'Open Sans', sans-serif;}
    body.media .oneVideo {position: relative; margin-bottom: 13px;}
    body.media .oneVideo .btn_Insert {position: relative; display: inline-block; width: 100%;}
    body.media .oneVideo .btn_Insert span {position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #FFF; font-size: 11px; padding: 0 3px; line-height: 13px; font-weight: bold;}
    body.media .oneVideo .p {font-size: 11px;position: absolute;left: 0;top: 0;background: #000;color: #FFF;width: 92%;padding: 0 4%;background: -webkit-linear-gradient(#000, transparent);}
    body.media .oneVideo .title {color: #167ac6; display: block; max-height: 32px; line-height: 16px; margin: 5px 0 0; overflow: hidden; font-size: 12px;white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;}
    body.media .oneVideo .btn_remove {position: absolute; top: 0; right: 0; color: #FFF; text-decoration: none; cursor: pointer;width: 20px; height: 20px; text-align: center; opacity: 0.5;}
    body.media .oneVideo .btn_remove:hover {opacity: 1;}
    body.media .oneVideo .btn_remove:hover i:before {cursor: pointer;}
    body.media #frm_upload {position: relative;}
    body.media #frm_upload label {position: absolute; left: 0; bottom: -30px;}
    </style>
</head>

<body class="media" style="overflow: auto !important;">

<div class="row-fluid tab_btn">
	<a href="#tab-1" class="btn <?php if ($_GET['tab'] == 1 or $_GET['tab'] == '') {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-plus"></i> Tải lên</a>
	<a href="#tab-2" class="btn <?php if ($_GET['tab'] == 2) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-bookmark"></i> Đã tải lên từ bài này</a>
    <a href="#tab-3" class="btn <?php if ($_GET['tab'] == 2) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-film"></i> Tất cả</a>
    <a href="#tab-4" class="btn <?php if ($_GET['tab'] == 3) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-youtube-play"></i> Youtube</a>
    <a href="#tab-5" class="btn <?php if ($_GET['tab'] == 4) {
    echo 'red';
} else {
    echo 'blue';
}?>"><i class="icon-cloud"></i> Embed</a>
</div>

<div id="tab-1" class="tab_content ">
    <form method="post" id="frm_upload" action="" class="dropzonez dz-clickable">
        <input type="file" accept=".mp4" name="file" class="hide" />
        <input type="hidden" name="action" value="upload" />
        <input type="hidden" name="wm" value="0" /><input type="hidden" name="cv" value="0" />
        <!--<label><input type="checkbox" name="wm" value="1" /> Đóng dấu video</label>-->
        <div id="btn_tab_1" class="dz-default dz-message" style="width: 100%;margin: 0;left: 0;top: 0;height: 100%;background: none;"><span style="display: block;background: url(/asset/plugins/dropzone/images/spritemap.png) no-repeat 0 -296px;width: 320px;height: 90px;position: absolute;left: 37%;top: 32%;"></span></div>
    </form>
    
    <div class="uploadbar hide" style="margin-top: 130px; transition: margin .6s ease;">
        <h3>Tải lên <span id="lbl_upload" style="float: right;"></span></h3>
        <div class="progress progress-striped active">
    		<div style="width: 0%;" class="bar bar-success"></div>
    	</div>
    </div>
    
    <div class="progressbar hide">
        <h3>Xử lý video</h3>
        <div class="progress progress-striped active">
    		<div style="width: 0%; transition: width 10s ease;" class="bar"></div>
    	</div>
    </div>
    
    <div class="row-fluid hide">
        <h3>Chọn ảnh cover cho video</h3>
        <div id="list_images_cover"></div>
    </div>
    
</div>

<div id="tab-2" class="tab_content <?php if ($_GET['tab'] == 2) {
    echo '';
} else {
    echo 'hide';
}?>">
    </div>

<div id="tab-3" class="tab_content <?php if ($_GET['tab'] == 3) {
    echo '';
} else {
    echo 'hide';
}?>">
    <div style="min-height: 390px;">    
        <div class="row-fluid">
            <?php foreach ($listVideo as $key=>$video) {
    ?>
            	<div class="span3">
                    <div class="oneVideo">
                            <a href="#" class="btn_Insert" title="<?=$video['title']?>"><img src="<?=$video['thumb']?>" alt="" /><span><?=$video['duration']?></span></a>
                            <div class="team-info">
                        <p class="title"><?=$video['title']?></p>
                        <p class="p">bởi <?php echo $clsUser->getFullName($video['user_id']) ?> &middot; <?=time_ago(strtotime($video['reg_date']))?></p>
                        <p class="embed hide"><iframe class="tkp_video" src="<?=$video['iframe']?>" frameborder="" width="100%" height="450" allowfullscreen="true"></iframe></p>
                            </div>
                    <a href="#" class="btn_remove" data-id="<?=$video['id']?>"><i class="icon-remove"></i></a>
                    </div>
                </div>
            <?php
} ?>
    	    </div>
    </div>        
    <div class="row-fluid">
			<div class="span12">
                <form class="control" method="get" action="/tinymce/media" style="margin:20px 0 0;float: left;">
                    <input type="hidden" name="news_id" value="<?=$news_id?>" />
                    <input type="hidden" name="tab" value="3" />
                    <input autofocus="true" name="q" value="" type="text" placeholder="từ khóa ..." class="m-wrap" style="padding: 4px !important;" />
                    <button class="btn mini green" style="padding: 8px;height: 30px;"><i class="icon-arrow-right"></i> Tìm kiếm</button>
                    <label style="display: inline-block; margin-left: 13px;"><input type="hidden" name="is_news" value="0" /><input  type="checkbox" name="is_news" value="1" /> Tìm theo bài</label>
                </form>
				<div class="pagination pull-right">
                                    <?php if ($paging) {
        ?>
                                    <ul>
                                        <?php foreach ($paging as $one) {
            ?>
                                            <li class="<?php if ($cursorPage==$one[0]) {
                echo 'active';
            } ?>"><a href="<?php echo getLinkReplateGET(array('page'=>$one[0])) ?>"><?php echo $one[1] ?></a></li>
                                        <?php
        } ?>
                                    </ul>
                                    <?php
    } ?>
				</div>
			</div>
		</div>
    </div>

<div id="tab-4" class="tab_content <?php if ($_GET['tab'] == 4) {
        echo '';
    } else {
        echo 'hide';
    }?>">
    <form action="" method="post" id="form-youtube">
		<div class="control-group">
			<div class="controls">
				<input type="text" class="m-wrap" name="youtube" style="width: 60%; background: #FFF;" placeholder="https://www.youtube.com/watch?v=xxxxxx" />
				<button type="submit" class="btn green"><i class="icon-ok"></i> Chèn vào bài</button>
				<div class="help-block">Nhập đường dẫn URL Youtube để chèn video vào trong bài viết.</div>
			</div>
		</div>
	</form>
</div>

<div id="tab-5" class="tab_content <?php if ($_GET['tab'] == 5) {
        echo '';
    } else {
        echo 'hide';
    }?>">
    <form action="" method="post" id="form-embed">
		<div class="control-group">
			<div class="controls">
				<textarea class="m-wrap span12" name="embed" style="background: #FFF; height: 120px;" ></textarea>
			</div>
            <button type="submit" class="btn green"><i class="icon-ok"></i> Chèn vào bài</button>
		</div>
	</form>
</div>

<script src="/asset/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<link href="/asset/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

<link href="/asset/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css"/>
<script src="/asset/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js" type="text/javascript"></script>

<script src="/asset/js/jquery.form.js" type="text/javascript"></script>

<script src="/asset/tinymce/media.js?v=<?=time()?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('body.media .oneVideo .btn_remove').click(function(){
        if(confirm('Bạn có chắc chắn muốn xóa video này?')) {
            var obj = $(this).parents('.span3');
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: '/tinymce/media',
                data: 'action=delete&id='+id,
                dataType: "html",
                success: function(msg){
                    if(msg=='ok') obj.remove();
                    else alert('Lỗi xóa video');
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