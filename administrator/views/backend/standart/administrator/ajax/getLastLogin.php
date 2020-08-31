<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Hoạt động truy cập</h3>
    <div style="font-family: Arial;font-weight: normal;font-size: 14px;color: #666;margin: 8px 0 0;letter-spacing: 1px;">Tài khoản: <?=$oneUser['fullname']?></div>
</div>
<div class="modal-body">
    <table style="width: 100%;" class="table table-striped table-bordered table-hover">
        <?php $i=0; if ($last_login) {
    foreach ($last_login as $one) {
        $i++; ?>
        <tr>
            <td style="text-align: center; font-size: 27px; color: #888;"><?=$i?></td>
            <td style="font-family: Arial;color: #555;letter-spacing: 1px;font-size: 14px;"><?=date('d.m.Y - H:i', $one)?></td>
        </tr>
        <?php
    }
} ?>
    </table>
</div>