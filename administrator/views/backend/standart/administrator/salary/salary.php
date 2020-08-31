<style>
.field_date {color: #888; font-size: 11px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Salary <small>module manager</small>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Dashboard</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Bảng lương</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <div class="row-fluid">
						<form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
							<input type="hidden" name="mod" value="salary" />
							<div id="form-date-range" class="btn">
								<i class="icon-calendar"></i>
								&nbsp;<span></span> 
								<b class="caret"></b>
                                <input name="txt_start" value="<?php if (isset($_GET['txt_start'])) {
    echo $_GET['txt_start'];
} ?>" class="txt_start" type="hidden" />
                                <input name="txt_end" value="<?php if (isset($_GET['txt_end'])) {
    echo $_GET['txt_end'];
} ?>" class="txt_end" type="hidden" />
							</div>
                            <?php echo $clsUser->getSelect('user_id', $_GET['user_id'], 'm-wrap', false, ' --- Thành viên --- ') ?>
							<button type="submit" class="btn green">Xem &nbsp; <i class="m-icon-swapright m-icon-white"></i></button>
						</form>
					</div>
                    <?php if ($user_id) {
    ?>
                    <div style="position: relative; z-index: 9;"><a style="position: absolute; top: 9px; right: 0;" href="/<?php echo $mod ?>&output=excel&nolimit=1" class="btn green">Xuất Excel <i class="icon-print"></i></a></div>
                    <ul class="chats">
						<li class="in">
							<img class="avatar" alt="" src="<?php echo $clsUser->getImage($user_id, 45, 45, 'image', '/files/User/noavatar.jpg') ?>" />
							<div class="message">
								<span class="arrow"></span>
								<span class="name"><?php echo $clsUser->getFullName($user_id) ?></span>
								<?php if ($txt_start) {
        ?><span style="padding-left: 15px;" class="datetime"><?php echo date('d/m/Y', strtotime($txt_start)).' - '.date('d/m/Y', strtotime($txt_end)) ?></span><?php
    } ?>
								<span class="body">
								Tổng lương: <b><?php echo toString($total_royalty) ?> VNĐ</b>
								</span>
							</div>
						</li>
					</ul>
                    <?php
} ?>
                    <?php if ($listItem) {
        ?>
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<tr>
								<th>Tiêu đề</th>
                                <th style="width: 100px;">Danh mục</th>
								<th style="width: 120px;">Ngày tạo</th>
                                <th style="width: 120px;">Ngày xuất bản</th>
                                <th style="width: 120px;">Nhuận bút</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
            $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td><a target="_blank" href="<?php echo $clsClassTable->getLink($oneItem[$pkeyTable]) ?>"><?php echo $oneItem['title'] ?></a></td>
                                <td><span class="label label-info field_cat"><?php echo $clsCategory->getTitle($oneItem['category_id']) ?></span></td>
								<td class="center field_date"><?php echo date('H:i - d/m/Y', strtotime($oneItem['reg_date'])); ?></td>
                                <td class="center field_date"><?php echo date('H:i - d/m/Y', strtotime($oneItem['push_date'])); ?></td>
                                <td id="field_btn_royalty_<?php echo $oneItem['news_id'] ?>">
                                    <?php if ($oneItem['royalty']) {
                ?>
                                        <span class="label label-success"><?php echo toString($oneItem['royalty']); ?> VNĐ</span>
                                    <?php
            } else {
                ?>
                                        <span class="label label-important">Chưa tính ...</span>
                                    <?php
            } ?>
                                </td>
							</tr>
                            <?php
        } ?>
						</tbody>
					</table>
                    
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