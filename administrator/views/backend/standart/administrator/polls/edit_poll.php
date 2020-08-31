<div class="white-area-content">

<div id="preview_loading"><span id="loading-text"><?php echo lang("ctn_388") ?></span> <span class="glyphicon glyphicon-refresh" id="loading-spinner"></span></div>

<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-stats"></span> <?php echo lang("ctn_351") ?></div>
    <div class="db-header-extra"> <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#codeModal"><?php echo lang("ctn_389") ?></button> <a href="<?php echo site_url("polls/view_poll/" . $poll->ID . "/" . $poll->hash) ?>" class="btn btn-primary btn-sm"><?php echo lang("ctn_335") ?></a> <a href="<?php echo site_url("polls/edit_poll_pro/" . $poll->ID) ?>" class="btn btn-info btn-sm"><?php echo lang("ctn_379") ?></a> <a href="<?php echo site_url("polls/delete_poll/" . $poll->ID . "/" . $this->security->get_csrf_hash()) ?>" class="btn btn-danger btn-sm"><?php echo lang("ctn_387") ?></a>
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("polls") ?>"><?php echo lang("ctn_359") ?></a></li>
  <li class="active"><?php echo lang("ctn_358") ?></li>
</ol>


<hr>

<div class="row">
<div class="col-md-12">

<div class="input-group">
  <input type="text" class="form-control" aria-label="..." id="question" value="<?php echo $poll->question ?>">
  <input type="hidden" id="pollid" value="<?php echo $poll->ID ?>">
  <div class="input-group-btn">
  	<?php if ($poll->status == 1) : ?>
    <button type="button" class="btn btn-success" id="status_button"><?php echo lang("ctn_332") ?></button>
	<?php elseif ($poll->status == 2) : ?>
	<button type="button" class="btn btn-info" id="status_button"><?php echo lang("ctn_333") ?></button>
	<?php else : ?>
	<button type="button" class="btn btn-default" id="status_button"><?php echo lang("ctn_334") ?></button>
	<?php endif; ?>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	<span class="caret"></span>
    </button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="javascript:void(0)" onclick="update_status(<?php echo $poll->ID ?>, 0)"><?php echo lang("ctn_390") ?></a></li>
          <li><a href="javascript:void(0)" onclick="update_status(<?php echo $poll->ID ?>, 1)"><?php echo lang("ctn_391") ?></a></li>
          <li><a href="javascript:void(0)" onclick="update_status(<?php echo $poll->ID ?>, 2)"><?php echo lang("ctn_392") ?></a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#"><?php echo lang("ctn_393") ?></a></li>
        </ul>
  </div>
</div>

</div>
</div>

<hr>

<div class="row">
<div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">
<div class="db-header-borderless clearfix">
    <div class="page-header-title"> <?php echo lang("ctn_394") ?></div>
    <div class="db-header-extra"> <button type="button" class="btn btn-primary btn-xs" onclick="add_answer(<?php echo $poll->ID ?>)"><span class="glyphicon glyphicon-plus"></span> <?php echo lang("ctn_395") ?></button>
</div>
</div>
</div>
<div class="panel-body" id="answer-area">

<?php foreach ($answers->result() as $r) : ?>
<div class="answer-box group-spacing" id='answer-area-id-<?php echo $r->ID ?>'>

