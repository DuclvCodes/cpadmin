<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.field_fullname {margin-right: 5px;}
.field_title {}
.field_cat {white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;display: block;max-width: 70px;}
.field_date {font-size: 11px; color: #999;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
button.btn.blue.btn_add_into_box {width: 100%; white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;max-width: 222px;}
.tkp_icon_title {font-size: 11px;color: #ed4e2a;margin-left: 5px;}
.tkp_title {font-size: 21px; line-height: 21px; margin: 0 0 8px;}
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
						Gửi thông báo
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Soạn <i class="icon-plus"></i></a>
					</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    
                    
                    <?php if ($listItem) {
    ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Subject</th>
                                <th class="background_white">Danh sách nhận</th>
                                <th class="background_white">Thời gian gửi</th>
                                <th class="background_white">Tools</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $id) {
        $oneItem=$clsClassTable->getOne($id); ?>
							<tr class="odd gradeX">
								<td><?php echo $oneItem['title'] ?></td>
                                <td>
                                    <?php
                                    $email_path = pathToArray($oneItem['email_path']);
        if ($email_path) {
            foreach ($email_path as $email_id) {
                echo '<span class="label" style="margin-right: 5px;">'.$clsEmail->getTitle($email_id).'</span>';
            }
        } ?>
                                </td>
                                <td><span class="label label-info"><?=date('H:i d/m/Y', strtotime($oneItem['reg_date']))?></span></td>
                                <td><a data-id="<?=$id?>" href="#" class="btn mini blue btn_preview"><i class="icon-eye-open"></i> Preview</a></td>
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
<div id="modal_mom_preview" class="modal container hide fade" data-width="793"></div>
<script src="<?php echo BASE_ASSET ?>/plugins/jquery.wordexport/FileSaver.js"></script>
<script src="<?php echo BASE_ASSET ?>/plugins/jquery.wordexport/jquery.wordexport.js"></script>
<script src="<?php echo BASE_ASSET ?>/plugins/jQuery.print.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.btn_preview').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        $modal = $('#modal_mom_preview');
        $modal.load('/ajax/mom_preview?id='+id, '', function(){
            $modal.modal().on("hidden", function() {
                $modal.empty();
            });
        });
        return false;
    });
});
</script>