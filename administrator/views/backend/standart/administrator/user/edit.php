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
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Sửa hồ sơ nhân sự <?php echo $fullname ?>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Thêm nhân sự <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Quản lý nhân sự</a>
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
                                <?php if (isset($msg)) {
    echo $msg;
} ?>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-user"></i> Thông tin tài khoản</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <div class="controls-row control-group">
                                            <div class="span6">
                                                <label class="control-label" for="f_username">Tên đăng nhập</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-ok"></i>
                                                        <input disabled="disabled" name="username" type="text" id="f_username" class="m-wrap span12 required" placeholder="tên đăng nhập ..." value="<?php echo $username ?>" />    
        											</div>
            									</div>
                                            </div>
                                            <div class="span6">
                                                <label class="control-label" for="f_password">Mật khẩu</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-key"></i>
                                                        <input name="password" type="text" id="f_password" class="m-wrap span12" placeholder="cập nhật lại mật khẩu ..." value="" />    
        											</div>
            									</div>
                                            </div>
        								</div>
                                        <div class="controls-row">
                                            <div class="span6 control-group">
                                                <label class="control-label" for="f_email">Email</label>
            									<div class="controls">
                                                    <div class="input-icon left">
        												<i class="icon-envelope"></i>
                                                        <input name="email" type="text" id="f_email" class="m-wrap span12 required" placeholder="email ..." value="<?php echo $email ?>" />
                                                    </div>
            									</div>
                                            </div>
                                            <div class="span6">
                                                <label class="control-label" for="f_level">Nhóm thành viên</label>
            									<div class="controls">
                                                    <?php echo $clsGroup->getSelect('group_id', $group_id, 'm-wrap span12') ?>
            									</div>
                                            </div>
        								</div>
                                                                                                                                                                                               
        							</div>
        						</div>
                                
                                <div class="portlet box yellow">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-edit"></i> Thông tin cá nhân</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <div class="controls-row">
                                            <div class="span6 control-group">
                                                <label class="control-label" for="f_fullname">Họ tên</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-user"></i>
                                                        <input name="fullname" type="text" id="f_fullname" class="m-wrap span12 required" placeholder="họ tên ..." value="<?php echo $fullname ?>" />
                                                    </div>
            									</div>
                                            </div>
                                            <div class="span6">
                                                <label class="control-label" for="f_birthday">Ngày sinh</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-table"></i>
                                                        <input name="birthday" type="text" id="f_birthday" class="datepicker m-wrap span12" placeholder="ngày sinh ..." value="<?php echo db2datepicker($birthday, false) ?>" />
                                                    </div>
            									</div>
                                            </div>
        								</div>
                                        
                                        <div class="controls-row">
                                            <div class="span6">
                                                <label class="control-label" for="f_skype">Skype</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-skype"></i>
                                                        <input name="skype" type="text" id="f_skype" class="m-wrap span12" placeholder="skype ..." value="<?php echo $skype ?>" />
                                                    </div>
            									</div>
                                            </div>
                                            <div class="span6">
                                                <label class="control-label" for="f_hotline">Số điện thoại</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-apple"></i>
                                                        <input name="hotline" type="text" id="f_hotline" class="m-wrap span12" placeholder="số điện thoại ..." value="<?php echo $hotline ?>" />
                                                    </div>
            									</div>
                                            </div>
        								</div>
                                        
                                        <div class="controls-row">
                                            <label class="control-label" for="f_occupation">Nghề nghiệp</label>
        									<div class="controls">
        										<div class="input-icon left">
    												<i class="icon-bookmark"></i>
                                                    <input name="occupation" type="text" id="f_occupation" class="m-wrap span12" placeholder="" value="<?php echo $occupation ?>" />
                                                </div>
        									</div>
        								</div>
                                        
                                        <div class="controls-row">
                                            <label class="control-label" for="f_website">Website</label>
        									<div class="controls">
        										<div class="input-icon left">
    												<i class="icon-link"></i>
                                                    <input name="website" type="text" id="f_website" class="m-wrap span12" placeholder="http://facebook.com/username" value="<?php echo $website ?>" />
                                                </div>
        									</div>
        								</div>
                                        
                                        <div class="controls-row">
                                            <label class="control-label" for="f_about">Về bản thân</label>
        									<div class="controls">
        										<textarea style="height: 364px;" class="span12 m-wrap" name="about" id="f_about" placeholder="anything ..." ><?php echo $about ?></textarea>
        									</div>
        								</div>
                                        <?php if ($me['user_id']==1 or $me['user_id'] == 297) {
    ?>
                                        <p><a href="/user/edit?id=<?=$user_id?>&login"><i class="icon-signin"></i> Đăng nhập với tài khoản <b><?=$fullname?></b></a></p>
                                        <?php
} ?>
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
                                        <table class="table table-bordered table-striped" id="tbl_is_push">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_push" value="0" />
            												<input name="is_push" value="1" type="checkbox" class="toggle" <?php if ($is_push) {
            echo 'checked="checked"';
        } ?> />
            											</div>
        											</td>
        											<td>Quyền xuất bản</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_unpush" value="0" />
            												<input name="is_unpush" value="1" type="checkbox" class="toggle" <?php if ($is_unpush) {
            echo 'checked="checked"';
        } ?> />
            											</div>
        											</td>
        											<td>Quyền gỡ bài</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_token" value="0" />
            												<input name="is_token" value="1" type="checkbox" class="toggle" <?php if ($is_token) {
            echo 'checked="checked"';
        } ?> />
            											</div>
        											</td>
        											<td>Thêm bảo mật khi đăng nhập</td>
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
                                
                                <div class="portlet box blue" id="portlet_category">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-picture"></i> Danh mục được quản lý</div>
                                        <div class="tools">
        									<a href="#" class="btn_all_category">All</a>
        								</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="controls" style="height: 200px;overflow: auto;border: 1px solid #ccc;padding: 8px;">
    										<?php echo $html_category_path ?>
    									</div>
        							</div>
        						</div>
                                
                                <div class="portlet box blue" id="portlet_permission">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-user"></i> Phân quyền</div>
        							</div>
        							<div class="portlet-body" id="wrap_permission">
                                        
                                        <?php
                                        $permission = json_decode($permission);
                                        $listModeul = $clsClassTable->getModule(false);
                                        if ($listModeul) {
                                            foreach ($listModeul as $key=>$val) {
                                                ?>
                                            <label style="float: left; width: 50%;" for="permission<?php echo $key ?>"><input <?php if (isset($permission->{$key}) and $permission->{$key}==1) {
                                                    echo 'checked="checked"';
                                                } ?> id="permission<?php echo $key ?>" type="checkbox" name="permission[<?php echo $key ?>]" value="1" /> <?php echo $val ?></label>
                                        <?php
                                            }
                                        } ?>
                                        <div style="clear: both;"></div>
                                        
        							</div>
        						</div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-picture"></i> Ảnh đại diện</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="fileupload-new thumbnail">
													<img src="<?php if ($image) {
                                            echo MEDIA_DOMAIN.$image;
                                        } else {
                                            echo BASE_ASSET.'images/no-photo.jpg';
                                        } ?>" alt="" />
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Tải lên</span>
													<span class="fileupload-exists">Thay đổi</span>
													<input type="file" class="default" name="image" /></span>
													<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
												</div>
											</div>
											
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
<script type="text/javascript">
$(document).ready(function(){
    $('select[name=group_id]').change(function(){
        var val = $(this).val();
        var e = $('select[name=group_id] option[value='+val+']');
        var level = e.data('level');
        var permission = e.data('permission');
        //if(level<=3) $('#portlet_category').show();
        //else $('#portlet_category').hide();
        //if(level==2) $('#tbl_is_push').show();
        //else $('#tbl_is_push').hide();
        $('#portlet_permission input:checkbox').each(function(){
            if($(this).prop('checked')) $(this).click();
        });
        $.each(permission, function (i, fb) {
            $('#permission'+i).click();
        });
    });
    setTimeout(function(){
        var val = $('select[name=group_id]').val();
        var e = $('select[name=group_id] option[value='+val+']');
        var level = e.data('level');
        var permission = e.data('permission');
        if(level<=3) $('#portlet_category').show();
        else $('#portlet_category').hide();
        //if(level==2) $('#tbl_is_push').show();
        //else $('#tbl_is_push').hide();
    }, 500);
    $('.btn_all_category').click(function(){
        $(this).parents('.portlet.box').find('input:checkbox').each(function(){
            if($(this).prop('checked')) $(this).click();
        });
        $(this).parents('.portlet.box').find('input:checkbox').click();
        return false;
    });
});
</script>