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
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Chỉnh sửa nhóm <small><?php echo $title ?></small>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Thêm mới <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Nhóm</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Chỉnh sửa</a></li>
					</ul>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
						<div class="row-fluid">
							<div class="span8">
                                <?php if ($msg) {
    echo $msg;
} ?>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-user"></i> Tiêu đề</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <div class="control-group">
        									<div class="controls">
        										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
        									</div>
        								</div>
                                        
        							</div>
        						</div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-user"></i> Module mặc định</div>
        							</div>
        							<div class="portlet-body" id="wrap_permission">
                                        
                                        <?php
                                        $permission = json_decode($permission);
                                        $listModeul = $clsUser->getModule(false);
                                        if ($listModeul) {
                                            foreach ($listModeul as $key=>$val) {
                                                ?>
                                            <label style="float: left; width: 50%;" for="permission<?php echo $key ?>"><input <?php if ($permission->{$key}==1) {
                                                    echo 'checked="checked"';
                                                } ?> id="permission<?php echo $key ?>" type="checkbox" name="permission[<?php echo $key ?>]" value="1" /> <?php echo $val ?></label>
                                        <?php
                                            }
                                        } ?>
                                        <div style="clear: both;"></div>
                                        
        							</div>
        						</div>
                                
							</div>
							<!--/span-->
                            <div class="span4">
                                <?php if ($is_trash==0) {
                                            ?>
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Cài đặt</div>
        							</div>
        							<div class="portlet-body">
                                        
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
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-user"></i> Cấp độ quyền</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <select name="level" class="m-wrap">
                                            <option <?php if ($level==4) {
                                            echo 'selected="selected"';
                                        } ?> value="0">Admin</option>
                                            <option <?php if ($level==3) {
                                            echo 'selected="selected"';
                                        } ?> value="3">Phóng viên / CTV</option>
                                            <option <?php if ($level==2) {
                                            echo 'selected="selected"';
                                        } ?> value="2">Trưởng ban</option>
                                            <option <?php if ($level==1) {
                                            echo 'selected="selected"';
                                        } ?> value="1">Thư ký</option>
                                        </select>
                                        
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