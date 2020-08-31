<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Liên kết tin tức
                        <a href="#" data-href="/<?php echo $mod ?>/add" class="btn_modal btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
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
                    <form action="" method="post">
                    <table class="table table-bordered table-advance act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tiêu đề</th>
                                <th class="background_white">Order</th>
                                <th class="background_white" style="width: 120px;">Nút công cụ</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $key=>$_id) {
        $oneItem=$clsClassTable->getOne($_id); ?>
							<tr class="odd gradeX">
								<td><?php echo $oneItem['title'] ?></td>
                                <td><input name="order_no[<?php echo $oneItem[$pkeyTable] ?>]" type="text" class="text number" value="<?php echo($key+1) ?>" maxlength="2" style="width: 25px; text-align: center; margin: 0; padding: 0;" autocomplete="OFF" /></td>
                                <td>
                                    <a data-href="/<?php echo $mod ?>/edit?id=<?=$_id?>" href="#" class="btn_modal btn blue mini"><i class="icon-pencil"></i> Sửa</a>
                                    <a href="/<?=$mod?>/delete?id=<?=$_id?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?')" class="btn red mini"><i class="icon-remove"></i> Xóa</a>
                                </td>
							</tr>
                            <?php
    } ?>
                            <tr>
                                <td></td>
                                <td colspan="2"><button type="submit" class="btn green">Cập nhật</button></td>
                            </tr>
						</tbody>
					</table>
                    </form>
                    <br />
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
<div id="modal_box" class="modal hide fade" data-width="550"></div>
<script type="text/javascript">
$(document).ready(function(){
    $modal = $('#modal_box');
    $('.btn_modal').click(function(){
        var href = $(this).attr('data-href');
        $('body').click();
        $('body').modalmanager('loading');
        $modal.load(href, '', function(){
            $modal.modal().on("hidden", function() {
                $modal.empty();
            });
        });
        return false;
    });
});
</script>