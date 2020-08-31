<?php $mod = current_method()['mod']; ?>
<div style="padding: 15px;">
    <div class="row-fluid">
        <h3 class="page-title" style="margin-top: 0;">
    		Thêm quảng cáo TVC
    	</h3>
    	<form action="/<?=$mod?>/add" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default" style="font-family: Arial;">
    		<table class="table table-bordered table-striped">
    			<tbody>
    				<tr>
    					<td>
    						<div class="toggle_button">
                                <input type="hidden" name="is_show" value="0" />
    							<input name="is_show" value="1" type="checkbox" class="toggle" <?php if (1) {
    echo 'checked="checked"';
} ?> />
    						</div>
    					</td>
    					<td>Hiển thị/ Ẩn</td>
    				</tr>
    			</tbody>
    		</table>
            <div class="control-group">
                <label class="control-label" for="f_title">Tên đối tác</label>
    			<div class="controls">
    				<input name="title" maxlength="255" type="text" id="f_title" class="m-wrap span12 required" value="" />
    			</div>
    		</div>
            <div class="control-group">
                <label class="control-label" for="f_title">File MP4</label>
    			<div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    	<div class="input-append">
                    		<div class="uneditable-input">
                    			<i class="icon-file fileupload-exists"></i> 
                    			<span class="fileupload-preview"></span>
                    		</div>
                    		<span class="btn btn-file">
                    		<span class="fileupload-new">Select file</span>
                    		<span class="fileupload-exists">Change</span>
                    		<input name="file" type="file" class="default" />
                    		</span>
                    		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    	</div>
                    </div>
				</div>
    		</div>
            <div class="control-group">
                <label class="control-label" for="f_todate">Thời hạn</label>
    			<div class="controls">
    				<input name="todate" type="text" id="f_todate" class="m-wrap span12 datepicker" value="<?=isset($todate)?date('d/m/Y', strtotime($todate)):date('d/m/Y', strtotime('+3 month'))?>" />
    			</div>
    		</div>
            
            <div class="controls controls-row">
                <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
            </div> 
            
    	</form>
    </div>
</div>
<script src="<?php echo BASE_ASSET ?>js/script.js"></script>