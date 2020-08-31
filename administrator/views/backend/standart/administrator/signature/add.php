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
						Add <?php echo $classTable ?> <small>module manager</small>
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
						<li><a href="#">Add</a></li>
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
                                
								<div class="control-group">
                                    <label class="control-label" for="f_title">Bút danh</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
									</div>
								</div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="f_title">Thành viên</label>
									<div class="controls">
										<?php echo $clsUser->getSelect('user_id', $user_id, 'm-wrap span12 required') ?>
									</div>
								</div>
                                
							</div>
							<!--/span-->
							<div class="span4">
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Push Layouts</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
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