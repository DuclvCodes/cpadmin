<?php $mod = current_method()['mod']; ?>
<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.field_fullname {margin-right: 5px;}
.field_title {}
.field_cat {white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;display: block;max-width: 70px;}
.field_date {font-size: 11px; color: #999;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
button.btn.blue.btn_add_into_box {width: 100%; white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;max-width: 222px;}
.tkp_icon_title {font-size: 11px;color: #ed4e2a;margin-left: 5px;}
#tbl_detail_history {}
._related_1404022217 {border-top: 3px solid #E0E0E0; margin-top: 12px; margin-bottom: 12px;}
._related_1404022217_letter {font-weight: normal;border-top: 3px solid #c32c2c;display: inline-block;margin-top: -3px;line-height: 26px !important;font-family: Arial !important;font-size: 14px !important;margin-bottom: 3px;padding: 0;}
._related_1404022217_title {text-decoration: none;font-family: Arial !important;font-size: 12px !important;line-height: 16px !important;margin: 8px 0 !important;display: block;font-weight: bold;color: #333 !important;}
._related_1404022217_title:hover {text-decoration: underline;}
._related_1404022217_photo {display: block;}
._related_1404022217_left {float: left; width: 140px; margin-right: 12px;}
._related_1404022217_right {float: right; width: 140px; margin-left: 12px;}
._related_1404022217_bottom {display: inline-block;width: 100%;}
._related_1404022217_bottom ._related_1404022217_item {float: left;width: 23.5%;margin-right: 2%;overflow: hidden;border: none;padding: 0;}
._related_1404022217_bottom ._related_1404022217_item_last {margin-right: 0 !important;}
._related_1404022217_bottom ._related_1404022217_title {font-weight: normal !important; line-height: 18px;}

table.figure {border: none !important; margin: 5px auto !important; padding: 0 !important;}
table.figure tr, table.figure td {background: transparent !important; border: none !important; margin: 0 !important; padding: 0;}
table.figure tr.figcaption {background: #f5f5f5 !important;}
table.figure tr td {padding: 0 !important;}
table.figure tr.figcaption td {padding: 0 8px !important; line-height: 27px !important; font-size: 12px !important; font-size: 13px !important;}
table.figure img {border: none !important;}

.tkp_attach {box-shadow: 1px 1px 3px rgba(0,0,0,0.5); background: url(<?php echo BASE_ASSET ?>images/attach-icon.jpg) no-repeat #eee; height: 64px; overflow: hidden; max-width: 250px; padding-left: 72px;}
.tkp_attach h2 {margin: 8px 0 0 !important;}
.tkp_attach h2 a {text-decoration: none;}
.tkp_attach p {color: #999; margin: 0 !important;}

.tkp_area_vote {padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5);border: 1px solid #bce8f1;color: #3a87ad;background-color: #d9edf7;}
.tkp_area_vote strong {color: #3a87ad;}
.tkp_area_votemusic {padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5);border: 1px solid #bce8f1;color: #3a87ad;background-color: #d9edf7;}
.tkp_area_votemusic strong {color: #3a87ad;}

.tkp_tinyslide {background: #eee !important; padding: 5px; border: 1px solid #bababa; text-align: left; margin: 0; min-height: 100px;}
.tkp_tinyslide .tkp_one {display: inline-block; width: 100%; margin: 0 0 3px !important; border-bottom: 1px dashed #bababa; padding-bottom: 5px;}
.tkp_tinyslide img {height: 110px !important; display: inline-block; border: none !important; margin: 3px 8px 3px 3px !important; float: left;}

</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Lịch sử sửa bài viết
					</h3>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
                            <div class="span12">
					
                    <div class="row-fluid">
                        <form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
                            <div class="btn form-date-range">
                                <i class="icon-calendar"></i>
                                &nbsp;<span></span> 
                                <b class="caret"></b>
                                <input name="txt_start" value="<?php if (isset($_GET['txt_start'])) {
    echo $_GET['txt_start'];
} ?>" class="txt_start" type="hidden" />
                                <input name="txt_end" value="<?php if (isset($_GET['txt_end'])) {
    echo $_GET['txt_end'];
} ?>" class="txt_end" type="hidden" />
                            </div>
                            <div class="form-news-ajax span4">
                                <div class="input-icon left">
                                    <i class="icon-remove" style="right: 8px;"></i>
                                    <input type="text" placeholder="Bài viết ..." class="m-wrap span12 text" value="<?php if (isset($_GET['news_id']) and $_GET['news_id']>0) {
    $clsNews->getTitle($_GET['news_id']);
}?>" autocomplete="OFF" spellcheck="OFF" style="background: #FFF; padding-right: 33px !important; padding-left: 8px !important;" />
                                </div>
                                <input type="hidden" name="news_id" value="" />
                                <ul></ul>
                            </div>
                            <?php echo $clsUser->getSelect('user_id', isset($_GET['user_id']) ? $_GET['user_id'] : '', 'm-wrap span2', false, '--- Thành viên ---', 'fullname') ?>
                                    <button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
                        </form>
                    </div>
                    
                    <?php if (isset($listItem) and count($listItem) > 1) {
    ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
                        <thead>
                            <tr>
                                <th class="background_white">Thành viên</th>
                                <th class="background_white">Tiêu đề bài viết (hiện tại)</th>
                                <th class="background_white">Hành động</th>
                                <th class="background_white">Thời gian</th>
                                <th class="background_white">Công cụ</th>
                                <th class="background_white">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listItem as $id => $value) {
        $oneItem=$clsHistory->getOne($value); ?>
                        <tr class="odd gradeX">
                            <td><span class="label label-success field_fullname"><?php echo $clsUser->getFullName($oneItem['user_id']) ?></span></td>
                            <td><?=$clsNews->getTitle($oneItem['news_id'])?></td>
                            <td>
                                <?php if ($oneItem['title']=='CREATE') {
            ?>
                                <span class="badge badge-info">THÊM MỚI</span>
                                <?php
        } elseif ($oneItem['title']=='EDIT') {
            ?>
                                <span class="badge">SỬA</span>
                                <?php
        } elseif ($oneItem['title']=='TRASH') {
            ?>
                                <span class="badge badge-important">XÓA TẠM</span>
                                <?php
        } elseif ($oneItem['title']=='DELETE') {
            ?>
                                <span class="badge badge-inverse">XÓA VĨNH VIỄN</span>
                                <?php
        } ?>
                            </td>
                            <td><?=date('H:i d/m/Y', strtotime($oneItem['reg_date']))?></td>
                            <td><a href="#" data-id="<?=$value?>" class="btn mini blue btn_detail"><i class="icon-signin"></i> Xem chi tiết</a></td>
                            <td><a href="/history?news_id=<?=$oneItem['news_id']?>" title="Lọc bài viết này">#<?=$oneItem['news_id']?></a></td>
                        </tr>
                        <?php
    } ?>
                        </tbody>
                    </table>
                    
                    <div class="pagination">
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
                        <div class="clearfix"></div>
                    </div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    
                    <?php
} else {
        echo '<p style="font-size: 45px;color: #999;margin: 68px 0;text-align: center;">Không có bản ghi nào!</p>';
    } ?>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>

<script type="text/javascript">
$(document).ready(function(){
    
    $('.input-icon').each(function(){
        var obj = $(this);
        $(this).find('.icon-remove').click(function(){
            obj.find('input').val('').focus();
        });
    });
    
    $('.form-news-ajax').each(function(){
        var obj = $(this);
        $(this).find('input.text').blur(function(){
            setTimeout(function(){
                obj.removeClass('open');
            }, 200);
        });
        $(this).find('input.text').keyup(function(){
            obj.removeClass('open').find('ul').html('');
            obj.find('input[type=hidden]').val('');
            var keyword = $(this).val();
            if(keyword=='') return false;
            $(document).ajaxStop(function() {});
            $.getJSON('/api/getJSNews?keyword='+keyword, function (json) {
                var k = 0;
                $.each(json, function (i, one) {
                    k++;
                    obj.find('ul').append('<li data-id="'+one.news_id+'"><p class="title">'+one.title+'</p></li>');
                });
                if(k>0) {
                    obj.addClass('open');
                    obj.find('li').unbind().click(function(){
                        var id = $(this).attr('data-id');
                        var title = $(this).find('.title').text();
                        obj.find('input.text').val(title);
                        obj.find('input[type=hidden]').val(id);
                        obj.removeClass('open');
                    });
                }
                return false;
            });
        });
    });
    $('.btn_detail').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        $modal = $('#modal_history_detail');
        $modal.load('/ajax/history_detail?id='+id, '', function(){
            $modal.modal().on("hidden", function() {
                $modal.empty();
            });
        });
        return false;
    });
});
</script>
<div id="modal_history_detail" class="modal container hide fade" data-width="793" style="font-family: Arial;"></div>