<div class="row <?php if (!$r->image) : ?>no-display<?php endif; ?>" id="picture-area-<?php echo $r->ID ?>">
<div class="col-md-3 align-center">
<p><?php if ($r->image) : ?><img src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->image ?>" height="70" id="image-id-<?php echo $r->ID ?>"/></p><?php endif; ?>
</div>
<div class="col-md-9">
<?php echo form_open_multipart(site_url("polls/upload_image_answer/" . $poll->ID . "/" . $r->ID)) ?>
<p><input type="file" name="userfile" value="<?php echo lang("ctn_402") ?>"></p><p> <input type="submit" class="btn btn-primary btn-xs" value="<?php echo lang("ctn_396") ?>"/></p>
<?php echo form_close() ?>
<?php if ($r->image) : ?>
<p><button type="button" class="btn btn-danger btn-xs" onclick="delete_image(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-remove"></span> <?php echo lang("ctn_397") ?></button></p>
<?php endif; ?>
</div>
</div>
<div class="input-group">
    <input type="text" class="form-control answer-field" aria-label="..." id="answer-id-<?php echo $r->ID ?>" value="<?php echo $r->answer ?>">
  <div class="input-group-btn">
  <button type="button" class="btn btn-default" title="<?php echo lang("ctn_398") ?>" onclick="add_picture(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-picture"></span></button>
  <button type="button" class="btn btn-default" title="<?php echo lang("ctn_399") ?>" onclick="update_answer(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-ok"></span></button>
  <button type="button" class="btn btn-default" title="<?php echo lang("ctn_400") ?>" onclick="delete_answer(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-remove"></span></button>
  </div>
</div>
</div>
<?php endforeach; ?>



</div>
</div>

<?php
// Convert timestamp to days hours mins
  $time = $this->common->convert_time($poll->timestamp);
  unset($time['secs']);
  ?>

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-bordered">
    <tr class="table-header"><td colspan="2"><?php echo lang("ctn_401") ?></td></tr>
    <tr><td><?php echo lang("ctn_362") ?>:</td><td><?php echo $poll->name ?></td></tr>
    <tr><td><?php echo lang("ctn_382") ?>:</td><td><?php echo date($this->settings->info->date_format, $poll->created) ?></td></tr>
    <tr><td><?php echo lang("ctn_403") ?>:</td><td><?php echo date($this->settings->info->date_format, $poll->updated) ?></td></tr>
    <tr><td><?php echo lang("ctn_383") ?>:</td><td>
    <?php if ($poll->timestamp > time()) : ?>
      <?php echo $this->common->get_time_string($time); ?>
    <?php else : ?>
      <?php if ($poll->timestamp > 0) : ?>
       <span class="label label-danger"><?php echo lang("ctn_384") ?></span>
      <?php else : ?>
        <?php echo lang("ctn_385") ?>
      <?php endif; ?>
    <?php endif; ?></td></tr>
    </table>

    <a href="<?php echo site_url("polls/edit_poll_pro/" . $poll->ID) ?>" class="btn btn-warning btn-sm form-control"><?php echo lang("ctn_379") ?></a>
  </div>
</div>

</div>
<div class="col-md-6">
<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="db-header-borderless clearfix">
    <div class="page-header-title"> <?php echo lang("ctn_404") ?></div>
    <div class="db-header-extra">  <button type="button" class="btn btn-default btn-xs" title="Click to enable realtime updates" onclick="toggle_realtime()"><span class="glyphicon glyphicon-ban-circle red-color" id="realtime-icon"></span> <?php echo lang("ctn_405") ?></button> <a href="<?php echo site_url("polls/clear_results/" . $poll->ID ."/" . $this->security->get_csrf_hash()) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> <?php echo lang("ctn_406") ?></a>
</div>
</div>	
  </div>
  <div class="panel-body" id="poll_results">
   
  </div>
</div>


</div>
</div>

<div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_407") ?></h4>
      </div>
      <div class="modal-body">
        <p><b><?php echo lang("ctn_408") ?></b></p>
        <p><?php echo lang("ctn_409") ?></p>

        <p><?php echo site_url("polls/ajax_poll/".$poll->ID . "/" . $poll->hash) ?></p>

        <p><b><?php echo lang("ctn_410") ?></b></p>
        <p><?php echo lang("ctn_411") ?></p>

        <p><textarea class="form-control" rows="2"><iframe src="<?php echo site_url("polls/ajax_poll/".$poll->ID . "/" . $poll->hash) ?>" width="400" height="600" frameborder="0" ></iframe></textarea></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
      </div>
    </div>
  </div>
</div>