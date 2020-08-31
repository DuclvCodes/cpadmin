<div class="modal-footer" style="padding: 5px 15px;">

    <button type="button" class="btn red mini" data-dismiss="modal" aria-hidden="true"><i class="icon-eject"></i> Đóng</button>

</div>

<div class="modal-body" id="modal_body_mom_preview">

    <?php $obj = json_decode($one['data']); if ($obj) {
    foreach ($obj as $key=>$o) {
        ?>

    <p><span class="label label-success"><?=strtoupper($key)?></span> <?=$o?></p>

    <?php
    }
} ?>

</div>