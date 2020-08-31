<?php $mod = current_method()['mod']; ?>
<style>
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
#model_vote {padding: 9px 15px;}
#model_vote .progress {margin-bottom: 0;}
#model_vote tr td {font-size: 14px; padding-bottom: 16px;}
#model_vote tr td:nth-child(3) {text-align: right;}
#model_vote tr td h4 {font-size: 18px; line-height: 27px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">Thăm dò ý kiến</h3>
					
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
                                <th class="background_white">Ngày tạo</th>
                                <th class="background_white">Sửa lần cuối bởi</th>
                                <th class="background_white">Lựa chọn</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
        $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <a href="#" data-id="<?=$oneItem[$pkeyTable]?>" class="btn_detail"><?php echo $oneItem['title'] ?></a>
                                        <?php if ($oneItem['is_predict']) {
            ?>
                                        <span>&nbsp;</span><a href="/<?=$mod?>/voter?id=<?=$oneItem[$pkeyTable]?>" class="btn red mini"><i class="icon-star"></i> Dự đoán</a>
                                        <?php
        } ?>
                                    </div>
                                </td>
                                <td><span class="label label-warning"><?=date('d/m/Y - H:i', strtotime($oneItem['reg_date']))?></span></td>
                                <td><span class="label label-info"><?=$clsUser->getFullName($oneItem['edit_by'])?></span> <span class="label"><?=date('H:i - d/m/Y', $oneItem['last_edit'])?></span></td>
                                <td><span class="label label-warning"><a href="/<?=$mod?>/edit?id=<?=$oneItem[$pkeyTable]?>">Chỉnh sửa</a></span></td>
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
<div id="model_vote" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<script type="text/javascript">
$(document).ready(function(){
    var $model_vote = $('#model_vote');
    $('.btn_detail').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        $model_vote.load('/ajax/getDetailVote?id='+id, '', function(){
            $model_vote.modal().on("hidden", function() {
                $model_vote.empty();
            });
        });
        return false;
    });
});
</script>