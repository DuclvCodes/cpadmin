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
                                
                                <div class="span6" style="margin-left: 0;">
                                    <div class="control-group">
    									<label class="control-label" for="f_title">Tiêu đề</label>
    									<div class="controls">
    										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
    									</div>
    								</div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
        								<label class="control-label" for="f_title">Danh mục cha</label>
        								<div class="controls" style="display: inline-block; width: 100%;">
                                            <?php echo $clsCategory->getSelect('parent_id', $parent_id, 'span12', false, ' --- Danh mục gốc --- ') ?>
        								</div>
        							</div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="span6" style="margin-left: 0;">
                                    <div class="control-group">
                                        <label class="control-label" for="f_title">Cho phép hiển thị trên <?=DOMAIN_NAME?></label>
                                        <div class="toggle_button">
                                            <input type="hidden" name="mainsite" value="0" />
                                            <input name="mainsite" value="1" type="checkbox" class="toggle" <?php if ($mainsite) {
    echo 'checked="checked"';
} ?> />
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="portlet box blue" style="margin-top: 18px;">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-globe"></i> SEO</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_menu">Menu</label>
        									<div class="controls">
        										<input name="menu" type="text" id="f_menu" class="m-wrap span12" placeholder="nội dung trên menu" value="<?php echo $menu ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_title">Title</label>
        									<div class="controls">
        										<input name="meta_title" type="text" id="f_meta_title" class="m-wrap span12" placeholder="nội dung thẻ <title>" value="<?php echo $meta_title ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_slug">Slug</label>
        									<div class="controls">
        										<input name="slug" type="text" id="f_slug" class="m-wrap span12" placeholder="slug hiển thị trên thanh địa chỉ URL ..." value="<?php echo $slug ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_keyword">Meta Keywords</label>
        									<div class="controls">
                                                <textarea name="meta_keyword" id="f_meta_keyword" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta keywords" ><?php echo $meta_keyword ?></textarea>
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Meta Description</label>
        									<div class="controls">
                                                <textarea name="meta_description" id="f_meta_description" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta description" ><?php echo $meta_description ?></textarea>
        									</div>
        								</div>
        							</div>
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
                    
                    <?php if (!$parent_id) {
        ?>
                    <p class="hide_show">+ <a href="#frm_permistion">Phân quyền cho phóng viên chuyên mục này?</a></p>
                    <style>
                    #frm_permistion .oneUser {width: 200px; float: left;}
                    </style>
                    <form id="frm_permistion" style="display: none;" action="" method="post" enctype="multipart/form-data" class="horizontal-form">
                        <div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">Phân quyền</div>
                                <div class="tools" style="margin-top: 0;">
    								<a id="btn_all_per" href="#" class="btn mini" style="height: 15px;">All</a>
    							</div>
							</div>
							<div class="portlet-body">
                                <div class="controls controls-row">
                                    <?php if ($allUser) {
            foreach ($allUser as $user_id) {
                ?>
                                    <label class="oneUser">
                                        <input <?php if ($clsUser->getPermissCat($user_id, $category_id)) {
                    echo 'checked="checked"';
                } ?> type="checkbox" name="per[<?=$user_id?>]" value="1" /> 
                                        <?=$clsUser->getFullName($user_id)?>
                                    </label>
                                    <?php
            }
        } ?>
                                    <div style="clear: both;"></div>
                                </div>
                                <div style="text-align: center; margin-top: 21px;">
                                    <button class="btn blue" type="submit">Cập nhật</button>
                                </div>
							</div>
						</div>
                        <input type="hidden" name="action" value="permission" />
                    </form>
                    <br />
                    <?php
    } ?>
                    
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
        $('.hide_show a').click(function(){
            $($(this).attr('href')).show();
            $(this).parents('p').remove();
            return false;
        });
        $('#btn_all_per').click(function(){
            $('#frm_permistion').find('input:checkbox').each(function(){
                if($(this).prop('checked')) $(this).click();
            });
            $('#frm_permistion').find('input:checkbox').click();
            return false;
        });
    });
</script>