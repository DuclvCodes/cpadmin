<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Sửa thông tin</h3>
</div>
<div class="modal-body">
    <form id="form_default_modal" class="form-horizontal" action="/<?=$mod?>/edit?id=<?=$oneItem[$pkeyTable]?>" method="post" enctype="multipart/form-data">
        <div class="row-fluid">
    		<div class="span10">
                <div class="control-group">
                    <label class="control-label" for="f_title">Tiêu đề</label>
        			<div class="controls">
        				<input maxlength="255" name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $oneItem['title'] ?>" />
        			</div>
        		</div>
                <div class="control-group">
                    <label class="control-label" for="f_email">Email</label>
        			<div class="controls">
        				<input maxlength="50" name="email" type="text" id="f_email" class="m-wrap span12 required" value="<?php echo $oneItem['email'] ?>" />
        			</div>
        		</div>
                <div class="control-group">
                    <label class="control-label" for="f_title">Nhóm</label>
        			<div class="controls">
        				<?php echo $clsClassTable->getSelect('parent_id', $oneItem['parent_id'], 'm-wrap span12', '-- Chọn --', true) ?>
        			</div>
        		</div>
                
                <div style="text-align: center;"><button type="submit" class="btn green"><i class="icon-ok"></i> Thêm mới</button></div>
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