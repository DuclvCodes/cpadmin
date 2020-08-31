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
						Thêm nhân sự
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
						<li><a href="#">Thêm mới</a></li>
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
                                        
                                        <div class="controls-row">
                                            <div class="span6 control-group">
                                                <label class="control-label" for="f_fullname">Họ tên</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-user"></i>
                                                        <input name="fullname" type="text" id="f_fullname" class="m-wrap span12 required" placeholder="họ tên ..." value="" />
                                                    </div>
            									</div>
                                            </div>
                                            <div class="span6 control-group" style="margin-bottom: 0;">
                                                <label class="control-label" for="f_username">Tên đăng nhập</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-ok" id="ico_username"></i>
                                                        <input name="username" type="text" id="f_username" class="m-wrap span12 required" placeholder="tên đăng nhập ..." value="" />    
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
                                                        <input name="email" type="text" id="f_email" class="m-wrap span12 required" placeholder="email ..." value="" />
                                                    </div>
            									</div>
                                            </div>
                                            <div class="span6 control-group">
                                                <label class="control-label" for="f_level">Nhóm thành viên</label>
            									<div class="controls">
                                                    <?php echo $clsGroup->getSelect('group_id', 0, 'm-wrap span12 required') ?>
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
        								<div class="caption"><i class="icon-share"></i> Cài đặt</div>
        							</div>
        							<div class="portlet-body">
                                        <table class="table table-bordered table-striped" id="tbl_is_push">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_push" value="0" />
            												<input name="is_push" value="1" type="checkbox" class="toggle"  />
            											</div>
        											</td>
        											<td>Quyền xuất bản</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_unpush" value="0" />
            												<input name="is_unpush" value="1" type="checkbox" class="toggle"  />
            											</div>
        											</td>
        											<td>Quyền gỡ bài</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_token" value="0" />
            												<input name="is_token" value="1" type="checkbox" class="toggle" />
            											</div>
        											</td>
        											<td>Thêm bảo mật khi đăng nhập</td>
        										</tr>
        									</tbody>
        								</table>
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
                                        </div>                                                                                                                                                       
        							</div>
        						</div>
                                
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
                                        if (isset($permission)) {
                                            $permission = json_decode($permission);
                                        }
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
<style>#ico_username.blue {color: #35aa47 !important;}</style>
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=username]').blur(function(){
        var val = $(this).val();
        if(val) {
            $(this).addClass('spinner').attr('disabled', 'disabled');
            var _this = $(this);
            $.ajax({type: "POST", url: "/api/validateUsername", data: {username: val}, dataType: "html",success: function(msg){
                _this.removeClass('spinner').removeAttr('disabled');
                if(msg=='1') $('#ico_username').addClass('blue');
                else _this.val('').parents('.control-group').addClass('error');
            }});
        }
    }).focus(function(){
        var _this = $(this);
        $('#ico_username').removeClass('blue');
        _this.parents('.control-group').removeClass('error');
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('select[name=group_id]').change(function(){
        var val = $(this).val();
        var e = $('select[name=group_id] option[value='+val+']');
        var level = e.data('level');
        var permission = e.data('permission');
        if(level<=3) $('#portlet_category').show();
        else $('#portlet_category').hide();
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
        $('select[name=group_id]').change();
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