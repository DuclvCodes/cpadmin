<style>
.filed_id {font-weight: bold;font-size: 10px;color: #CCC;}
.background_white {background: #FFF !important;}
table.act_default thead tr th {font-size: 11px; color: #999; font-weight: bold;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						List <?php echo $classTable ?> <small>module manager</small>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Add New <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Dashboard</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>"><?php echo $classTable ?></a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">List</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <?php if ($is_trash==0) {
    ?>
                    
                        <?php if ($listItem) {
        ?>
                        <form action="" method="post">
                        <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
    						<tbody>
                                <?php
                                    foreach ($listItem as $user_id) {
                                        $oneItem=$clsUser->getOne($user_id);
                                        $allSignature = $clsClassTable->getAll("is_trash=0 and user_id='".$user_id."'", true, 'CMS'); ?>
        							<tr class="odd gradeX">
        								<td><b><i class="icon-caret-down"></i> <?php echo $oneItem['username'] ?></b> (<?php echo $oneItem['fullname'] ?>)</td>
        							</tr>
                                    <?php if ($allSignature) {
                                            foreach ($allSignature as $signature_id) {
                                                ?>
                                    <tr class="odd gradeX">
        								<td><a href="/signature/edit?id=<?php echo $signature_id ?>"><?php echo $clsClassTable->getTitle($signature_id) ?></a></td>
        							</tr>
                                    <?php
                                            }
                                        } ?>
                                <?php
                                    } ?>
    						</tbody>
    					</table>
                        </form>
                        
                        <?php
    } ?>
                    
                    <?php
} else {
        ?>
                    
                        <?php if ($listItem) {
            ?>
                        <form action="" method="post">
                        <table class="table table-striped table-bordered table-advance table-hover act_default" id="sample_1">
    						<tbody>
                                <?php foreach ($listItem as $_id) {
                $oneItem=$clsClassTable->getOne($_id); ?>
                                    <tr class="odd gradeX">
        								<td><a href="/signature/edit?id=<?php echo $_id ?>"><?php echo $clsClassTable->getTitle($_id) ?></a></td>
        							</tr>
                                <?php
            } ?>
    						</tbody>
    					</table>
                        </form>
                        
                        <?php
        } else {
            echo '<p>Không có bản ghi nào!</p>';
        } ?>
                    
                    <?php
    } ?>
                    
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>