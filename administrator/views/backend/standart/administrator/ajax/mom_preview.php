<div class="modal-footer" style="padding: 5px 15px; text-align: left;">
    <button type="button" class="btn blue mini" id="btn_save_mom"><i class="icon-download-alt"></i> Download as MS Word</button>
	<button type="button" class="btn green mini" id="btn_print_mom"><i class="icon-print"></i> In</button>
    <button style="float: right;" type="button" class="btn red mini" data-dismiss="modal" aria-hidden="true"><i class="icon-eject"></i> Đóng</button>
</div>
<style>
.email_gray {color: #999;}
</style>
<div class="modal-body" id="modal_body_mom_preview" style="font-family: Arial;">
    <p style="text-align: right; font-size: 11px; color: #999;"><?=date('d/m/Y H:i', strtotime($one['reg_date']))?></p>
    <h4><b><?=$one['title']?></b></h4>
    <p style="font-size: 12px;">Người nhận: 
        <?php
            $clsEmail = new Email();
            $allEmail = pathToArray($one['email_path']);
            if ($allEmail) {
                foreach ($allEmail as $key=>$email_id) {
                    $o = $clsEmail->getOne($email_id);
                    if ($key) {
                        echo ', ';
                    }
                    echo $clsEmail->getTitle($email_id).' <span class="email_gray">&lt;'.$o['email'].'&gt;</span>';
                }
            }
        ?>
    </p>
    <?=$one['content']?>
    <p style="text-align: right;"><?=$clsEmail->getTitle($one['email_id'])?></p>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_save_mom').unbind().click(function(){
            $("#modal_body_mom_preview").wordExport('<?=toSlug($one['title'])?>');
            return false;
        });
        $('#btn_print_mom').unbind().click(function(){
            $.print("#modal_body_mom_preview");
            return false;
        });
    });
</script>