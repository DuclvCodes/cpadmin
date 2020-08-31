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
					<h3 class="page-title">
						Quản lý trang tĩnh
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
                        <div class="clearfix"></div>
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
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tiêu đề</th>
                                <th class="background_white">Sửa lần cuối</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
        $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a>
                                    </div>
                                </td>
                                <td><?=$clsUser->getFullname($oneItem['edit_by'])?> vào lúc <?=date('H:i - d.m.Y', $oneItem['last_edit'])?></td>
							</tr>
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