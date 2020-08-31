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
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
					</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php $arrType = array('Độc quyền', 'Chia sẻ 2', 'Chia sẻ 3'); ?>
                    
                    <?php if ($listItem) {
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
								<td><a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a> <span class="badge badge-info"><?=$oneItem['width'].' x '.$oneItem['height']?></span></td>
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
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_show_ads').attr('href', $('select[name=show_ads] option').attr('value')+'?show=ads');
    $('select[name=show_ads]').change(function(){
        var val = $(this).val();
        $('#btn_show_ads').attr('href', val+'?show=ads');
    });
});
</script>