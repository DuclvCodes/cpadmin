<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            
            <br />
            <?php getBlock('tab_chart') ?>
            
			<div class="row-fluid">
				<form class="form-search" action="" method="get" style="background: #f0f6fa; padding: 12px 14px;">
					<input type="hidden" name="mod" value="chart" />
                    <input type="hidden" name="act" value="tops" />
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
                    <?php echo $clsCategory->getSelect('category_id', isset($_GET['category_id']) ? $_GET['category_id'] : '', 'm-wrap  span2', false, ' --- Chuyên mục --- ') ?>
                    <select name="type_post" class="m-wrap span2 hide">
                        <option value="">--- Tất cả ---</option>
                        <option value="1" <?php if (isset($_GET['type_post']) and $_GET['type_post']==1) {
    echo 'selected="selected"';
} ?>>Sản xuất hiện trường</option>
                        <option value="2" <?php if (isset($_GET['type_post']) and $_GET['type_post']==2) {
    echo 'selected="selected"';
} ?>>Sản xuất</option>
                        <option value="3" <?php if (isset($_GET['type_post']) and $_GET['type_post']==3) {
    echo 'selected="selected"';
} ?>>Tổng hợp</option>
                        <option value="4" <?php if (isset($_GET['type_post']) and $_GET['type_post']==4) {
    echo 'selected="selected"';
} ?>>Khai thác</option>
                        <option value="5" <?php if (isset($_GET['type_post']) and $_GET['type_post']==5) {
    echo 'selected="selected"';
} ?>>Bài dịch</option>
                    </select>
                    <select name="type_is" class="m-wrap span2">
                        <option value="">--- Tất cả ---</option>
                        <option value="1" <?php if (isset($_GET['type_is']) and $_GET['type_is']==1) {
    echo 'selected="selected"';
} ?>>Tin ảnh</option>
                        <option value="2" <?php if (isset($_GET['type_is']) and $_GET['type_is']==2) {
    echo 'selected="selected"';
} ?>>Tin video</option>
                        <option value="3" <?php if (isset($_GET['type_is']) and $_GET['type_is']==3) {
    echo 'selected="selected"';
} ?>>Tin thường</option>
                    </select>
                    <?php echo $clsUser->getSelect('user_id', isset($_GET['user_id']) ? $_GET['user_id'] : '', 'm-wrap span2', false, '--- Thành viên ---', 'fullname') ?>
                    
                    <?php echo $clsUser->getSelect('push_user', isset($_GET['push_user']) ? $_GET['push_user'] : '', 'm-wrap span2', false, '--- Người XB ---', 'fullname') ?>
					<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
				</form>
			</div>
            
            <?php if ($listItem) {
    ?>
            <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1" style="font-family: Arial;">
				<thead>
					<tr>
						<th class="background_white">Tiêu đề</th>
                        <th class="background_white" style="min-width: 48px;">Lượt xem</th>
                        <th class="background_white" style="width: 70px;">Chuyên mục</th>
                        <?php if (isset($_GET['status']) && $_GET['status']==4) {
        ?>
							<th class="background_white" style="">Xuất bản</th>
                        <?php
    } else {
        ?>
                            <th class="background_white" style="width: 67px;">Ngày tạo</th>
                            <th class="background_white" style="width: 180px;">Xuất bản</th>
                        <?php
    } ?>
					</tr>
				</thead>
				<tbody>
                    <?php foreach ($listItem as $id) {
        $oneItem=$clsClassTable->getOne($id); ?>
					<tr class="odd gradeX">
						<td>
                            <div class="field_title">
                                <?php if ($oneItem['user_id']) {
            ?><span class="label label-success field_fullname"><?php echo $clsUser->getFullName($oneItem['user_id']) ?></span>
                                <?php
        } else {
            ?><span class="label label-important field_fullname"><?php echo $clsSource->getTitle($oneItem['source_id']) ?></span><?php
        } ?>
                                <a target="_blank" href="<?php echo str_replace('cms.', 'www.', $clsClassTable->getLink($oneItem[$pkeyTable])); ?>" class="btn_title"><?=$oneItem['title']?$oneItem['title']:'<i>Bài chưa nhập tiêu đề ...</i>'?></a>
                                <?php if ($oneItem['is_photo']) {
            echo '<i class="icon-camera tkp_icon_title"></i>';
        } ?>
                                <?php if ($oneItem['is_video']) {
            echo '<i class="icon-facetime-video tkp_icon_title"></i>';
        } ?>
                                <?php if (strtotime($oneItem['push_date'])>=time()) {
            echo '<b style="margin-left: 8px; font-size: 11px; color: #e02222;">Hẹn giờ: '.date('H:i d/m', strtotime($oneItem['push_date'])).'</b>';
        } ?>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn mini red-stripe"><?php echo toString($oneItem['views']) ?></a>
                        </td>
                        <td><span class="label label-success field_cat tooltips" data-original-title="<?php $parent_id = $clsCategory->getParentID($oneItem['category_id']);
        if ($parent_id) {
            echo $clsCategory->getTitle($parent_id).' » ';
        }
        $cat_title = $clsCategory->getTitle($oneItem['category_id']);
        echo $cat_title; ?>"><?php echo $cat_title ?></span></td>
						<?php if (isset($_GET['status']) && $_GET['status']==4) {
            ?>
                            <td class="center field_date"><?php echo date('H:i - d.m', strtotime($oneItem['push_date'])) ?> <span style="padding: 0 8px;">bởi</span> <b><?php echo $clsUser->getLashName($oneItem['push_user']) ?></b></td>
                        <?php
        } else {
            ?>
                            <td class="center field_date"><?php echo date('H:i - d.m', strtotime($oneItem['reg_date'])); ?></td>
                            <td class="center field_date"><?php echo date('H:i - d.m', strtotime($oneItem['push_date'])) ?> <span style="padding: 0 8px;">bởi</span> <b><?php echo $clsUser->getLashName($oneItem['push_user']) ?></b></td>
                        <?php
        } ?>
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