<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_ads') ?>
            
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="margin-top: 0;">
						Danh sách đối tác
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right btn_modal"><i class="icon-plus"></i> Thêm mới</a>
					</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php $arrType = array('Độc quyền', 'Chia sẻ 2', 'Chia sẻ 3'); ?>
                    
                    <?php if (isset($listItem) and count($listItem) > 1) {
    ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tên đối tác</th>
                                <th class="background_white">Thời hạn</th>
                                <th class="background_white">Trạng thái</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
        $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td><a class="btn_modal" href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a> <?php if (!$oneItem['is_fix']) {
            ?> &nbsp; [<a href="/<?=$mod?>/fix?id=<?=$oneItem[$pkeyTable]?>">Tối ưu hóa</a>]<?php
        } ?></td>
                                <td><?=db2datepicker($oneItem['todate'], false)?></td>
                                <td><?=$oneItem['is_show']?'<span class="label label-success">Đang chạy</span>':'<span class="label label-important">Tạm dừng</span>'?></td>
							</tr>
                            <?php
    } ?>
						</tbody>
					</table>
                    
                    <br />
                    <br />
                    <br />
                    <br />
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
        var href = $(this).attr('href');
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