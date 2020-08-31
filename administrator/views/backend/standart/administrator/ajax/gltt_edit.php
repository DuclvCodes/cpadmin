<div class="modal-header">
	<h3>Trả lời Giao lưu trực tuyến</h3>
</div>
<div class="modal-footer" style="padding: 5px 15px; text-align: left;">
    <button data-id="<?=$one['question_id']?>" type="button" class="btn green" id="btn_question_save"><i class="icon-ok"></i> Lưu</button>
    <button data-id="<?=$one['question_id']?>" type="button" class="btn red" id="btn_question_send"><i class="icon-signout"></i> Lưu &amp; gửi xuất bản</button>
    <button type="button" data-dismiss="modal" class="btn btn_close" style="float: right;">Đóng</button>
</div>

<div class="modal-body" id="modal_body_box_question">
    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="">
        <div id="lbl_res_question"></div>
		<div class="control-group">
			<label class="control-label" for="f_question">Câu hỏi</label>
			<div class="controls">
				<textarea name="question" id="f_question" maxlength="300" class="m-wrap" style="height: 40px; width: calc(100% - 14px);"><?php echo $one['question'] ?></textarea>
			</div>
		</div>
        <div class="control-group">
			<label class="control-label" for="f_answer">Trả lời</label>
			<div class="controls">
				<textarea name="answer" id="f_answer" maxlength="300" class="m-wrap tinymce" style="height: 317px; width: calc(100% - 14px);"><?=$one['answer']?$one['answer']:'<p><b>'.$guest_name.'</b>:&nbsp</p>'?></textarea>
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
        $.ajax({type: "POST", url: "/ajax/setQuestion?id="+id, data: frm.serialize(), dataType: "html",success: function(msg){
            App.unblockUI(frm);
            if(msg=='1') msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>';
            else msg = 'Có lỗi xảy ra';
            $('#lbl_res_question').html(msg).fadeIn();
            setTimeout(function(){
                $('#lbl_res_question').fadeOut();
            }, 5000);
        }});
        return false;
    });
    $('#btn_question_send').unbind().click(function(){
        var el = $('#modal_body_box_question');
        var frm = el.find('form');
        App.blockUI(frm);
        var id = $(this).attr('data-id');
        $.ajax({type: "POST", url: "/ajax/setQuestion?id="+id+"&send", data: frm.serialize(), dataType: "html",success: function(msg){
            App.unblockUI(frm);
            if(msg=='1') msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>';
            else msg = 'Có lỗi xảy ra';
            $('#lbl_res_question').html(msg).fadeIn();
            $('#tr_question_'+id).remove();
            setTimeout(function(){
                $('#lbl_res_question').fadeOut();
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