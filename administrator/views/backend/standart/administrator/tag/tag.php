<?php $mod = current_method()['mod']; ?>
<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Quản lý từ khóa
                        <?php if ($_GET['is_trash']==1) {
    ?>
                            <small style="font-family: Arial;">Thùng rác <i class="icon-trash"></i></small>
                            <a href="/<?php echo $mod ?>" class="btn green pull-right"><i class="icon-reorder"></i> Danh sách</a>
                        <?php
} else {
        ?>
                            <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
                            <a href="/<?php echo $mod ?>?is_trash=1" class="btn pull-right"><i class="icon-trash"></i> Thùng rác</a>
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
							<input type="hidden" name="mod" value="tag" />
                            <input type="hidden" name="act" value="default" />
                            <input name="keyword" type="text" placeholder="Tìm kiếm ..." class="m-wrap span2" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" style="background: #FFF;" />
                            <select name="is_pick" class="m-wrap  span2">
                                <option value="">Tất cả</option>
                                <option value="1" <?php if (isset($_GET['is_pick']) && $_GET['is_pick']) {
        echo 'selected="selected"';
    } ?>>Từ khóa bản sắc</option>
                            </select>
							<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
                            <input type="hidden" name="is_trash" value="0" />
                            <input type="hidden" name="page" value="1" />
						</form>
                    </div>
                    
                    <?php if ($listItem) {
        ?>
                    <form action="" method="post" style="overflow-x: scroll;">
                    <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
						<thead>
							<tr>
								<th class="background_white" style="min-width: 200px;">Tiêu đề</th>
                                <th class="background_white">Link</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($listItem as $oneItem) {
            $oneItem=$clsClassTable->getOne($oneItem); ?>
							<tr class="odd gradeX">
								<td>
                                    <div class="field_title">
                                        <a href="<?php echo '/'.$mod.'/edit?id='.$oneItem[$pkeyTable]; ?>"><?php echo $oneItem['title'] ?></a>
                                    </div>
                                </td>
                                <td><a style="text-decoration: none;" target="_blank" href="<?php $link = $clsClassTable->getLink($oneItem[$pkeyTable], $oneItem);
            $link=str_replace('http://cms', 'http://www', $link);
            echo $link; ?>"><code><?php echo $link ?></code></a></td>
							</tr>
                            <?php
        } ?>
						</tbody>
					</table>
                    </form>
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