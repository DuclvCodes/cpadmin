<?php $mod = current_method()['mod']; ?>
<style>
td.hasToggle {line-height: 0 !important;}
td.hasToggle .labelRight, td.hasToggle .labelLeft {font-size: 11px !important;}
.url_link {font-size: 11px; color: #268e47; font-style: italic;}
.field_title a.btnz {text-decoration: none; cursor: pointer; display: none;}
.field_title a.btnz i:before {cursor: pointer;}
tr:hover a.btnz {display: inline-block;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Danh sách bình luận
					</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php if ($listItem) {
    ?>
                    <form action="" method="post">
                    <table class="table table-bordered" id="sample_1">
						<tbody>
                            <?php foreach ($listItem as $id) {
        $oneItem=$clsClassTable->getOne($id); ?>
							<tr class="odd gradeX" data-id="<?=$oneItem['comment_id']?>">
								<td>
                                    <div class="field_title">
                                        <a href="mailto:<?=$oneItem['email']?>"><span class="label label-success"><?=$oneItem['fullname']?></span></a>
                                        <span id="span_comment_<?=$oneItem['comment_id']?>"><?php echo stripslashes($oneItem['content']) ?></span>
                                        <span style="color: #999; font-size: 11px; font-style: italic;" title="<?=date('d-m-Y H:i', strtotime($oneItem['reg_date']))?>"> (<?=time_ago(strtotime($oneItem['reg_date']))?>)</span>
                                        <span> </span>
                                        <a href="#" class="btnz btn_edit" data-id="<?=$id?>" title="Sửa"><i class="icon-edit"></i></a>
                                        <a href="#" class="btnz btn_del" data-id="<?=$id?>" title="Xóa"><i class="icon-remove-circle"></i></a>
                                    </div>
                                    <div><a class="url_link" href="<?=str_replace('cms.', 'www.', $clsNews->getLink($oneItem['news_id']))?>" target="_blank"><?=$clsNews->getTitle($oneItem['news_id'])?></a></div>
                                </td>
                                <td class="hasToggle">
                                    <div class="toggle_button_mini">
                                        <input type="hidden" name="push_by" value="0" />
										<input name="push_by" value="1" type="checkbox" class="toggle" <?php if ($oneItem['push_by']>0) {
            echo 'checked="checked"';
        } ?> />
									</div>
                                </td>
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
<div id="modal_edit_comment" class="modal hide fade" data-backdrop="static" data-width="705"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('.btn_edit').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        var $modal_edit = $('#modal_edit_comment');
        $modal_edit.load('/ajax/editComment?id='+id, '', function(){
            $modal_edit.modal().on("hidden", function() {
                $modal_edit.empty();
            });
        });
        return false;
    });
    $('.btn_del').click(function(){
        if(confirm('Bạn có chắc chắn muốn xóa bình luận này?')==true) {
            var id = $(this).attr('data-id');
            var obj = $(this).parents('tr');
            $.ajax({type: "GET", url: "/ajax/delComment?id="+id, dataType: "html",success: function(msg){
                obj.remove();
            }});
        }
        return false;
    });
    $('.toggle_button_mini').toggleButtons({
        onChange: function ($el, status, e) {
            var val = 0;
            if(status) val = 1;
            var id = $el.parents('tr').attr('data-id');
            $.ajax({type: "POST", url: "/ajax/updateComment?id="+id, data: {push: val}, dataType: "html",success: function(msg){}});
        },
        width: 60, height: 22, animated: true,
        transitionspeed: 0.1,
        label: {enabled: "XB", disabled: "ẨN"}
    });
});
</script>