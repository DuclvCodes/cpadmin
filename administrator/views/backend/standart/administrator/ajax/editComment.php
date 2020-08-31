<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Sửa comment</h3>
</div>
<div class="modal-footer" style="padding: 5px 15px;">
	<button type="button" data-dismiss="modal" class="btn">Close</button>
	<button type="button" class="btn green" id="btn_save_comment">Save changes</button>
</div>
<div class="modal-body" id="modal_body_edit_comment">
    <div class="alert alert-success hide" id="alert_edit_comment"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>
	<textarea name="content" class="m-wrap" style="width: calc(100% - 14px); height: 82px;"><?=$one['content']?></textarea>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_save_comment').click(function(){
        var el = $('#modal_body_edit_comment');
        App.blockUI(el);
        var id = <?=$one['comment_id']?>;
        var content = $('#modal_body_edit_comment textarea').val();
        $.ajax({type: "POST", url: "/ajax/updateComment?id="+id, data: {content: content}, dataType: "html",success: function(msg){
            App.unblockUI(el);
            $('#alert_edit_comment').removeClass('hide');
            $('#span_comment_'+id).text(content);
        }});
        return false;
    });
});
</script>
<?php die() ?>