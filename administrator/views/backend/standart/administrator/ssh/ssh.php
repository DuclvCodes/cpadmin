<style>
.code {padding: 2px 4px; color: #d14; background-color: #f7f7f9; font-family: Monaco,Menlo,Consolas,"Courier New",monospace; font-size: 12px; border-radius: 3px !important; border: 1px solid #e1e1e8; max-width: 500px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title" style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Command Line - Server WEB</h3>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
                <?php if ($res) {
    ?>
                <div class="alert alert-success">
					<button class="close" data-dismiss="alert"></button>
					<strong>#<?php echo $_POST['str'] ?>:</strong> <?php echo str_replace("\n", '<br>', $res) ?>
				</div>
                <?php
} ?>
                <form method="post" action="" class="form-horizontal">
                    <div class="control-group">
                        <div class="controls" style="margin-left: 0;">
                            <select name="str" class="m-wrap" style="min-width: 350px;">
                                <option>php -v</option>
                                <option>sync; echo 3 > /proc/sys/vm/drop_caches</option>
                                <option>service nginx restart</option>
                                <option>service memcached restart</option>
                                <option>df -h</option>
                                <option>reboot</option>
                            </select>
                            <button type="submit" class="btn blue"><i class="icon-ok"></i></button>
                        </div>
                    </div>
                </form>
                
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>