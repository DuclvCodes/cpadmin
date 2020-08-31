<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						List <?php echo $classTable ?> <small>module manager</small>
                        <a id="btn_import" href="#" class="btn green pull-right"><i class="icon-list-alt"></i> &nbsp; Import CSV From Google Webmasters Tools</a>
                        <form action="" method="post" class="hide" enctype="multipart/form-data">
                            <input id="inp_file" type="file" name="file" />
                        </form>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            $('#btn_import').click(function(){
                                $('#inp_file').click();
                                return false;
                            });
                            $('#inp_file').change(function(){
                                if($(this).val()!='') $(this).parents('form').submit();
                            });
                        });
                        </script>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>"><?php echo $classTable ?></a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Danh sách</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    
                    
                    <?php if ($listItem) {
    ?>
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="sorting">Tiêu đề</th>
                                <th class="sorting" style="width:23px;">ID</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
        $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td><a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a></td>
                                <td class="filed_id"><?php echo $oneItem[$pkeyTable] ?></td>
							</tr>
                            <?php
    } ?>
						</tbody>
					</table>
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