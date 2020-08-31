<div class="modal-footer" style="padding: 5px 15px;">
    <button type="button" class="btn red mini" data-dismiss="modal" aria-hidden="true"><i class="icon-eject"></i> Đóng</button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-striped" style="font-family: Arial;">
		<thead>
			<tr>
				<th>Đối tác</th>
				<th>Thời hạn</th>
				<th>Kích thước</th>
                <th>Trạng thái</th>
			</tr>
		</thead>
		<tbody>
            <?php if ($all) {
    foreach ($all as $id) {
        $one = $clsCode->getOne($id); ?>
			<tr>
				<td><a href="#" data-id="<?=$id?>" class="btn_addcode"><?=$one['title']?></a></td>
				<td><span class="badge badge-info f_todate"><?=date('d/m/Y', strtotime($one['todate']))?></span></td>
				<td><span class="label"><?=($one['width'].'x'.$one['height'])?></span></td>
                <td class="f_note"><span class="badge badge-warning"><?=($one['is_show']?((strtotime($one['todate'])<time())?'HẾT HẠN':''):'ĐANG ẨN')?></span></td>
			</tr>
			<?php
    }
} ?>
		</tbody>
	</table>
</div>