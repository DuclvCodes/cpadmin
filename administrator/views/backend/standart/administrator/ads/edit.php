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
.w100p {width: 100%; text-align: left;}
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
						<?php echo $title ?>
                        <?php if ($me['user_id']==1) {
    ?><a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a><?php
} ?>
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
                                                        <a href="/code/add?ads_id=<?=$_GET['id']?>&name=code_path" class="btn grey mini"><i class="icon-file"></i> Tạo quảng cáo mới</a>
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
                                
                                <div class="alert alert-block alert-info fade in">
									<h4 class="alert-heading">Chú ý!</h4>
									<p>
										Ngoài hiển thị quảng cáo theo mặc định, bạn có thể cài đặt hiển thị quảng cáo tùy chỉnh theo từng chuyên mục.  
										Nhấn vào nút dưới đây để bắt đầu cấu hình tùy chỉnh.
									</p>
                                    <br />
                                    <?php if ($allArea) {
        ?>
                                        <div style="display: inline-block;">
                                            <p><a class="btn black w100p" href="/ads/addcat?id=<?=$_GET['id']?>"><i class="icon-plus"></i> Thêm cấu hình</a></p>
                                            <?php foreach ($allArea as $area_id) {
            $oneArea = $clsArea->getOne($area_id);
            if ($oneArea['title']) {
                ?>
                                            <p><a class="btn <?=$oneArea['is_show']?'blue':'grey'?> w100p" href="/ads/editcat?id=<?=$area_id?>"><i class="icon-folder-close"></i> <?=$oneArea['title']?><?=$oneArea['is_show']?'':' (đang ẩn)'?></a></p>
                                            <?php
            }
        } ?>
                                        </div>
                                    <?php
    } else {
        ?>
									   <p><a class="btn black" href="/ads/addcat?id=<?=$_GET['id']?>"><i class="icon-plus"></i> Bắt đầu cấu hình</a></p>
                                    <?php
    } ?>
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
            												<input name="is_show" value="1" type="checkbox" class="toggle" <?php if ($is_show) {
        echo 'checked="checked"';
    } ?> />
            											</div>
        											</td>
        											<td>Hiển thị/ Ẩn</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_horizontal" value="0" />
            												<input name="is_horizontal" value="1" type="checkbox" class="toggle" <?php if ($is_horizontal) {
        echo 'checked="checked"';
    } ?> />
            											</div>
        											</td>
        											<td>Chia sẻ ngang</td>
        										</tr>
        									</tbody>
        								</table>
                                        <div class="control-group">
                                            <label class="control-label" for="f_title">Tên vị trí</label>
        									<div class="controls">
        										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $title ?>" />
        									</div>
        								</div>
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_width">Chiều rộng</label>
                									<div class="controls">
                										<input name="width" maxlength="4" placeholder="px" type="text" id="f_width" class="m-wrap span12" value="<?php echo $width ?>" />
                									</div>
                								</div>
                                            </div>
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_height">Chiều cao</label>
                									<div class="controls">
                										<input name="height" maxlength="3" placeholder="px" type="text" id="f_height" class="m-wrap span12" value="<?php echo $height ?>" />
                									</div>
                								</div>
                                            </div>
                                        </div>
                                        
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_margin_top">Căn lề trên</label>
                									<div class="controls">
                										<input name="margin_top" maxlength="3" placeholder="px" type="text" id="f_margin_top" class="m-wrap span12" value="<?php echo $margin_top ?>" />
                									</div>
                								</div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_margin_bottom">Căn lề dưới</label>
                									<div class="controls">
                										<input name="margin_bottom" maxlength="3" placeholder="px" type="text" id="f_margin_bottom" class="m-wrap span12" value="<?php echo $margin_bottom ?>" />
                									</div>
                								</div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_light_height">Độ giãn</label>
                									<div class="controls">
                										<input name="light_height" maxlength="3" placeholder="px" type="text" id="f_light_height" class="m-wrap span12" value="<?php echo $light_height ?>" />
                									</div>
                								</div>
                                            </div>
                                        </div>
                                        <div class="alert alert-info">
                                            <span class="help-block">Sửa bởi: <b><?php echo $clsUser->getLashname($user_edit) ?></b> lúc <b><?=date('H:i d/m/Y', $last_edit)?></b></span>
                                            <p class="help-block">Mã nhúng: <code><?php echo htmlspecialchars('<?php echo $ads['.$ads_id.']; ?>') ?></code></p>
                                            <p><a href="#setting_sleep" class="open_div"><?=$share_sleep?'Chia sẻ nhấp nháy: '.$share_sleep.'s':'Cài đặt chia sẻ nhấp nháy'?></a></p>
                                            <div id="setting_sleep" class="control-group" style="display: none;">
                                                <label class="control-label help-block" for="f_share_sleep">Sleep-sharing (giây)</label>
            									<div class="controls">
            										<input style="background: #FFF;" name="share_sleep" maxlength="2" type="text" id="f_share_sleep" class="m-wrap span12" value="<?php echo $share_sleep ?>" />
            									</div>
                                                <span class="help-block">Nhập "0" để hủy chia sẻ</span>
            								</div>
                                        </div>
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-save"></i> Cập nhật</button>
                                        </div>
        							</div>
        						</div>
                                <?php if ($intro) {
        ?>
                                <div class="control-group">
									<label class="control-label" for="f_intro">Ghi chú</label>
									<div class="controls">
                                        <textarea maxlength="255" name="intro" id="f_intro" class="m-wrap span12" rows="8" ><?php echo $intro ?></textarea>
									</div>
								</div>
                                <?php
    } else {
        ?>
                                <p>+ <a href="#field_intro" class="open_div">Thêm ghi chú</a></p>
                                <div class="control-group" id="field_intro" style="display: none;">
									<label class="control-label" for="f_intro">Ghi chú</label>
									<div class="controls">
                                        <textarea maxlength="255" name="intro" id="f_intro" class="m-wrap span12" rows="8" ><?php echo $intro ?></textarea>
									</div>
								</div>
                                <?php
    } ?>
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
<div id="modal_preview" class="modal hide fade" data-width="<?=$is_horizontal?($width?($width+30+$margin_top+$margin_bottom):640):($width?($width+30):640)?>"></div>
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
        $modal_preview.load('/ajax/getQcPreview?name='+name+'&ads_id='+<?=$_GET['id']?>, '', function(){
            $modal_preview.modal().on("hidden", function() {
                $modal_preview.empty();
            });
        });
        return false;
    });
    
});
</script>