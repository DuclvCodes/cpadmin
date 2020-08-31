<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Quản lý nhóm
                        <?php if ($_GET['is_trash']==1) {
    ?>
                            <small style="font-family: Arial;">Thùng rác <i class="icon-trash"></i></small>
                            <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-reorder"></i> Danh sách</a>
                        <?php
} else {
        ?>
                            <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
                            <a href="/<?php echo $mod ?>?is_trash=1" class="btn pull-right"><i class="icon-trash"></i> Thùng rác</a>
                        <?php
    } ?>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Nhóm</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Danh sách</a></li>
					</ul>
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
								<th class="sorting">Tiêu đề</th>
                                <th class="sorting" style="width:23px;">ID</th>
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
                                <td class="filed_id"><?php echo $oneItem[$pkeyTable] ?></td>
							</tr>
                            <?php
        } ?>
						</tbody>
					</table>
                    </form>
                    <div class="pagination">
						<ul>
                            <?php if ($paging) {
            foreach ($paging as $one) {
                ?>
							<li class="<?php if ($cursorPage==$one[0]) {
                    echo 'active';
                } ?>"><a href="<?php echo getLinkReplateGET(array('page'=>$one[0])) ?>"><?php echo $one[1] ?></a></li>
							<?php
            }
        } ?>
						</ul>
					</div>
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