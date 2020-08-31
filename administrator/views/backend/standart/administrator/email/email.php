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
            <?php getBlock('tab_mom') ?>
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="margin-top: 0;">
						Quản lý Email
                        <a href="#" data-href="/<?php echo $mod ?>/add" class="btn_modal btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
					</h3>
					
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    
                    
                    <?php if ($listItem) {
    ?>
                    <form action="" method="post">
                    <table class="table table-bordered table-advance act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tiêu đề</th>
                                <th class="background_white">Email</th>
                                <th class="background_white">Nút công cụ</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $_id) {
        $oneItem=$clsClassTable->getOne($_id); ?>
							<tr class="odd gradeX" style="background: #EEE;">
								<td><?php echo $oneItem['title'] ?></td>
                                <td><span class="label label-success"><?php echo $oneItem['email'] ?></span></td>
                                <td>
                                    <a data-href="/<?php echo $mod ?>/edit?id=<?=$_id?>" href="#" class="btn_modal btn blue mini"><i class="icon-pencil"></i> Sửa</a>
                                    <a href="/<?=$mod?>/delete?id=<?=$_id?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?')" class="btn red mini"><i class="icon-remove"></i> Xóa</a>
                                </td>
							</tr>
                            <?php
                            $allChild = $clsClassTable->getChild($_id);
        if ($allChild) {
            foreach ($allChild as $_id) {
                $oneItem=$clsClassTable->getOne($_id); ?>
                            <tr class="odd gradeX">
								<td><?php echo $oneItem['title'] ?></td>
                                <td><span class="label label-success"><?php echo $oneItem['email'] ?></span></td>
                                <td>
                                    <a data-href="/<?php echo $mod ?>/edit?id=<?=$_id?>" href="#" class="btn_modal btn blue mini"><i class="icon-pencil"></i> Sửa</a>
                                    <a href="/<?=$mod?>/delete?id=<?=$_id?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?')" class="btn red mini"><i class="icon-remove"></i> Xóa</a>
                                </td>
							</tr>
                            <?php
            }
        } ?>
                            <?php
    } ?>
						</tbody>
					</table>
                    </form>
                    <br />
                    <?php
} else {
        echo '<p>Không có bản ghi nào!</p>';
    } ?>
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