<?php $mod = current_method()['mod']; ?>
<style>
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
						Danh sách dự đoán <small><?php echo $oneItem['title'] ?></small>
                        <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-chevron-left"></i> Quay lại</a>
					</h3>
				</div>
			</div>
            
            <div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <div class="row-fluid">
						<form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
							<input type="hidden" name="mod" value="vote" />
                            <input type="hidden" name="act" value="voter" />
                            <input type="hidden" name="id" value="<?=$_GET['id']?>" />
							
                            <select name="answers" class="m-wrap  span4"><option value=""> --- Lựa chọn đáp án đúng --- </option>
                                <?php if ($answers) {
    foreach ($answers as $key=>$one) {
        ?>
                                <option value="<?=$key?>" <?php if (isset($_GET['answers']) && $_GET['answers']==$key.'') {
            echo 'selected="selected"';
        } ?>><?=$one?></option>
                                <?php
    }
} ?>
                            </select>
                            <select name="order_nr" class="m-wrap span3">
                                <option value="">Sắp xếp theo ngày trả lời</option>
                                <option value="1">Sắp xếp theo số dự đoán</option>
                            </select>
                            <button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i> Lọc</button>
                            <input type="hidden" name="page" value="1" />
						</form>
					</div>
                    
                    <?php if ($listItem) {
    ?>
                    <form action="" method="post">
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Họ tên</th>
                                <th class="background_white">Địa chỉ</th>
                                <th class="background_white">Số điện thoại</th>
                                <th class="background_white">Email</th>
                                <th class="background_white">Câu trả lời</th>
                                <th class="background_white">Dự đoán</th>
                                <th class="background_white">Ngày trả lời</th>
                                <th class="background_white">IP</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
        $oneItem=$clsVoter->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td><?=$oneItem['fullname']?></td>
                                <td><?=$oneItem['address']?></td>
                                <td><?=$oneItem['phone']?></td>
                                <td><?=$oneItem['email']?></td>
                                <td><?=$answers[$oneItem['answers']]?></td>
                                <td><?=$oneItem['answers_right']?></td>
                                <td><span class="label label-info"><?=date('d/m/Y - H:i', strtotime($oneItem['reg_date']))?></span></td>
                                <td><?=$oneItem['ip']?></td>
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