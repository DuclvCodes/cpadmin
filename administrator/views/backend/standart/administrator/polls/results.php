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
  <li class="active"><?php echo lang("ctn_412") ?></li>
</ol>


<hr>

<div class="row">
<div class="col-md-12">

<div class="panel panel-default">
<div class="panel-body">
<h4 class="home-label"><?php echo lang("ctn_413") ?></h4>
<canvas id="myChart" class="graph-height"></canvas>
</div>
</div>

</div>
</div>

<div class="row">
<div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">
  <?php echo lang("ctn_414") ?>
</div>
<div class="panel-body">
<table class="table table-bordered">
<tr class="table-header small-text"><td><?php echo lang("ctn_415") ?></td><td><?php echo lang("ctn_416") ?></td><td><?php echo lang("ctn_417") ?></td><td><?php echo lang("ctn_418") ?></td></tr>
<?php foreach ($votes->result() as $r) : ?>
<tr class="small-text"><td><?php echo $r->answer ?></td><td><?php echo $r->IP ?></td><td><?php echo date($this->settings->info->date_format, $r->timestamp) ?></td><td><?php echo $r->user_agent ?></td></tr>
<?php endforeach; ?>
</table>

<p><a href="<?php echo site_url("polls/results_votes/" . $poll->ID) ?>" class="btn btn-primary btn-sm form-control"><?php echo lang("ctn_419") ?></a></p>
</div>
</div>


</div>
<div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">
  <?php echo lang("ctn_420") ?>
</div>
<div class="panel-body">
<table class="table table-bordered">
<tr class="table-header small-text"><td><?php echo lang("ctn_421") ?></td><td><?php echo lang("ctn_422") ?></td></tr>
<?php foreach ($countries->result() as $r) : ?>
<tr class="small-text"><td><?php echo $r->country ?></td><td><?php echo $r->votes ?></td></tr>
<?php endforeach; ?>
</table>
</div>
</div>

</div>
</div>