<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Danh sách thư viện
                        <?php if ($_GET['is_trash']==1) {
    ?>
                            <small style="font-family: Arial;">Thùng rác <i class="icon-trash"></i></small>
                            <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-reorder"></i> Danh sách</a>
                        <?php
} else {
        ?>
                            <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
                            <a href="/<?php echo $mod ?>&is_trash=1" class="btn pull-right"><i class="icon-trash"></i> Thùng rác</a>
                        <?php
    } ?>
					</h3>
					
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <div class="row-fluid">
						<form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
							<input type="hidden" name="mod" value="library" />
							<select name="category_id" class="m-wrap span3">
                                <option value="-1">----- Tất cả -----</option>
                                <?php $allCate = $clsClassTable->getAllCate(); if ($allCate) {
        foreach ($allCate as $key=>$oneCate) {
            ?>
                                <option <?php if ($_GET['category_id']==$key) {
                echo 'selected="selected"';
            } ?> value="<?=$key?>"><?=$oneCate?></option>
                                <?php
        }
    } ?>
                            </select>
                            <input name="keyword" type="text" placeholder="Số báo" class="m-wrap span2" value="<?php echo $_GET['keyword'] ?>" style="background: #FFF;" />
                            <div class="btn form-date-range">
								<i class="icon-calendar"></i>
								&nbsp;<span></span> 
								<b class="caret"></b>
                                <input name="txt_start" value="<?php if (isset($_GET['txt_start'])) {
        echo $_GET['txt_start'];
    } else {
        echo date('Y-m-d 00:00:00', strtotime('-1 month'));
    } ?>" class="txt_start" type="hidden" />
                                <input name="txt_end" value="<?php if (isset($_GET['txt_end'])) {
        echo $_GET['txt_end'];
    } else {
        echo date('Y-m-d 23:59:59');
    } ?>" class="txt_end" type="hidden" />
							</div>
							<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
						</form>
					</div>
                    
                    <?php if ($listItem) {
        ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white">Tiêu đề</th>
                                <th class="background_white">Ngày xuất bản</th>
                                <th class="background_white">Xem nhanh</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $id) {
            $oneItem=$clsClassTable->getOne($id); ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <?php if ($oneItem['user_id']) {
                ?><span class="label label-success field_fullname"><?php echo $clsUser->getFullName($oneItem['user_id']) ?></span><?php
            } ?>
                                        <a href="/library/edit?id=<?=$id?>"><?=$clsClassTable->getTitleCate($oneItem['category_id']).' số '.$oneItem['title']?></a>
                                        <?php if ($oneItem['is_draf']) {
                ?>&nbsp;&nbsp;&nbsp;<span class="label">Nháp</span><?php
            } ?>
                                    </div>
                                </td>
                                <td><?=date('d/m/Y', strtotime($oneItem['reg_date']))?></td>
                                <td><a class="btn gray mini" href="<?=str_replace('cms.', 'www.', $clsClassTable->getLink($id))?>" title="Xem nhanh" target="_blank"><i class="icon-link"></i></a></td>
							</tr>
                            <?php
        } ?>
						</tbody>
					</table>
                    
                    <div class="pagination">
						<?php if ($paging) {
            ?>
                        <ul>
                            <?php foreach ($paging as $one) {
                ?>
							<li class="<?php if ($cursorPage==$one[0]) {
                    echo 'active';
                } ?>"><a href="<?php echo getLinkReplateGET(array('page'=>$one[0])) ?>"><?php echo $one[1] ?></a></li>
							<?php
            } ?>
						</ul>
                        <?php
        } ?>
                        <div class="clearfix"></div>
                        <br />
                        <div class="alert alert-info">
							Tổng cộng có <b><?php echo toString($totalPost) ?></b> bài viết
						</div>
					</div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    
                    <?php
    } else {
        echo '<p style="font-size: 45px;color: #999;margin: 68px 0;text-align: center;">Không có bản ghi nào!</p>';
    } ?>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<div id="mnu_box_news" class="modal hide fade" data-backdropz="static" data-width="705"></div>

<script type="text/javascript">
$(document).ready(function(){
    var html = '<li><a class="n_href" href="" data-href="http://<?=SUBDOMAIN_TEMP?>.<?=DOMAIN?>/news/detailid=" target="_blank"><i class="icon-eye-open"></i> Xem tin này ngoài giao diện</a></li>';
    //html += '<li class="divider"></li>';
    html += '<li><a class="n_href" href="" data-href="/news/edit?id="><i class="icon-pencil"></i> Sửa thông tin</a></li>';
    <?php if (isset($_GET['status']) && $_GET['status']==4) {
        ?> html += '<li><a href="#" class="modal_box_news"><i class="icon-plus"></i> Thêm vào Hộp tin</a></li>';<?php
    } ?>
    //html += '<li class="divider"></li>';
    <?php if (isset($_GET['is_trash']) && $_GET['is_trash']==1) {
        ?>
    html += '<li><a class="n_href" href="" data-href="/news/restore?id="><i class="icon-undo"></i> Phục hồi</a></li>';
    html += '<li><a class="n_href" href="" data-href="/news/delete?id="><i class="icon-remove"></i> Xóa vĩnh viễn</a></li>';
    <?php
    } else {
        ?>
    html += '<li><a class="n_href" href="" data-href="/news/trash?id="><i class="icon-trash"></i> Cho vào thùng rác</a></li>';
    <?php
    } ?>
    $('body').append('<div id="mod_news_menu_moucse"><ul class="dropdown-menu bottom-up" style="bottom: inherit;float: none;">'+html+'</ul></div>')
    var $modal_box_news = $('#mnu_box_news');
    var is_open_menu = false;
    $('.btn_title').bind("contextmenu", function(event) {
        var id = $(this).data('id');
        event.preventDefault();
        is_open_menu = true;
        $('body').click();
        $('#mod_news_menu_moucse').addClass('open');
        $("#mod_news_menu_moucse ul").css({top: event.pageY + "px", left: event.pageX + "px"});
        $("#mod_news_menu_moucse ul a.n_href").each(function(){
            $(this).attr('href', $(this).data('href')+id);
        });
        $('#mod_news_menu_moucse ul a.modal_box_news').unbind().click(function(){
            $('body').click();
            $('body').modalmanager('loading');
            $modal_box_news.load('/ajax/getListBox?news_id='+id, '', function(){
                $modal_box_news.modal().on("hidden", function() {
                    $modal_box_news.empty();
                });
            });
            return false;
        });
    });
    $('body').click(function(){
        if(is_open_menu==true) $('#mod_news_menu_moucse').removeClass('open');
    });
    $('.btn_unpush').click(function(){
        var id = $(this).attr('data-id');
        var obj = $(this).parents('tr');
        obj.hide();
        $.ajax({type: "POST", url: "/news/unpush?id="+id, dataType: "html",success: function(msg){
            if(msg=='1') obj.remove();
            else {
                obj.show();
                alert('Có lỗi xảy ra.');
            }
        }});
        return false;
    });
    $('#btn_open_box_news').click(function(){
        $('body').click();
        $('body').modalmanager('loading');
        $modal_box_news.load('/ajax/getListBox?news_id=0', '', function(){
            $modal_box_news.modal().on("hidden", function() {
                $modal_box_news.empty();
            });
        });
        return false;
    });
});
</script>