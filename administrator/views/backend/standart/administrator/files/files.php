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
					<h3 class="page-title">Quản lý File
                                            <a href="#add_file" id="add_file" data-toggle="modal" class="btn green pull-right"><i class="icon-pencil"></i>Thêm File</a>
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
                    
                    <ul id="list_video">
                        <?php foreach ($listItem as $video_id) {
        $oneVideo = $clsClassTable->getOne($video_id); ?>
                        <li>
                            <a class="photo btn_play" href="#" data-id="<?=$video_id?>"><img src="<?=$clsClassTable->getImage($video_id, 200, 120)?>" /><span><?=date('i:s', $oneVideo['duration'])?></span></a>
                            
                        </li>
                        <?php
    } ?>
                        <li style="clear: both; float: none;"></li>
                    </ul>
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
<div id="mnu_box_files" class="modal hide fade" data-backdropz="static" data-width="705"></div>
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
    var $modal_box_files = $('#mnu_box_files');
    $('.btn_play').click(function(){
        var id = $(this).attr('data-id');
        $('body').click();
        $('body').modalmanager('loading');
        $modal = $('#modal_detail');
        $modal.load('/files/detail?id='+id, '', function(){
            $('.video_code').unbind().click(function(){
                $(this).selectText();
            });
            $modal.modal().on("hidden", function() {
                $modal.empty();
            });
        });
        return false;
    });
    $('#add_file').click(function(){
        $('body').click();
        $('body').modalmanager('loading');
        $modal_box_files.load('/ajax/addFile', '', function(){
            $modal_box_files.modal().on("hidden", function() {
                $modal_box_files.empty();
            });
        });
        return false;
    });
});
</script>