<?php if ($allItem) {
    foreach ($allItem as $id) {
        $one = $clsClassTable->getOne($id); ?>
<li><a data-id="<?php echo $id ?>" data-image="<?php echo $clsClassTable->getImage($id, 174, 104) ?>" href="<?php echo str_replace('cms.', 'www.', $clsClassTable->getLink($id)) ?>" target="_blank"><?php echo $one['title'] ?></a></li>
<?php
    }
} else {
    echo 'Không có kết quả nào. Thử lại với từ khóa khác ...';
} ?>