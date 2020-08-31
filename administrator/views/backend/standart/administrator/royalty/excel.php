<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.field_cat {white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis;display: block;max-width: 70px;}
.field_date {font-size: 11px; color: #999;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
select.m-wrap.span2 {width: 12.52991452991453%;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            
			<h3 class="page-title">Nhuận Bút</h3>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php if ($listItem) {
    ?>
                    <div class="alert alert-info">
						<p id="txt_downloading">Downloading ...</p>
					</div>
                    <table class="table table-striped table-bordered table-hover act_default" id="sample_1" style="display: none;">
						<thead>
							<tr>
								<th class="background_white">STT</th>
                                <th class="background_white">Tiêu đề</th>
                                <th class="background_white" style="width: 78px;">Chuyên mục</th>
                                <th class="background_white">Tác giả</th>
                                <th class="background_white">Người XB</th>
                                <th class="background_white">Loại bài</th>
                                <th class="background_white" style="width: 115px;">Ngày xuất bản</th>
                                <th class="background_white">Views</th>
                                <th class="background_white" style="width: 120px;">Nhuận bút</th>
                                <th class="hide">Ghi chú</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                            $total_views=0;
    $total_money=0;
    foreach ($listItem as $key=>$oneItem) {
        $oneItem=$clsClassTable->getOne($oneItem);
        $total_views+=$oneItem['views'];
        $total_money+=$oneItem['royalty']; ?>
							<tr class="odd gradeX">
                                <td><?php echo $key+1+($cursorPage-1)*$rpp ?></td>
								<td><a target="_blank" href="<?php echo str_replace('cms.', 'www.', $clsClassTable->getLink($oneItem[$pkeyTable])) ?>"><?php echo $oneItem['title'] ?></a></td>
                                <td><?php echo $clsCategory->getTitle($oneItem['category_id']) ?></td>
                                <td><?php echo $clsUser->getFullName($oneItem['user_id']) ?></td>
                                <td><?php echo $clsUser->getFullName($oneItem['push_user']) ?></td>
                                <td><?php echo $clsClassTable->getType($oneItem['type_post']) ?></td>
                                <td><?php echo date('H:i - d/m/Y', strtotime($oneItem['push_date'])); ?></td>
                                <td><?php echo $oneItem['views'] ?></td>
                                <td><?=$oneItem['royalty']?></td>
                                <td class="hide"><?=$oneItem['royalty_error']?></td>
							</tr>
                            <?php
    } ?>
                            <tr>
                                <td colspan="6"><strong>Tổng cộng</strong></td>
                                <td><?=$total_views?></td>
                                <td><?=$total_money?></td>
                                <td></td>
                            </tr>
						</tbody>
					</table>
                    
                    <?php
} else {
        ?>
                    <p style="text-align: center; font-size: 32px; color: #999; margin-top: 60px; font-family: 'Open Sans';">Không có kết quả</p>
                    <?php
    } ?>
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
$(document).ready(function(){
    tableToExcel('sample_1', '<?php echo date('m/Y', $time) ?>', '<?=$filename?>.xls');
    $('#txt_downloading').text('Đã download xong.');
});
</script>