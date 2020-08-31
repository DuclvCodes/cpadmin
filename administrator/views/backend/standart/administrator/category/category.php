<?php $mod = current_method()['mod']; ?>
<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_setting') ?>
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="margin-top: 0;">
						Quản lý chuyên mục
                        <?php if ($_GET['is_trash']==1) {
    ?>
                            <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-reorder"></i> Danh sách</a>
                        <?php
} else {
        ?>
                            <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
                            <a href="/<?php echo $mod ?>?is_trash=1" class="btn pull-right"><i class="icon-trash"></i> Thùng rác</a>
                        <?php
    } ?>
                        <div class="clearfix"></div>
					</h3>
					
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    
                    <form action="" method="post">
                    <?php if ($listItem) {
        ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="sorting">Tiêu đề</th>
                                <th class="sorting">Order</th>
                                <th class="sorting" style="width:23px;">ID</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                                foreach ($listItem as $category_id) {
                                    $oneItem = $clsClassTable->getOne($category_id);
                                    if ($oneItem['is_trash']) {
                                        $allChild = null;
                                    } else {
                                        $allChild = $clsClassTable->getChild($category_id);
                                    } ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <a class="btn_cat" data-id="<?php echo $category_id ?>" href="#" title=""><img src="<?php echo BASE_ASSET ?>images/folder.png" width="25" height="25" style="margin-right: 8px;" /></a>
                                        <a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a>
                                    </div>
                                </td>
                                <td><input name="order_no[<?php echo $oneItem[$pkeyTable] ?>]" type="text" class="text number" value="<?php echo $oneItem['order_no'] ?>" maxlength="2" style="width: 25px; text-align: center; margin: 0; padding: 0;" autocomplete="OFF" /></td>
                                <td class="filed_id"><?php echo $oneItem[$pkeyTable] ?></td>
							</tr>
                            <?php if ($allChild) {
                                        foreach ($allChild as $child_id) {
                                            $oneItem=$clsClassTable->getOne($child_id); ?>
                            <tr class="odd gradeX hide cat_<?php echo $category_id ?>">
								<td>
                                    <div class="field_title" style="padding-left: 24px;border-left: 1px solid #bababa;margin-left: 12px;">
                                        <a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a>
                                    </div>
                                </td>
                                <td><input name="order_no[<?php echo $oneItem[$pkeyTable] ?>]" type="text" class="text number" value="<?php echo $oneItem['order_no'] ?>" maxlength="2" style="width: 25px; text-align: center; margin: 0; padding: 0;" autocomplete="OFF" /></td>
                                <td class="filed_id"><?php echo $oneItem[$pkeyTable] ?></td>
							</tr>
                            <?php
                                        }
                                    } ?>
                            <?php
                                } ?>
                            <tr>
                                <td></td>
                                <td><button type="submit" class="btn green">Cập nhật</button></td>
                                <td></td>
                            </tr>
						</tbody>
					</table>
                    <?php
    } else {
        echo '<p>Không có bản ghi nào!</p>';
    } ?>
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
    $('.btn_cat').each(function(){
        var is_open = 0;
        var id = $(this).data('id');
        $(this).click(function(){
            if(is_open==0) {
                $('.cat_'+id).removeClass('hide');
                is_open = 1;
            }
            else {
                $('.cat_'+id).addClass('hide');
                is_open = 0;
            }
            return false;
        });
    });
});
</script>