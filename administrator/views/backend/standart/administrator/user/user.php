<?php $mod = current_method()['mod']; ?>
<style>
#sample_1 td.time {color: #999; font-size: 11px;}
.lbl_online {width: 10px;height: 10px;background: #5eb95e;display: inline-block;border-radius: 10px !important;margin-left: 5px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Quản lý nhân sự
                        <?php if (isset($_GET['is_trash']) and $_GET['is_trash'] ==1) {
    ?>
                            <small style="font-family: Arial;">Thùng rác <i class="icon-trash"></i></small>
                            <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-reorder"></i> Danh sách</a>
                        <?php
} else {
        ?>
                            <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm nhân sự</a>
                            <a href="/<?php echo $mod ?>?is_trash=1" class="btn pull-right"><i class="icon-trash"></i> Thùng rác</a>
                        <?php
    } ?>
                        <div class="clearfix"></div>
					</h3>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <div class="row-fluid">
                        <?php if ($listItem) {
        ?>
                        
                        <div class="dataTables_filter">
                            <label>Tìm kiếm: <input type="text" class="m-wrap small" /></label>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div style="overflow-x: scroll;">
                        <table class="table table-striped table-bordered table-hover act_default" id="sample_1">
    						<thead>
    							<tr>
                                    <th class="background_white" style="width: 20px;">STT</th>
    								<th class="background_white" style="min-width: 150px;">Họ tên</th>
                                    <th class="background_white">Nhóm</th>
                                    <th class="background_white">Tài khoản</th>
                                    <th class="background_white">Email</th>
                                    <th class="background_white">Lần truy cập cuối</th>
    							</tr>
    						</thead>
    						<tbody>
                                <?php foreach ($listItem as $key=>$oneItem) {
            $oneItem=$clsClassTable->getOne($oneItem); ?>
    							<tr class="odd gradeX">
    								<td><?=($key+1)?><div class="hide nsearch"><?php echo str_replace('-', ' ', toSlug($oneItem['fullname'])).' '.$oneItem['username'].' '.$oneItem['email'] ?></div></td>
                                    <td>
                                        <img src="<?php echo $clsClassTable->getImage($oneItem[$pkeyTable], 29, 29, 'image', '/files/user/noavatar.jpg') ?>" width="29" height="29" />
                                        <a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo ($oneItem['fullname'] != '') ? $oneItem['fullname'] : '_'; ?></a>
                                        <?php if ($clsClassTable->is_online($oneItem[$pkeyTable])) {
                ?><a href="<?=$oneItem['status_link']?>" target="_blank" class="lbl_online tooltips" data-original-title="<?=$oneItem['status']?>"></a><?php
            } ?>
                                    </td>
                                    <td><span class="label label-info"><?=$clsGroup->getTitle($oneItem['group_id'])?></span></td>
                                    <td><span class="label label-success"><?php echo $oneItem['username'] ?></span></td>
                                    <td><a href="mailto:<?php echo $oneItem['email'] ?>" class="btn mini red-stripe"><?php echo $oneItem['email'] ?></a></td>
                                    <td class="time"><a data-uid="<?=$oneItem[$pkeyTable]?>" href="#" class="tooltips btn_last_login" data-original-title="Xem hoạt động truy cập của <?=$oneItem['fullname']?>"><?=$oneItem['last_login']?time_ago($oneItem['last_login']):''?></a></td>
    							</tr>
                                <?php
        } ?>
    						</tbody>
    					</table>
                        </div>
                        <?php
    } else {
        echo '<p style="font-size: 45px;color: #999;margin: 68px 0;text-align: center; font-family: \'Open Sans\'">Không có bản ghi nào!</p>';
    } ?>
                    </div>
                    <br />
                    <br />
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->
</div>
<div id="modal_last_login" class="modal hide fade" data-width="300"></div>
<script type="text/javascript" src="<?php echo BASE_ASSET ?>/scripts/str_replace.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var $modal_last_login = $('#modal_last_login');
    $('.btn_last_login').click(function(){
        var id = $(this).attr('data-uid');
        $('body').click();
        $('body').modalmanager('loading');
        $modal_last_login.load('/ajax/getLastLogin?uid='+id, '', function(){
            $modal_last_login.modal().on("hidden", function() {
                $modal_last_login.empty();
            });
        });
        return false;
    });
    $('.dataTables_filter input').keyup(function(){
        $('table#sample_1 tbody tr').hide();
        var s = $(this).val();
        s=str_replace('à','a',s);s=str_replace('á','a',s);s=str_replace('ạ','a',s);s=str_replace('ả','a',s);s=str_replace('ã','a',s);s=str_replace('â','a',s);s=str_replace('ầ','a',s);s=str_replace('ấ','a',s);s=str_replace('ậ','a',s);s=str_replace('ẩ','a',s);s=str_replace('ẫ','a',s);s=str_replace('ă','a',s);
        s=str_replace('ằ','a',s);s=str_replace('ắ','a',s);s=str_replace('ặ','a',s);s=str_replace('ẳ','a',s);s=str_replace('ẵ','a',s);s=str_replace('è','e',s);s=str_replace('é','e',s);s=str_replace('ẹ','e',s);s=str_replace('ẻ','e',s);s=str_replace('ẽ','e',s);s=str_replace('ê','e',s);s=str_replace('ề','e',s);
        s=str_replace('ế','e',s);s=str_replace('ệ','e',s);s=str_replace('ể','e',s);s=str_replace('ễ','e',s);s=str_replace('ì','i',s);s=str_replace('í','i',s);s=str_replace('ị','i',s);s=str_replace('ỉ','i',s);s=str_replace('ĩ','i',s);s=str_replace('ò','o',s);s=str_replace('ó','o',s);s=str_replace('ọ','o',s);
        s=str_replace('ỏ','o',s);s=str_replace('õ','o',s);s=str_replace('ô','o',s);s=str_replace('ồ','o',s);s=str_replace('ố','o',s);s=str_replace('ộ','o',s);s=str_replace('ổ','o',s);s=str_replace('ỗ','o',s);s=str_replace('ơ','o',s);s=str_replace('ờ','o',s);s=str_replace('ớ','o',s);s=str_replace('ợ','o',s);
        s=str_replace('ở','o',s);s=str_replace('ỡ','o',s);s=str_replace('ù','u',s);s=str_replace('ú','u',s);s=str_replace('ụ','u',s);s=str_replace('ủ','u',s);s=str_replace('ũ','u',s);s=str_replace('ư','u',s);s=str_replace('ừ','u',s);s=str_replace('ứ','u',s);s=str_replace('ự','u',s);s=str_replace('ử','u',s);
        s=str_replace('ữ','u',s);s=str_replace('ỳ','y',s);s=str_replace('ý','y',s);s=str_replace('ỵ','y',s);s=str_replace('ỷ','y',s);s=str_replace('ỹ','y',s);s=str_replace('đ','d',s);
        $("table#sample_1 tbody tr div.nsearch:contains("+s+")").parents('tr').show();
    });
});
</script>