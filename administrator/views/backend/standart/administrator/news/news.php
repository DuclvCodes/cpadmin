<?php
$me = $this->User_model->getMe();
?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
                        <?php
                        if (isset($is_trash)&&$is_trash==1) {
                            echo 'Thùng rác';
                        } elseif (isset($status_path) && $status_path=='3.4.5') {
                            echo 'Bài đã duyệt';
                        } else {
                            echo $this->News_model->getTitleStatus(intval(isset($status) ? $status : 0));
                        }
                        ?>
                        <a href="#top-trend" data-toggle="modal" class="btn green pull-right"><i class="icon-pencil"></i> Viết gì hôm nay?</a>
                        <?php if ($me['is_push']) {
                            ?><a id="btn_open_box_news" href="#" class="btn red pull-right"><i class="icon-plus"></i> Hộp tin</a><?php
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
							<input type="hidden" name="mod" value="news" />
							<div class="btn form-date-range">
								<i class="icon-calendar"></i>
								&nbsp;<span></span> 
								<b class="caret"></b>
                                <input name="txt_start" value="<?php if (isset($txt_start)) {
                            echo $txt_start;
                        } ?>" class="txt_start" type="hidden" />
                                <input name="txt_end" value="<?php if (isset($txt_end)) {
                            echo $txt_end;
                        } ?>" class="txt_end" type="hidden" />
							</div>
                            <input name="keyword" type="text" placeholder="Tìm kiếm..." class="m-wrap span2" value="<?php echo $_GET['keyword'] ? $_GET['keyword'] : '' ?>" style="background: #FFF;" />
                            <?php echo $this->Category_model->getSelect('category_id', isset($category_id) ? $category_id : null, 'm-wrap  span2', false, ' --- Chuyên mục --- ') ?>
                            
                            <?php if (0) {
                            ?>
                            <?php if ($me['level']>=3) {
                                ?>
                            <select name="status" class="m-wrap span2">
                                <option <?php if ($status==0 && !isset($status_path)) {
                                    echo 'selected="selected"';
                                } ?> value="0">Bài đang viết</option>
                                <option <?php if ($status==1) {
                                    echo 'selected="selected"';
                                } ?> value="1">Bài chờ biên tập</option>
                                <option <?php if ($status=='3.4.5' || $status_path=='3.4.5') {
                                    echo 'selected="selected"';
                                } ?> value="3.4.5">Bài đã duyệt</option>
                                <option <?php if ($status==2) {
                                    echo 'selected="selected"';
                                } ?> value="2">Tin bài trả về</option>
                            </select>
                            <?php
                            } else {
                                ?>
                            <select name="status" class="m-wrap span2">
                                <option <?php if ($status==0) {
                                    echo 'selected="selected"';
                                } ?> value="0">Bài đang viết</option>
                                <option <?php if ($status==1) {
                                    echo 'selected="selected"';
                                } ?> value="1">Bài chờ biên tập</option>
                                <option <?php if ($status==3) {
                                    echo 'selected="selected"';
                                } ?> value="3">Bài chờ xuất bản</option>
                                <option <?php if ($status==4) {
                                    echo 'selected="selected"';
                                } ?> value="4">Bài đã xuất bản</option>
                                <option <?php if ($status==5) {
                                    echo 'selected="selected"';
                                } ?> value="5">Tin bài gỡ xuống</option>
                                <option <?php if ($status==2) {
                                    echo 'selected="selected"';
                                } ?> value="2">Tin bài trả về</option>
                            </select>
                            <?php
                            } ?>
                            
                            <select name="type_post" class="m-wrap span2 hide">
                                <option value=""> --- Tất cả --- </option>
                                <option value="1" <?php if ($type_post==1) {
                                echo 'selected="selected"';
                            } ?>>Sản xuất hiện trường</option>
                                <option value="2" <?php if ($type_post==2) {
                                echo 'selected="selected"';
                            } ?>>Sản xuất</option>
                                <option value="3" <?php if ($type_post==3) {
                                echo 'selected="selected"';
                            } ?>>Tổng hợp</option>
                                <option value="4" <?php if ($type_post==4) {
                                echo 'selected="selected"';
                            } ?>>Khai thác</option>
                                <option value="5" <?php if ($type_post==5) {
                                echo 'selected="selected"';
                            } ?>>Bài dịch</option>
                            </select>
                            <?php
                        } ?>
                            
                            <select name="type_is" class="m-wrap span2">
                                <option value="">--- Tất cả ---</option>
                                <option value="1" <?php if ($type_is==1) {
                            echo 'selected="selected"';
                        } ?>>Tin ảnh</option>
                                <option value="2" <?php if ($type_is==2) {
                            echo 'selected="selected"';
                        } ?>>Tin video</option>
                                <option value="3" <?php if ($type_is==3) {
                            echo 'selected="selected"';
                        } ?>>Tin thường</option>
                            </select>
                            <?php if ($me['level']<3) {
                            echo $this->User_model->getSelect('uid', $uid, 'm-wrap span2', false, '--- Thành viên ---', 'fullname');
                        } ?>
                            <?php if ($me['level']<3) {
                            echo $this->User_model->getSelect('push_user', $push_user, 'm-wrap span2', false, '--- Người XB ---', 'fullname');
                        } ?>
							<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
                            <?php if (isset($status)) {
                            echo '<input type="hidden" name="status" value="'.$status.'" />';
                        } ?>
                            <?php if (isset($status_path)) {
                            echo '<input type="hidden" name="status_path" value="'.$status_path.'" />';
                        } ?>
						</form>
					</div>
                    
                    <?php if ($listItem) {
                            ?>
                    
                    <?php if ($status==2 || $status==5) {
                                ?>
                    <div>
                        <a href="#" id="btn_checkall">Chọn tất cả</a>
                        &nbsp;/&nbsp;
                        <a href="#" id="btn_uncheckall">Bỏ chọn tất cả</a>
                    </div>
                    <div style="display: none;">
                        <a href="#" id="btn_trashall"><b>Cho vào thùng rác</b></a>
                        &nbsp;/&nbsp;
                        <a href="#" id="btn_cancelcheckall">Hủy</a>
                    </div>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('table.act_default tbody tr').each(function(){
                            var id = $(this).attr('data-id');
                            $(this).find('.field_title').before('<input type="checkbox" value="'+id+'" />');
                        });
                        $('#btn_checkall').click(function(){
                            $('table.act_default').addClass('showcheckall');
                            $(this).parent().hide(); $('#btn_trashall').parent().show();
                            $('table.act_default tbody tr input[type=checkbox]:checked').click();
                            $('table.act_default tbody tr input[type=checkbox]').click();
                            return false;
                        });
                        $('#btn_uncheckall').click(function(){
                            $('table.act_default').addClass('showcheckall');
                            $(this).parent().hide(); $('#btn_trashall').parent().show();
                            $('table.act_default tbody tr input[type=checkbox]:checked').click();
                            return false;
                        });
                        $('#btn_cancelcheckall').click(function(){
                            $('table.act_default').removeClass('showcheckall');
                            $(this).parent().hide(); $('#btn_checkall').parent().show();
                            return false;
                        });
                        $('#btn_trashall').click(function(){
                            $('table.act_default tbody tr input[type=checkbox]:checked').each(function(){
                                var obj = $(this).parents('tr');
                                var id = obj.attr('data-id');
                                obj.hide();
                                $.ajax({type: "GET", url: "/news/trash?res=1&id="+id, dataType: "html",success: function(msg){
                                    if(msg=='1') obj.remove();
                                    else {
                                        obj.show();
                                        alert('Có lỗi xảy ra.');
                                    }
                                }});
                            });
                            return false;
                        });
                    });
                    </script>
                    <?php
                            } ?>
                    
                    <div style="overflow-x: scroll;">
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white" style="min-width: 300px;">Tiêu đề</th>
                                <?php if ($status == 5) {
                                ?>
                                
                                <?php
                            } else {
                                ?>
                                <th class="background_white nowrap" style="min-width: 48px;">Lượt xem</th>
                                <?php
                            } ?>
                                <?php if ($status == 5) {
                                ?>
                                <th class="background_white" style="width: 70px;">Ghi chú</th>
                                <?php
                            } else {
                                ?>
                                <th class="background_white" style="width: 70px;">Chuyên mục</th>
                                <?php
                            } ?>
                                <?php if (isset($status) && $status==4) {
                                ?>
    								<th class="background_white" style="">Xuất bản</th>
                                <?php
                            } else {
                                ?>
                                    <th class="background_white" style="width: 67px;">Ngày tạo</th>
                                    <th class="background_white" style="width: 100px;"><?=(isset($status)?'Ngày '.ltrim($this->News_model->getTitleStatus($status), 'Bài '):'Xuất bản')?></th>
                                <?php
                            } ?>
                                <th class="background_white">Trạng thái</th>
							</tr>
						</thead>
						<tbody>
                            <?php $i=($cursorPage-1)*50;
                            foreach ($listItem as $key=>$id) {
                                $oneItem=$this->News_model->getOne($id);
                                $i++; ?>
							<tr class="odd gradeX" data-id="<?=$id?>">
								<td>
                                    <div class="field_title">
                                        <span class="label"><?=($i<10)?'0'.$i:$i?></span>
                                        <?php if ($oneItem['user_id']) {
                                    ?><span class="label label-success field_fullname"><?php echo $this->User_model->getFullName($oneItem['user_id']) ?></span>
                                        <?php
                                } else {
                                    ?><span class="label label-important field_fullname"><?php echo $clsSource->getTitle($oneItem['source_id']) ?></span><?php
                                } ?>
                                        <a data-id="<?php echo $oneItem[$pkeyTable] ?>" href="<?php if ($this->News_model->getPermissionEdit($oneItem, $me)) {
                                    echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable];
                                } else {
                                    echo '#';
                                } ?>" class="btn_title"><?=$oneItem['title']?$oneItem['title']:'<i>Bài chưa nhập tiêu đề ...</i>'?></a>
                                        <?php if ($oneItem['is_photo']) {
                                    echo '<i class="icon-camera tkp_icon_title"></i>';
                                } ?>
                                        <?php if ($oneItem['is_video']) {
                                    echo '<i class="icon-facetime-video tkp_icon_title"></i>';
                                } ?>
                                <?php if ($oneItem['active_audio']==1) {
                                    echo '<i class="icon-music tkp_icon_title"></i>';
                                } ?>
                                        <?php if (strtotime($oneItem['push_date'])>=time()) {
                                    echo '<b style="margin-left: 8px; font-size: 11px; color: #e02222;">Hẹn giờ: '.date('H:i d/m', strtotime($oneItem['push_date'])).'</b>';
                                } ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($status == 5) {
                                    ?>
                                    
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="btn mini red-stripe"><?php echo toString($oneItem['views']) ?></a>
                                    <?php
                                } ?>
                                </td>
                                <?php if ($status == 5) {
                                    ?>
                                <td>
                                    <span class="label label-success field_cat tooltips" data-original-title="<?php echo $clsLogs->getLastLogNews($id); ?>"><?php echo $clsLogs->getLastLogNews($id); ?></span>
                                </td>
                                <?php
                                } else {
                                    ?>
                                <td>
                                    <span class="label label-success field_cat tooltips" data-original-title="<?php $parent_id = $this->Category_model->getParentID($oneItem['category_id']);
                                    if ($parent_id) {
                                        echo $this->Category_model->getTitle($parent_id).' » ';
                                    }
                                    $cat_title = $this->Category_model->getTitle($oneItem['category_id']);
                                    echo $cat_title; ?>"><?php echo $cat_title ?></span>
                                </td>
                                <?php
                                } ?>
								<?php if (isset($status) && $status==4) {
                                    ?>
                                    <td class="center field_date nowrap"><?php echo date('H:i - d.m', strtotime($oneItem['push_date'])) ?> <span style="padding: 0 8px;">bởi</span> <b><?php echo $this->User_model->getLashName($oneItem['push_user']) ?></b></td>
                                <?php
                                } else {
                                    ?>
                                    <td class="center field_date nowrap"><?php echo date('H:i - d.m', strtotime($oneItem['reg_date'])); ?></td>
                                    <td class="center field_date nowrap"><?php echo date('H:i - d.m', strtotime($oneItem['push_date'])) ?></td>
                                <?php
                                } ?>
                                <td class="field_date nowrap"><?=ltrim($this->News_model->getTitleStatus($oneItem['status']), 'Bài ')?></td>
							</tr>
                            <?php
                            } ?>
						</tbody>
					</table>
                    </div>
                    
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
<div id="top-trend" class="modal hide fade" data-width="600" style="height: 381px; overflow: hidden;"><iframe scrolling="no" style="border:none;" width="600" height="413" src="https://www.google.com/trends/hottrends/widget?pn=p28&amp;tn=50&amp;h=413"></iframe></div>
<script type="text/javascript">
$(document).ready(function(){
    var html = '<li><a class="n_href" href="" data-href="http://demo.phapluatplus.vn/news/detail-d" target="_blank"><i class="icon-eye-open"></i> Xem tin này ngoài giao diện</a></li>';
    <?php if($me['level'] <= 2) { ?>
    html += '<li><a class="n_href" href="" data-href="/news/edit?id="><i class="icon-pencil"></i> Sửa thông tin</a></li>';
    <?php } ?>
    <?php if (isset($status) && $status==4 && $me['is_push']) {
                            ?> html += '<li><a href="#" class="modal_box_news"><i class="icon-plus"></i> Thêm vào Hộp tin</a></li>';<?php
                        } ?>
    
    <?php if (isset($status) && in_array($status, array(0, 2)) and $me['level'] <= 2) {
                            if (isset($is_trash) && $is_trash==1) {
                                ?>
    html += '<li><a class="n_href" href="" data-href="/news/restore?id="><i class="icon-undo"></i> Phục hồi</a></li>';
    html += '<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa bài này?\')" class="n_href" href="" data-href="/news/delete?id="><i class="icon-remove"></i> Xóa vĩnh viễn</a></li>';
    <?php
                            } else {
                                ?>
    html += '<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa bài này?\')" class="n_href" href="" data-href="/news/trash?id="><i class="icon-trash"></i> Cho vào thùng rác</a></li>';
    <?php
                            }
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
            <?php if (isset($status) && $status!=4) { ?>
                $(this).attr('href', $(this).data('href')+id+'.html?xemnhanh');
            <?php } else { ?>
                $(this).attr('href', $(this).data('href')+id+'.html');
            <?php } ?>
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