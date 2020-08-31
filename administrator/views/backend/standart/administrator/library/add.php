<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">Thêm mới</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Thư viện <?=DOMAIN_NAME?></a>
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
							<div class="span12">
                                <?php if ($msg) {
    echo $msg;
} ?>
                                <div style="max-width: 650px;">
    								<div class="control-group">
                                        <div class="span4">
                                            <label class="control-label" for="f_title">Tờ Báo</label>
        									<div class="controls">
        										<select name="category_id" class="m-wrap span12">
                                                    <?php $allCate = $clsClassTable->getAllCate(); if ($allCate) {
    foreach ($allCate as $key=>$oneCate) {
        ?>
                                                    <option value="<?=$key?>"><?=$oneCate?></option>
                                                    <?php
    }
} ?>
                                                </select>
        									</div>
                                        </div>
                                        <div class="span2">
                                            <label class="control-label" for="f_title">Số báo</label>
        									<div class="controls">
        										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $num ?>" />
        									</div>
                                        </div>
                                        <div class="span2">
                                            <label class="control-label" for="f_num_page">Số trang</label>
        									<div class="controls">
        										<input name="num_page" type="text" id="f_num_page" class="m-wrap span12" value="" placeholder="" />
        									</div>
                                        </div>
                                        <div class="clearfix"></div>
    								</div>
                                    <button type="submit" class="btn green"><i class="icon-signin"></i> Tiếp tục</button>
                                </div>
                                
							</div>
							<!--/span-->
						</div>
                        <input type="hidden" name="is_draf" value="1" />
					</form>
                    
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>