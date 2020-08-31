<style>
.code {padding: 2px 4px; color: #d14; background-color: #f7f7f9; font-family: Monaco,Menlo,Consolas,"Courier New",monospace; font-size: 12px; border-radius: 3px !important; border: 1px solid #e1e1e8; max-width: 500px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="border-bottom: 1px solid #eee; padding-bottom: 5px;"><?=DOMAIN_NAME?> Widget Box</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial; text-align: center;">
                
                <form method="post" action="" class="form-horizontal" style="display: inline-block; text-align: left; margin-top: 25px;">
                    <div class="control-group">
						<label class="control-label">Kiểu Box</label>
						<div class="controls">
							<select name="widget" class="medium m-wrap">
                                <?php if ($widget) {
    foreach ($widget as $key=>$one) {
        ?>
								<option <?php if ($key==$_widget) {
            echo 'selected="selected"';
        } ?> value="<?=$key?>" data-width="<?=$one['width']?>" data-height="<?=$one['height']?>"><?=$one['title']?></option>
                                <?php
    }
} ?>
							</select>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">Nguồn giới thiệu</label>
						<div class="controls">
							<input name="campaign" value="<?=$_campaign?>" type="text" placeholder="VD: VnExpress, DanTri ..." class="m-wrap medium" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">Width (px)</label>
						<div class="controls">
							<input name="width" value="<?=$_width?>" type="text" placeholder="" class="m-wrap medium" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">Số Item</label>
						<div class="controls">
							<input name="rpp" value="<?=$_rpp?>" type="text" placeholder="" class="m-wrap medium" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">Hiển thị ảnh</label>
						<div class="controls">
							<select name="nophoto" class="medium m-wrap">
								<option <?php if (0==$_nophoto) {
    echo 'selected="selected"';
} ?> value="0">Có</option>
                                <option <?php if (1==$_nophoto) {
    echo 'selected="selected"';
} ?> value="1">Không</option>
							</select>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">IMG Width (px)</label>
						<div class="controls">
							<input name="iw" value="<?=$_iw?>" type="text" placeholder="" class="m-wrap medium" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">IMG Height (px)</label>
						<div class="controls">
							<input name="ih" value="<?=$_ih?>" type="text" placeholder="" class="m-wrap medium" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label"> </label>
						<div class="controls">
							<input type="submit" class="btn blue" value="Tạo code" />
						</div>
					</div>
                    
                    <div class="control-group">
						<label class="control-label">Mã code</label>
						<div class="controls">
							<div class="code"><?php echo htmlentities($html) ?></div>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">Xem thử</label>
						<div class="controls">
							<div id="wrap_preview"><?=$html?></div>
						</div>
					</div>
                    
                </form>
                
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>