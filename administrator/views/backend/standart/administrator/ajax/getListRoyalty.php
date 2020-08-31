<div class="modal-header">
	<button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Royalty <span id="letter_box_news" style="font-family: Arial;font-weight: normal;font-size: 14px;color: #AAA;margin-left: 8px;"><?php echo $oneNews['title'] ?></span></h3>
</div>
<div class="modal-body" id="modal_body_box_news">
	
    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="">
        <div id="lbl_res_royalty"></div>
		<div class="row-fluid">
			<div class="span6 span6_royalty">
                                                
				<div class="control-group">
					<label class="control-label" for="f_royalty_news">Tin bài</label>
					<div class="controls">
						<input name="royalty_news" type="text" id="f_royalty_news" class="m-wrap span12 mask_currency" value="<?php if ($oneNews['royalty_news']>0) {
    echo $oneNews['royalty_news'];
} ?>" />
					</div>
				</div>
                <div class="control-group">
					<label class="control-label" for="f_royalty_photo">Hình ảnh</label>
					<div class="controls">
						<input name="royalty_photo" type="text" id="f_royalty_photo" class="m-wrap span12 mask_currency" value="<?php if ($oneNews['royalty_photo']>0) {
    echo $oneNews['royalty_photo'];
} ?>" />
					</div>
				</div>
                <div class="control-group">
					<label class="control-label" for="f_royalty_video">Video</label>
					<div class="controls">
						<input name="royalty_video" type="text" id="f_royalty_video" class="m-wrap span12 mask_currency" value="<?php if ($oneNews['royalty_video']>0) {
    echo $oneNews['royalty_video'];
} ?>" />
					</div>
				</div>
                <div class="control-group">
					<label class="control-label" for="f_royalty_other">Phụ cấp</label>
					<div class="controls">
						<input name="royalty_other" type="text" id="f_royalty_other" class="m-wrap span12 mask_currency" value="<?php if ($oneNews['royalty_other']>0) {
    echo $oneNews['royalty_other'];
} ?>" />
					</div>
				</div>
                <div class="control-group">
					<label class="control-label" for="f_royalty">Tổng tiền</label>
					<div class="controls">
						<input readonly="ON" name="royalty" type="text" id="f_royalty" class="m-wrap span12" value="<?php if ($oneNews['royalty']>0) {
    echo toString($oneNews['royalty']).' VNĐ';
} ?>" />
					</div>
				</div>
                
                
			</div>
			<!--/span-->
			<div class="span6">
                <div class="control-group">
					<label class="control-label" for="f_royalty_reviews">Đánh giá</label>
					<div class="controls">
						<select class="m-wrap span12" name="royalty_reviews" id="f_royalty_reviews">
                            <option value="">--- Select ---</option>
                            <option <?php if (!$oneNews['royalty_reviews']) {
    $oneNews['royalty_reviews'] = 3;
} if ($oneNews['royalty_reviews']==1) {
    echo 'selected="selected"';
} ?> value="1">A - Xuất sắc</option>
                            <option <?php if ($oneNews['royalty_reviews']==2) {
    echo 'selected="selected"';
} ?> value="2">B - Khá</option>
                            <option <?php if ($oneNews['royalty_reviews']==3) {
    echo 'selected="selected"';
} ?> value="3">C - Đạt</option>
                            <option <?php if ($oneNews['royalty_reviews']==4) {
    echo 'selected="selected"';
} ?> value="4">D - Không đạt</option>
                        </select>
					</div>
				</div>
                <div class="control-group">
					<label class="control-label" for="f_royalty_error">Góp ý</label>
					<div class="controls">
						<textarea name="royalty_error" id="f_royalty_error" maxlength="300" class="m-wrap span12" rows="3" placeholder="những thiếu xót cần khắc phục ..." style="height: 271px;"><?php echo $oneNews['royalty_error'] ?></textarea>
					</div>
				</div>
            </div>
			<!--/span-->
		</div>
        <input type="hidden" name="id" value="<?php echo $news_id ?>" />
	</form>
    
    
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn_close">Close</button>
	<button type="button" class="btn green" id="btn_royalty_save">Save changes</button>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $(".mask_currency").unbind().inputmask('VNĐ 999.999', { numericInput: true });
    $('#btn_royalty_save').unbind().click(function(){
        var el = $('#modal_royalty');
        var frm = el.find('form');
        App.blockUI(frm);
        
        $.ajax({type: "POST", url: "/royalty/ajax", data: frm.serialize(), dataType: "html",success: function(msg){
            App.unblockUI(frm);
            if(msg!='0') {
                $('#field_btn_royalty_<?php echo $news_id ?> .btn').removeClass('red').addClass('blue').text(msg);
                $('#f_royalty').val(msg);
                msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>';
            }
            else msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><strong>Error!</strong> Có lỗi xảy ra. Vui lòng thử lại sau và báo lại với team kĩ thuật</div>';
            $('#lbl_res_royalty').html(msg).fadeIn();
            setTimeout(function(){
                $('#lbl_res_royalty').fadeOut();
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