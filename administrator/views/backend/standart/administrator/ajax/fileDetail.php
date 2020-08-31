<?php $mod = current_method()['mod']; ?>
<div style="padding: 15px;">
    <div class="row-fluid">
        <h3 class="page-title" style="margin-top: 0;">
    		Edit File
    	</h3>
    	<form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default" style="font-family: Arial;">
            <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <div class="toggle_button">
                                    <input type="hidden" name="status" value="0" />
                                    <input name="status" value="1" type="checkbox" class="toggle" <?php if ($oneItem['status'] == 1) {
    echo 'checked="checked"';
} ?> />
                                </div>
                            </td>
                            <td>Trạng thái</td>
                        </tr>
                    </tbody>
            </table>
            <div class="control-group">
                <label class="control-label" for="f_title">Tên</label>
                    <div class="controls">
                        <input name="title" maxlength="255" type="text" id="f_title" class="m-wrap span12 required" value="<?=$oneItem['title']?>" />
                    </div>
    		</div>
                <div class="control-group">
                    <label class="control-label" for="f_title">Note</label>
                    <div class="controls">
                            <textarea name="note" id="f_intro_detail" class="m-wrap span12" rows="3" ><?=$oneItem['note']?></textarea>
                    </div>
                </div>
            <div class="control-group">
                <label class="control-label" for="f_title">File</label>
                    <div class="controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <img src="<?php echo get_icon_file($oneItem['title'])?>"> <?=$oneItem['title']?>
                        </div>
                    </div>
    		</div>
            
    	</form>
    </div>
</div>
