<?php $mod = current_method()['mod']; ?>
<style>
#sample_1 td {text-align: center; padding: 8px 5px; font-size: 12px;}
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
td.left {text-align: left !important;}
td.right {text-align: right !important;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            
            <br />
            <?php getBlock('tab_chart') ?>
            
			<div class="row-fluid">
				<div class="span6">
					<h3 class="page-title" style="margin-top: 0;">
						<?=$clsCategory->getTitle($category_id)?> <small style="font-family: Arial;">Thống kê <?=$arr_field[$field]?> (đơn vị: <?=$field_unit?>)</small>
					</h3>
				</div>
                <div class="span6">
                    <div style="text-align: right;">
                        <form action="" method="post" id="frm_chart">
                            <?php echo $clsCategory->getSelect('category_id', $category_id, 'm-wrap span3" style="margin-bottom: 0;', false, '', false); ?>
                            <select name="field" class="m-wrap span3" style="margin-bottom: 0;">
                                <option <?=($field=='views')?'selected="selected"':''?> value="views">Lượt views</option>
                                <option <?=($field=='visit')?'selected="selected"':''?> value="visit">Visitor</option>
                                <option <?=($field=='exit_rate')?'selected="selected"':''?> value="exit_rate">Tỷ lệ thoát</option>
                                <option <?=($field=='time_on_page')?'selected="selected"':''?> value="time_on_page">Thời gian trên trang</option>
                            </select>
                            <div class="btn form-date-range" data-left="true">
        						<i class="icon-calendar"></i>
        						&nbsp;<span></span> 
        						<b class="caret"></b>
                                <input name="txt_start" value="<?php echo $start ?>" class="txt_start" type="hidden" />
                                <input name="txt_end" value="<?php echo $end ?>" class="txt_end" type="hidden" />
        					</div>
                            <button type="submit" class="btn blue btn_submit"><i class="m-icon-swapright m-icon-white"></i></button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					<?php $_start = strtotime($start); $_end = strtotime($end); $_start_end = ($_end-$_start)/86400; ?>
                    <div style="text-align: right; margin-bottom: 5px;">
                        <button onclick="tableToExcel('sample_1', '<?php echo date('d/m/Y', $_start) ?>', 'GDO-<?php echo date('Y-m-d', $_start) ?>.xls')" class="btn mini red"><i class="icon-th"></i> Xuất Excel</button>
                        <button onclick="printData()" class="btn red mini"><i class="icon-print"></i> In</button>
                    </div>
                    <div style="overflow-x: auto;">
                        <?php $arrDay=array('Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy','Chủ nhật'); ?>
                        <table class="table table-striped table-bordered table-hover act_default" id="sample_1">
    						<thead>
    							<tr>
                                    <th class="background_white">Tuần \ Thứ</th>
    								<?php for ($i=0; $i<=6; $i++) {
    ?>
                                    <th class="background_white"><?php echo $arrDay[$i]; ?></th>
                                    <?php
} ?>
                                    <th class="background_white"><?=($field=='views' || $field=='visit')?'Tổng':'TB'?></th>
    							</tr>
    						</thead>
    						<tbody>
                                <?php
                                $total=0;
                                $stt_total = 0;
                                if (date('D', $_start) === 'Mon') {
                                    $monday=$_start;
                                } else {
                                    $monday = strtotime('last monday', $_start);
                                }
                                if (date('D', $_end) === 'Sun') {
                                    $sunday=$_end;
                                } else {
                                    $sunday = strtotime('next sunday', $_end);
                                }
                                for ($time=$monday; $time<=$sunday; $time=$time+86400*7) {
                                    ?>
    							<tr class="odd gradeX">
    								<td class="left"><?php $t_row=0;
                                    echo date('d/m/y', $time).' - '.date('d/m/y', $time+86400*6) ?></td>
                                    <?php $stt_trow=0;
                                    for ($i=0; $i<=6; $i++) {
                                        ?>
                                    <td class="right"><?php
                                        $_day = $time+86400*$i;
                                        if ($_day<$_start || $_day>$_end || $_day>time()) {
                                            echo '_';
                                        } else {
                                            $year = date('Y', $_day);
                                            $month = date('m', $_day);
                                            $day = date('d', $_day);
                                            $views = $results[$year][$month][$day];
                                            $t_row+=$views;
                                            if ($field=='exit_rate' || $field=='time_on_page') {
                                                echo round($views, 2);
                                            } else {
                                                echo toString($views);
                                            }
                                            $stt_trow++;
                                        } ?></td>
                                    <?php
                                    } ?>
                                    <td class="right"><?php
                                        if ($field=='exit_rate' || $field=='time_on_page') {
                                            $t_row = round($t_row/$stt_trow, 2);
                                            echo round($t_row, 2);
                                        } else {
                                            echo toString($t_row);
                                        }
                                    $total+=$t_row;
                                    $stt_total++; ?>
                                    </td>
    							</tr>
                                <?php
                                } ?>
                                <tr>
                                    <td style="text-align: right !important;" colspan="8"><?=($field=='views' || $field=='visit')?'Tổng cộng':'Trung bình'?> (<?=$field_unit?>)</td>
                                    <td class="right"><?php
                                        if ($field=='exit_rate' || $field=='time_on_page') {
                                            $total = round($total/$stt_total, 2);
                                            echo round($total, 2);
                                        } else {
                                            echo toString($total);
                                        } ?>
                                    </td>
                                </tr>
    						</tbody>
    					</table>
                    </div>
                    <br />
                    <br />
                    <br />
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
<a id="dlink"  style="display:none;"></a>
<script type="text/javascript">
function printData() {
   var divToPrint=document.getElementById("sample_1");
   newWin= window.open("");
   newWin.document.write('<link href="<?php echo BASE_ASSET ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/><h2>Thống kê toàn trang</h2>'+divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook><'+'/xml><![endif]--><'+'/head><body><table>{table}<'+'/table><'+'/body><'+'/html>'
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