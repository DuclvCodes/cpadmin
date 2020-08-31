<?php if ($allItem) {
    foreach ($allItem as $id) {
        $one = $clsClassTable->getOne($id); ?>
<li><input type="hidden" name="<?php echo $_POST['name'] ?>[]" value="<?php echo $id ?>" /><a href="<?php echo $clsClassTable->getLink($id) ?>" target="_blank"><?php echo $one['title'] ?></a> <button class="btn mini red js_remove" style="height: 14px;padding: 0 0 1px;margin-left: 5px;"><i class="icon-remove"></i></button></li>
<?php
    }
} else {
    echo 'Không có kết quả nào. Thử lại với từ khóa khác ...';
} ?>