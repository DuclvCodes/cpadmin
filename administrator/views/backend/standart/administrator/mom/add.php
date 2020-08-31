<style>
.btn_trash {line-height: 16px; margin-top: 7px; text-decoration: none; border-bottom: 1px solid #d84a38; color: #d84a38; display: inline-block; font-size: 12px; padding: 0 3px;}
.btn_trash:hover {background: #d84a38; color: #FFF !important;}
.tbl_vertical_center td {vertical-align: middle !important;}
#form_default label.lv2 {margin-left: 20px;}
div.tagsinput {height: auto !important;margin: 0 !important;padding: 5px !important;overflow: auto !important;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_mom') ?>
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="margin-top: 0;">
						Gửi thông báo
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Gửi thông báo</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Soạn</a></li>
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
                                    <label class="control-label" for="f_title">Chủ đề</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $title ?>" />
									</div>
								</div>
                                <div class="control-group">
									<label class="control-label" for="f_content">Nội dung</label>
									<div class="controls">
										<textarea name="content" id="f_content" class="tinymce m-wrap span12" rows="3"><?php echo $content ?></textarea>
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
                                        <div class="control-group">
                                            <label class="control-label" for="f_tags">Danh sách nhóm</label>
        									<div class="controls" style="display: inline-block; width: 100%;">
        										<select name="email_path[]" class="m-wrap span12 chosen required" multiple="multiple">
                                                    <?php if ($allEmail) {
    foreach ($allEmail as $email_id) {
        ?>
                                                    <option value="<?=$email_id?>"><?=$clsEmail->getTitle($email_id)?></option>
                                                    <?php
    }
} ?>
                                                </select>
        									</div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_tags">Danh sách cá nhân</label>
        									<div class="controls" style="display: inline-block; width: 100%;">
        										<select name="email_path[]" class="m-wrap span12 chosen" multiple="multiple">
                                                    <?php if ($allEmail) {
    foreach ($allEmail as $email_id) {
        ?>
                                                    <optgroup label="<?=$clsEmail->getTitle($email_id)?>">
                                                        <?php
                                                        $all = $clsEmail->getChild($email_id);
        if ($all) {
            foreach ($all as $email_id) {
                ?>
                                                        <option value="<?=$email_id?>"><?=$clsEmail->getTitle($email_id)?></option>
                                                        <?php
            }
        } ?>
                                                    </optgroup>
                                                    <?php
    }
} ?>
                                                </select>
        									</div>
                                        </div>
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Gửi</button>
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
<link rel="stylesheet" type="text/css" href="/plugins/jquery-tags-input/jquery.tagsinput.css" />
<script type="text/javascript" src="<?=BASE_ASSET?>/plugins/jquery-tags-input/jquery.tagsinput.min.js" ></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".chosen").each(function () {
        $(this).chosen({
            allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
        });
    });
});
</script>