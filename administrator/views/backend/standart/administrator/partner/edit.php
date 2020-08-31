<?php $mod = current_method()['mod']; ?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Sửa thông tin</h3>
</div>
<div class="modal-body">
    <form id="form_default_modal" class="form-horizontal" action="/<?=$mod?>/edit?id=<?=$oneItem['partner_id']?>" method="post" enctype="multipart/form-data">
        <div class="row-fluid">
    		<div class="span10">
                <div class="control-group">
                    <label class="control-label" for="f_title">Tiêu đề</label>
        			<div class="controls">
        				<input maxlength="255" name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $oneItem['title'] ?>" />
        			</div>
        		</div>
                <div class="control-group">
                    <label class="control-label" for="f_link">Link</label>
        			<div class="controls">
        				<input maxlength="500" name="link" type="text" id="f_link" class="m-wrap span12 required" value="<?php echo $oneItem['link'] ?>" placeholder="http://" />
        			</div>
        		</div>
                <div class="control-group hide">
                    <label class="control-label" for="f_title">Logo</label>
        			<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail">
								<img id="img_image_preview" src="<?php if ($oneItem['image']) {
    echo MEDIA_DOMAIN.$oneItem['image'];
} else {
    echo BASE_ASSET.'images/no-photo.jpg';
} ?>" alt="" />
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
							<div>
								<span class="btn btn-file"><span class="fileupload-new">Tải lên</span>
								<span class="fileupload-exists">Thay đổi</span>
								<input id="file_image" type="file" class="default" name="image" /></span>
							</div>
						</div>
						
					</div>
        		</div>
                
                <div style="text-align: center;"><button type="submit" class="btn green"><i class="icon-ok"></i> Cập nhật</button></div>
            </div>
    	</div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#form_default_modal').submit(function(){
        var is_error = false;
        $(this).find('.required').each(function(){
            var val = $(this).val();
            if(!val || val=='' || val=='0') {
                $(this).parents('.control-group').addClass('error');
                is_error = true;
            }
        });
        if(is_error==true) {
            $(this).find('.error:eq(0) .required').focus();
            alert('Vui lòng nhập đủ những thông tin bắt buộc');
            return false;
        }
    });
    $('#form_default_modal .required').each(function(){
        var e = $(this).parents('.control-group');
        $(this).keyup(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
        $(this).change(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
    });
    
});
</script>