<style>
table.store .btn_remove {height: 11px;padding: 1px 6px 4px;margin-left: 8px;display: none;}
table.store tr:hover .btn_remove {display: inline-block;}
</style>
<link href="<?php echo URL_THEMES ?>/css/pages/profile.css" rel="stylesheet" type="text/css" />
<div class="page-container row-fluid">
	<?php $core->getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Kho tin tổng hợp
                        <a id="btn_setting_store" href="#" class="btn red-stripe pull-right"><i class="icon-cog"></i> Cài đặt</a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiên</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="?mod=<?php echo $mod ?>">Kho tin tổng hợp</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Danh sách</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php if ($listItem) {
    ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default store" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tiêu đề</th>
                                <th class="background_white">Đã xem</th>
                                <th class="background_white" style="width: 120px;">Thời gian</th>
                                <th class="background_white" style="width: 70px;">Danh mục</th>
                                <th class="background_white" style="width:23px;">ID</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $id) {
        $oneItem=$clsStore->getOne($id); ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <span class="label label-success field_fullname"><?php echo $oneItem['domain_name'] ?></span>
                                        <?php
                                        $viewd_arr = $core->pathToArray($oneItem['user_viewed']);
        $viewd_str = '';
        if ($viewd_arr) {
            foreach ($viewd_arr as $user_id) {
                $viewd_str .= ', '.$clsUser->getLashName($user_id);
            }
        } ?>
                                        <a style="<?php if (!in_array($me['user_id'], $viewd_arr)) {
            echo 'font-weight: bold;';
        } else {
            echo 'color: #666';
        } ?>" store-id="<?php echo $id ?>" data-id="<?php echo $oneItem['news_id'] ?>" href="#" class="btn_title"><?php echo $oneItem['title'] ?></a>
                                        <a href="#" data-id="<?php echo $id ?>" class="btn mini red btn_remove tooltips" data-placement="right" data-original-title="Xóa tin này"><i class="icon-trash"></i></a>
                                    </div>
                                </td>
                                <td><?php if ($viewd_str) {
            ?><span style="color: #999;font-size: 11px;margin-left: 12px;"><?php echo ltrim($viewd_str, ', '); ?></span><?php
        } ?></td>
                                <td><a href="#" class="btn mini red-stripe tooltips" data-placement="top" data-original-title="<?php echo date('H:i - d.m.Y', strtotime($oneItem['reg_date'])) ?>"><?php echo $core->time_ago(strtotime($oneItem['reg_date'])) ?></a></td>
                                <td><span class="label label-info field_cat"><?php echo $oneItem['category_name'] ?></span></td>
                                <td class="filed_id"><?php echo $id ?></td>
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
            } ?>"><a href="<?php echo $core->getLinkReplateGET(array('page'=>$one[0])) ?>"><?php echo $one[1] ?></a></li>
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
<div id="mnu_setting_store" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<div id="modal_get_detail" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<script type="text/javascript">
$(document).ready(function(){
    var $modal_setting = $('#mnu_setting_store');
    $('#btn_setting_store').click(function(){
        $('body').modalmanager('loading');
        $modal_setting.load('?mod=ajax&act=getSettingStore', '', function(){
            $modal_setting.modal().on("hidden", function() {
                $modal_setting.empty();
            });
        });
        return false;
    });
    
    $('.btn_title').click(function(){
        $(this).attr('style', 'color: #666');
        var id = $(this).attr('data-id');
        var store_id = $(this).attr('store-id');
        $('body').modalmanager('loading');
        $modal_setting.load('/ajax/getStoreDetail?id='+id+'&store_id='+store_id, '', function(){
            $modal_setting.modal().on("hidden", function() {
                $modal_setting.empty();
            });
        });
        return false;
    });
    
    $('.field_title .btn_remove').click(function(){
        var id = $(this).attr('data-id');
        var obj = $(this).parents('tr');
        obj.hide();
        $.ajax({type: "POST", url: "/news/deleteStore?id="+id, dataType: "html",success: function(msg){
            if(msg=='1') obj.remove();
            else {
                obj.show();
                alert('Có lỗi xảy ra.');
            }
        }});
        return false;
    });
    
});
</script>