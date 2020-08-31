<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    
    <script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
    <style>
    body.vote {font-family: Arial; overflow: hidden;}
    #wrap_vote {padding: 15px; height: 230px; overflow: hidden;font-family: Arial; font-size:14px; line-height:25px;color:#111;}
    body.vote .control-group .controls {position: relative;}
    body.vote .control-group .controls .icon-remove {position: absolute; top: 8px; right: 8px;}
    body.vote .add_choose .icon-plus {margin-right: 3px;}
    body.vote .add_choose:hover {text-decoration: none !important;}
    .control-group.error input, .control-group.error select, .control-group.error textarea {border-color: #ed4e2a !important;}
    </style>
    <link rel="stylesheet" type="text/css" href="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    <script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
</head>

<body class="vote">

<form action="/tinymce/vote" method="get" id="frm_list" style="margin-bottom: 0; padding: 8px;">
    <div class="control-group">
		<div class="controls">
                    <input type="text" class="m-wrap" name="k" placeholder="Từ khóa ..." style="width: calc(100% - 252px); float: left; margin-right: 3px;" />
                    <button type="submit" class="btn blue" style="outline: none;"><i class="icon-search"></i></button>
                    <a href="#" class="btn red" style="float: right;" id="btn_add"><i class="icon-plus"></i> Tạo mới</a>
                    <div style="clear: both;"></div>
		</div>
                <div id="wrap_search" class="scoller" style="height: 311px;">
        <table class="table table-condensed table-hover ajax_searchNews">
        <tbody>
            <?php if ($listItem) {
    foreach ($listItem as $key=>$item) {
        $oneItem=$clsVoter->getOne($item); ?>
                <tr>
        <td><div class="title"><a class="btn_one_vote" href="#" data-id="<?=$item?>"><?php echo $oneItem['title'] ?></a></div></td>
        <td><span class="label label-success"><?=date('d/m/Y - H:i', strtotime($oneItem['reg_date']))?></span></td>
        </tr>
            <?php
    }
} ?>
                </tbody>
        </table>
        </div>
        <div class="pagination">
			<ul>
                			</ul>
		</div>
        	</div>
    <div style="clear: both;"></div>
</form>

<form class="horizontal-form" action="/api/vote" id="frm_vote" style="display: none;">
    <div id="wrap_vote" style="height: 332px;">
        <div class="row-fluid">
            <div class="control-group">
                <div class="controls">
                    <textarea class="m-wrap required span12" name="title" placeholder="Đặt câu hỏi ..." style="height: 70px;"></textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="text" name="answers[]" value="" class="m-wrap required span12" placeholder="Lựa chọn 1" />
                    <i class="icon-remove js_close hide"></i>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="text" name="answers[]" value="" class="m-wrap required span12" placeholder="Lựa chọn 2" />
                    <i class="icon-remove js_close hide"></i>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <a class="add_choose" href="#"><i class="icon-plus"></i> Lựa chọn khác</a>
                </div>
            </div>
        </div>
    </div>

<div class="modal-footer">
    <input type="hidden" name="vote_id" value="0" />
    <a href="#" class="btn blue" style="float: left;" id="btn_search"><i class="icon-search"></i> Tìm kiếm</a>
    <button type="submit" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Chèn vào nội dung</button>
</div>
</form>
<script src="/asset/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/asset/tinymce/vote.js?v=<?=time()?>" type="text/javascript"></script>

</body>
</html>