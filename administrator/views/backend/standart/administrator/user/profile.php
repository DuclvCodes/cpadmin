<?php $mod = current_method()['mod']; ?>
<link href="<?=BASE_ASSET?>css/pages/profile.css" rel="stylesheet" type="text/css" />
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<?php getBlock('menu') ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN PAGE -->
	<div class="page-content">
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid">
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
						Thông tin tài khoản của tôi
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="#">Hồ sơ cá nhân</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Thông tin tài khoản</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid profile">
				
                <?php if (isset($msg)) {
    echo $msg;
} ?>
                <div class="row-fluid">
					<div class="span12">
						<div class="span3">
							<ul class="ver-inline-menu tabbable margin-bottom-10">
								<li class="<?php if ($tab_active==1) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_1-1"><i class="icon-cog"></i> Thông tin cá nhân</a><span class="after"></span></li>
								<li class="<?php if ($tab_active==2) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Thay đổi ảnh đại diện</a></li>
								<li class="<?php if ($tab_active==3) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Thay đổi mật khẩu</a></li>
								<!--<li class="<?php if ($tab_active==4) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_4-4"><i class="icon-eye-open"></i> Privacy Settings</a></li>-->
							</ul>
						</div>
						<div class="span9">
							<div class="tab-content">
								<div id="tab_1-1" class="tab-pane <?php if ($tab_active==1) {
    echo 'active';
} ?>">
									<div style="height: auto;" id="accordion1-1" class="accordion collapse">
										<form action="" method="post">
											
                                            <div class="controls-row">
                                                <div class="span6">
                                                    <label class="control-label" for="f_fullname">Họ tên</label>
                									<div class="controls">
                										<div class="input-icon left">
            												<i class="icon-user"></i>
                                                            <input name="fullname" type="text" id="f_fullname" class="m-wrap span12" placeholder="họ tên ..." value="<?php echo $fullname ?>" />
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
                                                <label class="control-label" for="f_google_plus">Thông tin tác giả (Google +)</label>
            									<div class="controls">
            										<div class="input-icon left">
        												<i class="icon-link"></i>
                                                        <input name="google_plus" type="text" id="f_google_plus" class="m-wrap span12" placeholder="" value="<?php echo $google_plus ?>" />
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
                                            
											<div class="submit-btn">
												<button class="btn green" type="submit">Cập nhật</button>
												<a href="#" class="btn">Hủy</a>
                                                <input type="hidden" name="action" value="info" />
											</div>
										</form>
									</div>
								</div>
								<div id="tab_2-2" class="tab-pane <?php if ($tab_active==2) {
    echo 'active';
} ?>">
									<div style="height: auto;" id="accordion2-2" class="accordion collapse">
										<form action="" method="post" enctype="multipart/form-data">
											<p>Đổi Avatar</p>
											<div class="space10"></div>
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="fileupload-new thumbnail">
													<img src="<?php echo $clsUser->getImage($user_id, 291, 170, 'image', '/files/User/noavatar.jpg'); ?>" alt="" />
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Select image</span>
													<span class="fileupload-exists">Change</span>
													<input type="file" class="default" name="image" /></span>
													<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="controls">
												<span class="label label-important">NOTE!</span>
												<span>Nếu chưa thay đổi, hãy nhấn Ctrl + R để xóa cache của trình duyệt</span>
											</div>
											<div class="space10"></div>
											<div class="submit-btn">
												<button class="btn green" type="submit">Save Changes</button>
												<a href="#" class="btn">Cancel</a>
                                                <input type="hidden" name="action" value="avatar" />
											</div>
										</form>
									</div>
								</div>
								<div id="tab_3-3" class="tab-pane <?php if ($tab_active==3) {
    echo 'active';
} ?>">
									<div style="height: auto;" id="accordion3-3" class="accordion collapse">
										<form action="" method="post">
											<label class="control-label">Current Password</label>
											<input name="current_password" type="password" class="m-wrap span8" />
											<label class="control-label">New Password</label>
											<input type="password" class="m-wrap span8" name="user_pass" />
											<label class="control-label">Re-type New Password</label>
											<input type="password" class="m-wrap span8" name="user_pass_mask" />
											<div class="submit-btn">
												<button type="submit" class="btn green">Change Password</button>
												<a href="#" class="btn">Cancel</a>
                                                <input type="hidden" name="action" value="changepass" />
											</div>
										</form>
									</div>
								</div>
								<div id="tab_4-4" class="tab-pane <?php if ($tab_active==4) {
    echo 'active';
} ?>">
									<div style="height: auto;" id="accordion4-4" class="accordion collapse">
										<form action="" method="post">
											<div class="profile-settings row-fluid">
												<div class="span9">
													<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..</p>
												</div>
												<div class="control-group span3">
													<div class="controls">
														<label class="radio"><input type="radio" name="optionsRadios1" value="option1" />Yes</label>
														<label class="radio"><input type="radio" name="optionsRadios1" value="option2" checked="checked" />No</label>  
													</div>
												</div>
											</div>
											<div class="space5"></div>
											<div class="submit-btn">
												<button disabled="disabled" class="btn green" type="submit">Save Changes</button>
												<a href="#" class="btn">Cancel</a>
                                                <input type="hidden" name="action" value="privacy" />
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!--end span9-->                                   
					</div>
				</div>
                
                
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER--> 
	</div>
	<!-- END PAGE -->    
</div>