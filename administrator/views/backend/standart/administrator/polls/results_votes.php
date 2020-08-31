<div class="white-area-content">

<div id="preview_loading"><span id="loading-text"><?php echo lang("ctn_388") ?></span> <span class="glyphicon glyphicon-refresh" id="loading-spinner"></span></div>

<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-stats"></span> <?php echo lang("ctn_351") ?></div>
    <div class="db-header-extra"> <a href="<?php echo site_url("polls/view_poll/" . $poll->ID . "/" . $poll->hash) ?>" class="btn btn-primary btn-sm"><?php echo lang("ctn_335") ?></a> <a href="<?php echo site_url("polls/edit_poll_pro/" . $poll->ID) ?>" class="btn btn-info btn-sm"><?php echo lang("ctn_379") ?></a> <a href="<?php echo site_url("polls/edit_poll/" . $poll->ID) ?>" class="btn btn-warning btn-sm"><?php echo lang("ctn_358") ?></a> <a href="<?php echo site_url("polls/delete_poll/" . $poll->ID . "/" . $this->security->get_csrf_hash()) ?>" class="btn btn-danger btn-sm"><?php echo lang("ctn_387") ?></a>
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("polls") ?>"><?php echo lang("ctn_359") ?></a></li>
  <li><a href="<?php echo site_url("polls/edit_poll/" . $poll->ID) ?>"><?php echo lang("ctn_358") ?></a></li>
  <li><a href="<?php echo site_url("polls/results/" . $poll->ID) ?>"><?php echo lang("ctn_412") ?></a></li>
  <li class="active"><?php echo lang("ctn_423") ?></li>
</ol>


<hr>

<table class="table table-bordered">
<tr class="table-header"><td><?php echo lang("ctn_415") ?></td><td><?php echo lang("ctn_416") ?></td><td><?php echo lang("ctn_417") ?></td><td><?php echo lang("ctn_418") ?></td></tr>
<?php foreach ($votes->result() as $r) : ?>
<tr><td><?php echo $r->answer ?></td><td><?php echo $r->IP ?></td><td><?php echo date($this->settings->info->date_format, $r->timestamp) ?></td><td><?php echo $r->user_agent ?></td></tr>
<?php endforeach; ?>
</table>

<div class="align-center">
	  <?php echo $this->pagination->create_links(); ?>
</div>
</div>