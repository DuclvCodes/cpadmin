<tr class="hide" id="tr_ids" data-ids="<?=$all?implode(',', $all):''?>"></tr>
<?php if ($all) {
    foreach ($all as $id) {
        $oneItem=$clsQuestion->getOne($id); ?>
<tr class="odd gradeX" id="tr_question_<?=$oneItem['question_id']?>">
	<td>
        <div class="field_title">
            <a href="mailto:<?=$oneItem['email']?>"><span class="label label-success"><?=$oneItem['fullname']?></span></a>
            <span><?php echo $oneItem['question'] ?></span>
            <span style="color: #999; font-size: 11px; font-style: italic;" title="<?=date('d-m-Y H:i', strtotime($oneItem['reg_date']))?>"> (<?=time_ago(strtotime($oneItem['reg_date']))?>)</span>
        </div>
    </td>
    <td>
        <div class="form-horizontal">
            <a data-id="<?=$oneItem['question_id']?>" href="#" class="btn green mini btn_submit_gltt"><i class="icon-ok"></i> Trả lời</a>
            <a data-id="<?=$oneItem['question_id']?>" href="#" class="btn red mini btn_remove_gltt"><i class="icon-remove"></i> Xóa</a>
        </div>
    </td>
</tr>
<?php
    }
} ?>