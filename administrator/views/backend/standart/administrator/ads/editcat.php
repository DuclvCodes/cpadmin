<?php $mod = current_method()['mod']; ?>
<style>
.boxnews_tile {width: auto !important; height: inherit !important; float: none !important; margin-right: 0 !important; font-family: Arial; cursor: move; border: 0; position: relative; overflow: inherit;}
.boxnews_tile h3 {font-size: 13px; line-height: 20px !important;}
.boxnews_tile .tile-body {margin-bottom: 0 !important; padding: 5px;}
.boxnews_tile .btn_remove {position: absolute;top: 5px;right: 5px; display: none; opacity: 0.5; width: 45px; height: 45px !important;}
.boxnews_tile:hover .btn_remove {display: block;}
.boxnews_tile .btn_remove:hover {opacity: 1;}
.listAds li.sortable-placeholder{border:1px dashed #CCC; height: 50px; list-style: none; margin-bottom: 5px;}
.tile-body h3 a:hover {color: #FFF;}
</style>

<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_ads') ?>
            
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="margin-top: 0;">
						<?php echo $oneAds['title'] ?>
                        <a href="/ads/edit?id=<?=$oneAds['ads_id']?>" class="btn red pull-right"><i class="icon-arrow-left"></i> Quản lý <?php echo $oneAds['title'] ?></a>
					</h3>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
						<div class="row-fluid">
							<div class="span8">
                                <?php if (isset($msg)) {
    echo $msg;
} ?>
                                
                                
                                <div class="portlet box blue tabbable">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-stackexchange"></i>
                                            <span class="hidden-480">Mã quảng cáo</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="tabbable portlet-tabs">
                                            <ul class="nav nav-tabs">
                                                <li class=""><a href="#dropdown_3" data-toggle="tab">Chia sẻ 3</a></li>
                                                <li class=""><a href="#dropdown_2" data-toggle="tab">Chia sẻ 2</a></li>
                                                <li class="active"><a href="#dropdown_1" data-toggle="tab">Mặc định</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="dropdown_1">
                                                    
                                                    <div style="margin-bottom: 8px;">
                                                        <a href="#" data-name="code_path" class="btn red mini btn_add_ads"><i class="icon-plus"></i> Chèn thêm quảng cáo</a>
                                                        <a href="/code/add&area_id=<?=$_GET['id']?>&name=code_path" class="btn grey mini"><i class="icon-file"></i> Tạo quảng cáo mới</a>
                                                        <a href="#" data-name="code_path" class="btn green mini pull-right btn_preview"><i class="icon-legal"></i> Preview</a>
                                                    </div>
                                                    
                                                    <ul class="listAds" style="margin: 0;">
                                                        <?php if ($code_path) {
    foreach ($code_path as $code_id) {
        $oneCode = $clsCode->getOne($code_id); ?>
                                                        <li class="oneItem" draggable="true">
                                                            <div class="tile double bg-grey boxnews_tile" style="width: inherit !important;">
                                                        		<div class="tile-body">
                                                        			<h3><a href="/code/edit?id=<?=$code_id?>"><?=$oneCode['title']?></a></h3>
                                                                    <div>
                                                                        <span class="label label-success"><?=date('d/m/Y', strtotime($oneCode['todate']))?></span>
                                                                        <span class="badge badge-warning"><?=($oneCode['is_show']?((strtotime($oneCode['todate'].' 23:59:59')<time())?'HẾT HẠN':''):'ĐANG ẨN')?></span>
                                                                        <input type="hidden" name="code_path[]" value="<?=$code_id?>" />
                                                                    </div>
                                                        		</div>
                                                        		<button class="btn mini yellow btn_remove js"><i class="icon-remove"></i></button>
                                                        	</div>
                                                        </li>
                                                        <?php
    }
} ?>
                                                    </ul>
                                                    
                                                    
                                                </div>
                                                <div class="tab-pane" id="dropdown_2">
                                                    
                                                    
                                                    <div style="margin-bottom: 8px;">
                                                        <a href="#" data-name="code_path_2" class="btn red mini btn_add_ads"><i class="icon-plus"></i> Chèn thêm quảng cáo</a>
                                                        <a href="/code/add&ads_id=<?=$_GET['id']?>&name=code_path_2" class="btn grey mini"><i class="icon-file"></i> Tạo quảng cáo mới</a>
                                                        <a href="#" data-name="code_path_2" class="btn green mini pull-right btn_preview"><i class="icon-legal"></i> Preview</a>
                                                    </div>
                                                    
                                                    <ul class="listAds" style="margin: 0;">
                                                        <?php if ($code_path_2) {
    foreach ($code_path_2 as $code_id) {
        $oneCode = $clsCode->getOne($code_id); ?>
                                                        <li class="oneItem" draggable="true">
                                                            <div class="tile double bg-grey boxnews_tile" style="width: inherit !important;">
                                                        		<div class="tile-body">
                                                        			<h3><a href="/code/edit?id=<?=$code_id?>"><?=$oneCode['title']?></a></h3>
                                                                    <div>
                                                                        <span class="label label-success"><?=date('d/m/Y', strtotime($oneCode['todate']))?></span>
                                                                        <span class="badge badge-warning"><?=($oneCode['is_show']?((strtotime($oneCode['todate'].' 23:59:59')<time())?'HẾT HẠN':''):'ĐANG ẨN')?></span>
                                                                        <input type="hidden" name="code_path_2[]" value="<?=$code_id?>" />
                                                                    </div>
                                                        		</div>
                                                        		<button class="btn mini yellow btn_remove js"><i class="icon-remove"></i></button>
                                                        	</div>
                                                        </li>
                                                        <?php
    }
} ?>
                                                    </ul>
                                                    
                                                    
                                                </div>
                                                <div class="tab-pane" id="dropdown_3">
                                                    
                                                    <div style="margin-bottom: 8px;">
                                                        <a href="#" data-name="code_path_3" class="btn red mini btn_add_ads"><i class="icon-plus"></i> Chèn thêm quảng cáo</a>
                                                        <a href="/code/add&ads_id=<?=$_GET['id']?>&name=code_path_3" class="btn grey mini"><i class="icon-file"></i> Tạo quảng cáo mới</a>
                                                        <a href="#" data-name="code_path_3" class="btn green mini pull-right btn_preview"><i class="icon-legal"></i> Preview</a>
                                                    </div>
                                                    
                                                    <ul class="listAds" style="margin: 0;">
                                                        <?php if ($code_path_3) {
    foreach ($code_path_3 as $code_id) {
        $oneCode = $clsCode->getOne($code_id); ?>
                                                        <li class="oneItem" draggable="true">
                                                            <div class="tile double bg-grey boxnews_tile" style="width: inherit !important;">
                                                        		<div class="tile-body">
                                                        			<h3><a href="/code/edit?id=<?=$code_id?>"><?=$oneCode['title']?></a></h3>
                                                                    <div>
                                                                        <span class="label label-success"><?=date('d/m/Y', strtotime($oneCode['todate']))?></span>
                                                                        <span class="badge badge-warning"><?=($oneCode['is_show']?((strtotime($oneCode['todate'].' 23:59:59')<time())?'HẾT HẠN':''):'ĐANG ẨN')?></span>
                                                                        <input type="hidden" name="code_path_3[]" value="<?=$code_id?>" />
                                                                    </div>
                                                        		</div>
                                                        		<button class="btn mini yellow btn_remove js"><i class="icon-remove"></i></button>
                                                        	</div>
                                                        </li>
                                                        <?php
    }
} ?>
                                                    </ul>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-folder-close"></i> Chuyên mục</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<div class="controls" style="text-align: center;">
                                                <p style="color: #999; margin-left: 200px;">Chuyên mục được hiển thị (*)</p>
                                                <div style="display: inline-block; text-align: left;">
                                                    <select name="cat_path[]" class="multiSelect required" multiple="multiple">
                                                        <?php if ($allCat) {
    foreach ($allCat as $id) {
        ?>
                                                        <option <?=in_array($id, $cat_path)?'selected="selected"':''?> value="<?=$id?>"><?=$clsCategory->getTitle($id); ?></option>
                                                        <?php
    }
} ?>
                                                    </select>
                                                </div>
        									</div>
        								</div>                                                                                                                                                     
        							</div>
        						</div>
                                
                                
							</div>
							<!--/span-->
                            <div class="span4">
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Thông tin chung</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_show" value="0" />
            												<input name="is_show" value="1" type="checkbox" class="toggle" />
            											</div>
        											</td>
        											<td>Hiển thị/ Ẩn</td>
        										</tr>
        									</tbody>
        								</table>
                                        
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_width">Chiều rộng</label>
                									<div class="controls">
                										<input disabled="disabled" name="width" maxlength="4" placeholder="px" type="text" id="f_width" class="m-wrap span12" value="" />
                									</div>
                								</div>
                                            </div>
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_height">Chiều cao</label>
                									<div class="controls">
                										<input disabled="disabled" name="height" maxlength="3" placeholder="px" type="text" id="f_height" class="m-wrap span12" value="" />
                									</div>
                								</div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
        									<label class="control-label" for="f_intro">Ghi chú</label>
        									<div class="controls">
                                                <textarea name="intro" id="f_intro" class="m-wrap span12" rows="8" ></textarea>
        									</div>
        								</div>
                                        <?php if (isset($user_edit)) {
    ?>
                                        <div class="alert alert-info">
                                            <span class="help-block">Sửa bởi: <b><?php echo $clsUser->getLashname($user_edit) ?></b> lúc <b><?=date('H:i d/m/Y', $last_edit)?></b></span>
                                            <p><a href="#setting_sleep" class="open_div"><?=$share_sleep?'Chia sẻ nhấp nháy: '.$share_sleep.'s':'Cài đặt chia sẻ nhấp nháy'?></a></p>
                                            <div id="setting_sleep" class="control-group" style="display: none;">
                                                <label class="control-label help-block" for="f_share_sleep">Sleep-sharing (giây)</label>
            									<div class="controls">
            										<input style="background: #FFF;" name="share_sleep" maxlength="2" type="text" id="f_share_sleep" class="m-wrap span12" value="" />
            									</div>
                                                <span class="help-block">Nhập "0" để hủy chia sẻ</span>
            								</div>
                                        </div>
                                        <?php
} ?>
                                        <div class="controls controls-row">
                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" href="/ads/delcat?id=<?=$area_id?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                            <button type="submit" class="btn green pull-right"><i class="icon-save"></i> Cập nhật</button>
                                        </div>
                                        
        							</div>
        						</div>
							</div>
							
							<!--/span-->
						</div>
                        
					</form>
                    
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>

<div id="modal_box_ads" class="modal hide fade" data-width="640"></div>
<div id="modal_preview" class="modal hide fade" data-width="780"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('.open_div').click(function(){
        $($(this).attr('href')).show();
        $(this).parents('p').remove();
        return false;
    });
    function event_remove() {
        $('.btn_remove.js').removeClass('js').click(function(){
            $(this).parents('li').remove();
            $(this).parents('.listAds').sortable('destroy'); $(this).parents('.listAds').sortable();
            return false;
        });
    }
    event_remove();
    $('.listAds').sortable();
    
    var $modal_box_ads = $('#modal_box_ads');
    $('a.btn_add_ads').click(function(){
        var name = $(this).attr('data-name');
        var obj = $(this).parents('.tab-pane');
        $('body').modalmanager('loading');
        $modal_box_ads.load('/ajax/getListQc', '', function(){
            $('.btn_addcode').unbind().click(function(){
                var title = $(this).text();
                var id = $(this).attr('data-id');
                var todate = $(this).parents('tr').find('.f_todate').text();
                var note = $(this).parents('tr').find('.f_note').text();
                var html = '<li class="oneItem" draggable="true"><div class="tile double bg-grey boxnews_tile" style="width: inherit !important;"><div class="tile-body"><h3>'+title+'</h3><div><span class="label label-success">'+todate+'</span>'+note+'<input type="hidden" name="'+name+'[]" value="'+id+'" /></div></div><button class="btn mini yellow btn_remove js"><i class="icon-remove"></i></button></div></li>';
                obj.find('.listAds').append(html);
                obj.find('.listAds').sortable('destroy'); obj.find('.listAds').sortable();
                event_remove();
                return false;
            });
            $modal_box_ads.modal().on("hidden", function() {
                $modal_box_ads.empty();
            });
        });
        return false;
    });
    
    $modal_preview = $('#modal_preview');
    $('.btn_preview').click(function(){
        var name = $(this).attr('data-name');
        var obj = $(this).parents('.tab-pane');
        $('body').modalmanager('loading');
        $modal_preview.load('/ajax/getQcPreview&name='+name+'&area_id='+<?=$_GET['id']?>, '', function(){
            $modal_preview.modal().on("hidden", function() {
                $modal_preview.empty();
            });
        });
        return false;
    });
    
});
</script>