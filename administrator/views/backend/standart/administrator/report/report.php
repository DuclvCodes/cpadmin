<style>
#sample_1 td {text-align: center;}
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
.bg_gray {background: #f5f5f5 !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
			<?php getBlock('tab_report') ?>
            
            <div class="row-fluid">
				<form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
					<input type="hidden" name="mod" value="report" />
					<div class="btn form-date-range">
						<i class="icon-calendar"></i>
						&nbsp;<span></span> 
						<b class="caret"></b>
                        <input name="txt_start" value="<?=$start?>" class="txt_start" type="hidden" />
                        <input name="txt_end" value="<?=$end?>" class="txt_end" type="hidden" />
					</div>
					<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
                    <button id="btn_print_report" class="btn red" style="float: right;"><i class="icon-print"></i> In</button>
                    <button class="btn green" style="float: right; margin: 0 5px;" onclick="tableToExcel('sample_1', 'Report', 'Bao cao so luong bai viet chuyen muc.xls'); return false;"><i class="icon-download-alt"></i> Tải Excel</button>
                    <button id="btn_save_report" class="btn blue" style="float: right;"><i class="icon-download-alt"></i> Tải Word</button>
				</form>
			</div>
            <div id="wrap_content_report">
                <h1 style="text-align: center;">Báo cáo số lượng bài viết theo chuyên mục</h1>
                <h4 style="text-align: center;">(Từ ngày <?=date('d/m/Y', strtotime($start))?> ĐẾN NGÀY <?=date('d/m/Y', strtotime($end))?>)</h4>
                <br />
    			<div class="row-fluid" style="font-family: Arial;">
    				<div class="span12">
    					<?php if ($allCategory) {
    ?>
                        <table class="table table-striped table-bordered table-hover act_default" id="sample_1">
    						<thead>
    							<tr>
    								<th class="background_white">Chuyên mục</th>
                                    <?php $allType = $clsNews->getAllType();
    if ($allType) {
        foreach ($allType as $key=>$one) {
            ?>
                                    <th class="background_white"><?=$one?></th>
                                    <?php
        }
    } ?>
                                    <th class="background_white">Khác</th>
                                    <th class="bg_gray">Tổng cộng</th>
                                    <th class="background_white">Pageviews</th>
    							</tr>
    						</thead>
    						<tbody>
                                <?php
                                    $total = 0;
    $total_views = 0;
    foreach ($allCategory as $id) {
        $oneCat=$clsCategory->getOne($id);
        $allCat = $clsCategory->getChild($id);
        $allCat[] = $id;
                                    
        $cons = 'is_trash=0 and status=4 and category_id in('.implode(',', $allCat).') and push_date > "'.date('Y-m-d', strtotime($start)).' 00:00:00" and push_date < "'.date('Y-m-d', strtotime($end)).' 23:59:59"';
        $views = $clsNews->getSum('views', $cons, 'CMS');
        $total_views += $views; ?>
    							<tr class="odd gradeX">
    								<td style="text-align: left !important;"><?php echo $oneCat['title'] ?></td>
                                    <?php $t=0;
        if ($allType) {
            foreach ($allType as $key=>$one) {
                ?>
                                    <td><?php $f = $clsNews->getCount($cons.' and type_post='.$key, true, 'CMS');
                echo $f;
                $t+=$f; ?></td>
                                    <?php
            }
        } ?>
                                    <td><?php $f = $clsNews->getCount($cons.' and type_post='.$key, true, 'CMS');
        echo $f;
        $t+=$f; ?></td>
                                    <td class="bg_gray"><?php $total+=$t;
        echo toString($t); ?></td>
                                    <td><?=toString($views)?></td>
    							</tr>
                                <?php
    } ?>
                                <tr>
                                    <td style="text-align: right !important;" colspan="<?=sizeof($allType)+2?>">Tổng cộng</td>
                                    <td class="bg_gray"><?php echo toString($total) ?></td>
                                    <td><?=toString($total_views)?></td>
                                </tr>
    						</tbody>
    					</table>
                        <?php
} else {
        echo '<p>Không có bản ghi nào!</p>';
    } ?>
    				</div>
    			</div>
            </div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<script src="<?php echo BASE_ASSET ?>/plugins/jquery.wordexport/FileSaver.js"></script>
<script src="<?php echo BASE_ASSET ?>/plugins/jquery.wordexport/jquery.wordexport.js"></script>
<script src="<?php echo BASE_ASSET ?>/plugins/jQuery.print.js"></script>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_save_report').unbind().click(function(){
            $("#wrap_content_report").wordExport('Bao cao so luong bai viet theo chuyen muc');
            return false;
        });
        $('#btn_print_report').unbind().click(function(){
            $.print("#wrap_content_report");
            return false;
        });
    });
</script>