<style>
#list_video {list-style: none; margin: 0; padding: 0;}
#list_video li {display: inline-block; float: left; margin-right: 8px; margin-bottom: 8px; width: 200px;}
#list_video .photo {position: relative; display: inline-block;}
#list_video .photo span {position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #FFF; font-size: 11px; padding: 0 3px; line-height: 13px; font-weight: bold;}
#list_video .title {color: #167ac6; display: block; max-height: 32px; line-height: 16px; margin-top: 5px; overflow: hidden; font-size: 12px;}
#list_video .p {font-size: 11px; color: #666;}
#list_video .more {height: 52px;}
.video_code {padding: 2px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; font-family: Monaco,Menlo,Consolas,"Courier New",monospace; font-size: 11px; border-radius: 3px !important; margin: 1px 5px 5px;}
.optimizing {color: red !important; font-weight: bold;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">Quản lý video
                                            <a href="#add_video" id="add_video" data-toggle="modal" class="btn green pull-right"><i class="icon-pencil"></i>Thêm Video</a>
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
				<div style="overflow-x: scroll;">
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
                                                            <th class="background_white">ID</th>
                                                            <th class="background_white nowrap" style="min-width: 48px;">Tên file</th>

                                                            <th class="background_white" style="width: 70px;">Thumb</th>

                                                            <th class="background_white" style="width: 70px;">Người upload</th>

                                                            <th class="background_white" style="">Loại file</th>
                                                            <th class="background_white" >View</th>
                                                            <th class="background_white" style="width: 67px;">Thời lượng</th>
                                                            <th class="background_white">Trạng thái</th>
                                                            <th class="background_white">Option</th>
							</tr>
						</thead>
						<tbody>
                            <?php $i=($cursorPage-1)*50;
    foreach ($listItem as $key=>$video_id) {
        $oneItem = $clsClassTable->getOne($video_id);
        $i++; ?>
							<tr class="odd gradeX" data-id="<?=$id?>">
                                                            <td><?=$video_id?></td>
								<td>
                                    <div class="field_title">
                                        <img src="<?php echo get_icon_file($oneItem['title'])?>" width="25px"> <?=$oneItem['title']?$oneItem['title']:str_replace('-', ' ', str_replace('_', ' ', basename($oneItem['file'])))?>
                                    </div>
                                </td>
                                
                                <td>
                                    <img src="<?=$clsClassTable->getImage($video_id, 200, 120)?>" />
                                </td>
                                
                                <td>
                                    <span class="label label-success field_cat tooltips" data-original-title=""><?php echo $this->User_model->getFullName($oneItem['user_id']) ?></span>
                                </td>
                                <td class="center field_date nowrap"><?php echo date('H:i - d.m', strtotime($oneItem['reg_date'])); ?></td>
                                <td class="center field_date nowrap"><?php echo $oneItem['file_type']; ?></td>
                                <td class="center field_date nowrap"><a class="photo btn_play" href="#" data-id="<?=$video_id?>">View </a></td>
                                <td class="center field_date nowrap"><?=time_ago(strtotime($oneItem['reg_date']))?></td>
                                <td class="field_date nowrap"><?php if ($oneItem['status']==1) {
            echo  'Active';
        } else {
            echo 'Inactive';
        } ?></td>
<!--                                <td class="field_date nowrap"><a href='#' class="btn_files" data-id="<?=$oneItem['file_id']?>">Edit</a> <a href="#" class="del" data-id="<?=$oneItem['video_id']?>">Delete</a></td></td>-->
							</tr>
                            <?php
    } ?>
						</tbody>
					</table>
                    </div>
                    
                    <div style="clear: both;"></div>
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
<div id="modal_detail" class="modal container hide fade" data-width="560" style="font-family: Arial;"></div>
<div id="mnu_box_video" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<script type="text/javascript">
jQuery.fn.selectText = function(){
   var doc = document;
   var element = this[0];
   
   console.log(this, element);
   if (doc.body.createTextRange) {
       var range = document.body.createTextRange();
       range.moveToElementText(element);
       range.select();
   } else if (window.getSelection) {
       var selection = window.getSelection();        
       var range = document.createRange();
       range.selectNodeContents(element);
       selection.removeAllRanges();
       selection.addRange(range);
   }
};
$(document).ready(function(){
    var $modal_box_video = $('#mnu_box_video');
    $('.btn_play').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        $modal = $('#modal_detail');
        $modal.load('/video/detail?id='+id, '', function(){
            $('.video_code').unbind().click(function(){
                $(this).selectText();
            });
            $modal.modal().on("hidden", function() {
                $modal.empty();
            });
        });
        return false;
    });
    $('#add_video').click(function(){
        $('body').click();
        $('body').modalmanager('loading');
        $modal_box_video.load('/ajax/addVideo', '', function(){
            $modal_box_video.modal().on("hidden", function() {
                $modal_box_video.empty();
            });
        });
        return false;
    });
    $(".del").click(function(){
        var id = $(this).attr('data-id');
        if (confirm("Bạn có chắc muốn xóa bản ghi này ?")){
          $.ajax({
            type:"GET",
            url: "<?php echo base_url()?>video/delete",
            data: "id="+id,
            asynchronous: true,
            cache: false,
            beforeSend: function(){

            },
           success: function(){
               location.reload();
           }

          });
        return false;
        }
      });
});
</script>