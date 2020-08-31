<?php $mod = current_method()['mod']; ?>

	
	<div class="page-container row-fluid">
    <?php getBlock('menu') ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title">Bài của tôi</h3>
                </div>
            </div>
            <form class="form-search" action="" method="get" style="text-align: right;">
                <input type="hidden" name="mod" value="<?=$mod?>" />
                <input type="hidden" name="act" value="<?=$act?>" />
                <select name="status" class="m-wrap span2">
                    <option value="0">--- Trạng thái ---</option>
                    <option <?=$_GET['status']==1?'selected="selected"':''?> value="1">Đang chờ duyệt</option>
                    <option <?=$_GET['status']==2?'selected="selected"':''?> value="2">Bị trả về</option>
                    <option <?=$_GET['status']==3?'selected="selected"':''?> value="3">Chờ XB</option>
                    <option <?=$_GET['status']==4?'selected="selected"':''?> value="4">Đã xuất bản</option>
                    <option <?=$_GET['status']==5?'selected="selected"':''?> value="5">Đã gỡ</option>
                </select>
                <input type="text" name="keyword" value="<?=$_GET['keyword']?>" class="m-wrap span3" placeholder="Keyword" style="background: #FFF;">
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
                <button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i> Lọc</button>
                <button class="btn green" style="float: right; margin: 0 5px;" onclick="tableToExcel('sample_1', 'Chart', 'Thongketin.xls'); return false;"><i class="icon-download-alt"></i> Tải Excel</button>
            </form>
            <?php if ($listItem) {
    ?>
            <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1" style="font-family: Arial;">
                <thead>
                    <tr>
                        <th class="background_white">STT</th>
                        <th class="background_white">Tiêu đề</th>
                        <th class="background_white">Tác giả</th>
                        <th class="background_white">Trạng thái</th>
                        <th class="background_white" style="min-width: 48px;">Lượt xem</th>
                        <th class="background_white" style="width: 70px;">Chuyên mục</th>
                        <th class="background_white" style="width: 90px;"><?=(isset($_GET['status']) && $_GET['status']==4)?'Ngày XB':'Ngày viết'?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=($cursorPage-1)*50;
    foreach ($listItem as $id) {
        $oneItem=$clsClassTable->getOne($id);
        $i++; ?>
                    <tr class="odd gradeX">
                        <td>
                            <span class="label"><?=($i<10)?'0'.$i:$i?></span>
                        </td>
                        <td>
                            <div class="field_title">
                                <a target="_blank" href="<?php echo str_replace(ADMIN_DOMAIN, DOMAIN, $clsClassTable->getLink($oneItem[$pkeyTable])); ?>" class="btn_title"><?=$oneItem['title']?$oneItem['title']:'<i>Bài chưa nhập tiêu đề ...</i>'?></a>
                                <?php if ($oneItem['is_photo']) {
            echo '<i class="icon-camera exp_icon_title"></i>';
        } ?>
                                <?php if ($oneItem['is_video']) {
            echo '<i class="icon-facetime-video exp_icon_title"></i>';
        } ?>
                                <?php if (strtotime($oneItem['push_date'])>=time()) {
            echo '<b style="margin-left: 8px; font-size: 11px; color: #e02222;">Hẹn giờ: '.date('H:i d/m', strtotime($oneItem['push_date'])).'</b>';
        } ?>
                            </div>
                        </td>
                        <td>
                            <?=$oneItem['signature']; ?>
                        </td>
                        <td><?=$clsClassTable->getTitleStatus($oneItem['status'])?></td>
                        <td>
                            <a href="#" class="btn mini red-stripe"><?php echo toString($oneItem['views']) ?></a>
                        </td>
                        <td><span class="label label-success field_cat tooltips" data-original-title="<?php $parent_id = $clsCategory->getParentID($oneItem['category_id']);
        if ($parent_id) {
            echo $clsCategory->getTitle($parent_id).' » ';
        }
        $cat_title = $clsCategory->getTitle($oneItem['category_id']);
        echo $cat_title; ?>"><?php echo $cat_title ?></span></td>
                        <td class="center field_date"><?=(isset($_GET['status']) && $_GET['status']==4)?date('H:i - d/m/Y', strtotime($oneItem['push_date'])):date('H:i - d/m/Y', strtotime($oneItem['reg_date']))?></td>
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
                    Tổng cộng có <b><?php echo toString($totalPost) ?></b> bài viết và <b><?=toString($totalViews)?></b> views
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
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->    
</div>
<a id="dlink"  style="display:none;"></a>
<script type="text/javascript">
var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
    return function (table, name, filename) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

        document.getElementById("dlink").href = uri + base64(format(template, ctx));
        document.getElementById("dlink").download = filename;
        document.getElementById("dlink").click();

    }
})()
</script>