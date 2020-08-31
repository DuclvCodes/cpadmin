<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.field_cat {white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;display: block;max-width: 70px;}
.field_date {font-size: 11px; color: #999;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
select.m-wrap.span2 {width: 12%;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_royalty') ?>
            
			<h3 class="page-title">Nhuận Bút</h3>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <div class="row-fluid">
						<form class="form-search" action="/royalty/" method="get" style="background: #f0f6fa; padding: 12px 14px;">
							
							<div class="btn form-date-range">
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
                            <input name="keyword" type="text" placeholder="Tìm kiếm ..." class="m-wrap span2" value="<?php echo $_GET['keyword'] ? $_GET['keyword'] : '' ?>" style="background: #FFF;" />
                            <?php echo $clsCategory->getSelect('category_id', isset($_GET['category_id']) ? $_GET['category_id'] : false, 'm-wrap span2', false, ' --- Chuyên mục --- ') ?>
                            <?php echo $clsUser->getSelect('user_id', isset($_GET['user_id']) ? $_GET['user_id'] : false, 'm-wrap span2', false, ' --- Tác giả --- ', 'fullname') ?>
                            <?php echo $clsUser->getSelect('push_user', isset($_GET['push_user']) ? $_GET['push_user'] : false, 'm-wrap span2', false, ' --- Người XB --- ', 'fullname') ?>
                            <select name="is_royalty" class="m-wrap span2">
                                <option value="">--- Nhuận bút ---</option>
                                <option  value="1">Đã tính</option>
                                <option  value="2">Chưa tính</option>
                            </select>
                            <select name="type_post" class="m-wrap span2">
                                <option value="">--- Loại bài ---</option>
                                <?php $allType = $clsClassTable->getAllType(); if ($allType) {
    foreach ($allType as $key=>$one) {
        ?>
                                <option value="<?=$key?>" ><?=$one?></option>
                                <?php
    }
} ?>
                            </select>
							<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
						</form>
					</div>
                    
                    <?php if (isset($user_id)) {
    ?>
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
    								<p><b><?php echo toString($totalPost) ?></b> bài viết</p>
                                    <p><b><?php echo toString($total_royalty) ?></b> VNĐ nhuận bút</p>
                                    <p><b><?php echo toString($total_views) ?></b> views</p>
								</span>
							</div>
						</li>
					</ul>
                    <?php
} else {
        ?>
                    <div class="alert alert-info">
						<p><b><?php echo toString($totalPost) ?></b> bài viết</p>
                        <p><b><?php echo toString($total_royalty) ?></b> VNĐ nhuận bút</p>
                        <p><b><?php echo toString($total_views) ?></b> views</p>
					</div>
                    <?php
    } ?>
                    
                    <?php if ($listItem) {
        ?>
                    <div class="pagination" style="text-align: right; margin-top: 0;">
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
                    <div style="overflow-x: scroll;">
                    <table class="table table-striped table-bordered table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">STT</th>
                                <th class="background_white" style="min-width: 300px;">Tiêu đề</th>
                                <th class="background_white" style="width: 78px;">Chuyên mục</th>
                                <th class="background_white">Tác giả</th>
                                <th class="background_white">Người xuất bản</th>
                                <th class="background_white">Loại bài</th>
                                <th class="background_white" style="width: 115px;">Ngày xuất bản</th>
                                <th class="background_white">Views</th>
                                <th class="background_white" style="width: 120px;">Nhuận bút</th>
                                <th class="hide">Ghi chú</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $key=>$oneItem) {
            $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
                                <td><?php echo $key+1+($cursorPage-1)*$rpp ?></td>
								<td>
                                    <a target="_blank" href="<?php echo str_replace('cms.', 'www.', $clsClassTable->getLink($oneItem[$pkeyTable])) ?>"><?php echo $oneItem['title'] ?></a>
                                    <?=$clsClassTable->hasVideo($oneItem['news_id'])?' <i class="icon-facetime-video tkp_icon_title"></i>':''?>
                                </td>
                                <td><span class="label label-info field_cat"><?php echo $clsCategory->getTitle($oneItem['category_id']) ?></span></td>
                                <td><span class="label label-success field_fullname"><?php echo $clsUser->getFullName($oneItem['user_id']) ?></span></td>
                                <td><span class="label label-success field_fullname"><?php echo $clsUser->getFullName($oneItem['push_user']) ?></span></td>
                                <td><span class="label label-success"><?php echo $clsClassTable->getType($oneItem['type_post']) ?></span></td>
                                <td class="center field_date"><?php echo date('H:i - d/m/Y', strtotime($oneItem['push_date'])); ?></td>
                                <td><span class="badge badge-<?php $views=$oneItem['views'];
            if ($views>10000) {
                echo 'important';
            } elseif ($views>500) {
                echo 'success';
            } elseif ($views>100) {
                echo 'info';
            } elseif ($views>50) {
                echo 'warning';
            } else {
                echo 'gray';
            } ?>"><?php echo toString($views) ?></span></td>
                                <td id="field_btn_royalty_<?php echo $oneItem['news_id'] ?>">
                                    <?php if ($oneItem['royalty']) {
                if ($oneItem['royalty']==1) {
                    $oneItem['royalty']=0;
                } ?>
                                        <button data-id="<?php echo $oneItem[$pkeyTable] ?>" class="btn blue mini btn_modal"><?php echo toString($oneItem['royalty']); ?> VNĐ</button>
                                    <?php
            } else {
                ?>
                                        <button data-id="<?php echo $oneItem[$pkeyTable] ?>" class="btn red mini btn_modal">Chưa tính ...</button>
                                    <?php
            } ?>
                                </td>
                                <td class="hide"></td>
							</tr>
                            <?php
        } ?>
						</tbody>
					</table>
                    </div>
                    
                    <div class="pagination" style="text-align: right;">
                        <a <?php if ($totalPost>10000) {
            echo 'onclick="alert(\'Oops! số bản ghi lớn hơn 10.000\'); return false;"';
        } ?> href="/royalty/excel<?php echo getLinkReplateGET(array()) ?>" target="_blank" style="float: left;" class="btn red">Xuất Excel</a>
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
                        <div class="clearfix"></div>
					</div>
                    
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
<div id="modal_royalty" class="modal hide fade" data-backdropz="static"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('.btn_modal').click(function(){
        var id = $(this).data('id');
        $('body').click();
        $('body').modalmanager('loading');
        var $modal_royalty = $('#modal_royalty');
        $modal_royalty.load('/ajax/getListRoyalty?news_id='+id, '', function(){
            $modal_royalty.modal().on("hidden", function() {
                $modal_royalty.empty();
            });
        });
        return false;
    });
    $('body').addClass('page-sidebar-closed');
});
</script>