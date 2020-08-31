<?php $mod = current_method()['mod']; ?>
<style>
.btn_trash {line-height: 16px; margin-top: 7px; text-decoration: none; border-bottom: 1px solid #d84a38; color: #d84a38; display: inline-block; font-size: 12px; padding: 0 3px;}
.btn_trash:hover {background: #d84a38; color: #FFF !important;}
.tbl_vertical_center td {vertical-align: middle !important;}
#form_default label.lv2 {margin-left: 20px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_setting') ?>
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Edit <?php echo $classTable ?> <small>module manager</small>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Add New <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Dashboard</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>"><?php echo $classTable ?></a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Edit</a></li>
					</ul>
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
                                
								<div class="control-group">
									<div class="span6">
                                        <label class="control-label" for="f_title">Title</label>
    									<div class="controls">
    										<input disabled="disabled" name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
    									</div>
                                    </div>
                                    <div class="span6">
                                        <label class="control-label" for="f_title_show">Tiêu đề hiển thị ngoài giao diện</label>
    									<div class="controls">
    										<input name="title_show" type="text" id="f_title_show" class="m-wrap span12" value="<?php echo $title_show ?>" />
    									</div>
                                    </div>
                                    <div style="clear: both;"></div>
								</div>
                                <div class="control-group">
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_slug">Box Name</label>
        									<div class="controls">
        										<input disabled="disabled" name="slug" type="text" id="f_slug" class="m-wrap span12" placeholder="box name ..." value="<?php echo $slug ?>" />
        									</div>
        								</div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
            								<label class="control-label" for="f_title">Danh mục</label>
            								<div class="controls" style="display: inline-block; width: 100%;">
                                                <?php echo $clsCategory->getSelect('category_id', $category_id, 'm-wrap span12" disabled="disabled', false, ' --- Home --- ') ?>
            								</div>
            							</div>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                                <div class="control-group">
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_count_item">Số lượng tin trang chủ</label>
        									<div class="controls">
        										<input <?=($me['level']==0)?'':'disabled="disabled"'?> name="count_item" type="text" id="f_count_item" class="m-wrap span12" placeholder="Số lượng tin ..." value="<?php echo $count_item ?>" maxlength="2" />
        									</div>
        								</div>
                                    </div>
                                    
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_count_item_2">Số lượng tin trang chuyên mục</label>
        									<div class="controls">
        										<input <?=($me['level']==0)?'':'disabled="disabled"'?> name="count_item_2" type="text" id="f_count_item_2" class="m-wrap span12" placeholder="Số lượng tin ..." value="<?php echo $count_item_2 ?>" maxlength="2" />
        									</div>
        								</div>
                                    </div>
                                    
                                    <div style="clear: both;"></div>
                                </div>
							</div>
							<!--/span-->
                            <div class="span4">
                                <?php if ($is_trash==0) {
    ?>
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Push Layouts</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_lock" value="0" />
            												<input name="is_lock" value="1" type="checkbox" class="toggle" <?php if ($is_lock) {
        echo 'checked="checked"';
    } ?> />
            											</div>
        											</td>
        											<td>
        												Lock Item
        											</td>
        										</tr>
        									</tbody>
        								</table>
                                        
                                        <div class="controls controls-row">
                                            <a href="/<?php echo $mod ?>/trash?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Bỏ vào thùng rác</a>
                                            <button type="submit" class="btn green pull-right"><i class="icon-save"></i> Cập nhật</button>
                                        </div>                                                                                                                                                     
        							</div>
        						</div>
                                <?php
} else {
        ?>
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-trash"></i> Thùng rác</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="controls controls-row">
                                            <a href="/<?php echo $mod ?>/delete?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                            <a href="/<?php echo $mod ?>/restore?id=<?php echo $_GET['id'] ?>" class="btn green pull-right"><i class="icon-undo"></i> Phục hồi</a>
                                        </div>                                                                                                                                                     
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