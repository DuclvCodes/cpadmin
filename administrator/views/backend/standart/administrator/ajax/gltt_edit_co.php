<div class="modal-header">
	<h3>Giao lưu trực tuyến - Xuất bản</h3>
</div>
<div class="modal-footer" style="padding: 5px 15px; text-align: left;">
    <button data-id="<?=$one['question_id']?>" type="button" class="btn green" id="btn_question_save"><i class="icon-signout"></i> Xuất bản</button>
    <button type="button" data-dismiss="modal" class="btn btn_close" style="float: right;">Đóng</button>
</div>

<div class="modal-body" id="modal_body_box_question">
    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="">
        <div id="lbl_res_question"></div>
        <div class="control-group">
			<label class="control-label" for="f_answer">Nội dung</label>
			<div class="controls">
				<textarea name="answer" id="f_answer" maxlength="300" class="m-wrap tinymce" style="height: 317px; width: calc(100% - 14px);">
                    <p><b><?php echo $one['question'] ?></b> (<?php echo $one['fullname'] ?> - <i><?php echo $one['email'] ?></i>)</p>
                    <?php echo $one['answer'] ?>
                </textarea>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_question_save').unbind().click(function(){
        var el = $('#modal_body_box_question');
        var frm = el.find('form');
        App.blockUI(frm);
        var id = $(this).attr('data-id');
        $.ajax({type: "POST", url: "/ajax/setQuestion&done?id="+id, data: frm.serialize(), dataType: "html",success: function(msg){
            App.unblockUI(frm);
            if(msg=='1') msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>';
            else msg = 'Có lỗi xảy ra';
            $('#lbl_res_question').html(msg).fadeIn();
            setTimeout(function(){
                $('#lbl_res_question').fadeOut();
                $('#tr_question_'+id).remove();
                setTimeout(function(){
                    $('.btn_close').click();
                }, 200);
            }, 500);
        }});
        return false;
    });
});
</script>
<?php die() ?>