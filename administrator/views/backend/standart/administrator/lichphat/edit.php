<?php $mod = current_method()['mod']; ?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Sửa thông tin</h3>
</div>
<div class="modal-body">
    <form id="form_default_modal" class="form-horizontal" action="/<?=$mod?>/edit?id=<?=$oneItem[$pkeyTable]?>" method="post" enctype="multipart/form-data">
        <div class="row-fluid">
    		<div class="span10">
                <div class="control-group">
                    <label class="control-label" for="f_title">Lịch</label>
        			<div class="controls">
        				<select name="parent_time" class="m-wrap span12" disabled="disabled">
                            <?php for ($i=1; $i<=8; $i++) {
    ?>
                            <option <?php if ($i==$oneItem['parent_time']) {
        echo 'selected="selected"';
    } ?> value="<?=$i?>">Lịch <?=$clsClassTable->getTitlePTime($i)?></option>
                            <?php
} ?>
                        </select>
        			</div>
        		</div>
                <div class="control-group">
                    <label class="control-label" for="f_time">Thời gian</label>
        			<div class="controls">
        				<input maxlength="20" name="time" type="text" id="f_time" class="m-wrap span12" value="<?php echo $oneItem['time'] ?>" />
        			</div>
        		</div>
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