<div class="white-area-content">

<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-stats"></span> <?php echo lang("ctn_351") ?></div>
    <div class="db-header-extra"> 
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("polls") ?>"><?php echo lang("ctn_359") ?></a></li>
  <li><a href="<?php echo site_url("polls/edit_poll/" . $poll->ID) ?>"><?php echo lang("ctn_358") ?></a></li>
  <li class="active"><?php echo lang("ctn_379") ?></li>
</ol>

<hr>

<?php
  // Convert timestamp to days hours mins
  $time = $this->common->convert_time($poll->timestamp);

?>

<div class="panel panel-default">
  <div class="panel-heading"><?php echo lang("ctn_379") ?></div>
  <div class="panel-body"> 
	<?php echo form_open(site_url("polls/edit_poll_pro_pro/" . $poll->ID), array("class" => "form-horizontal")) ?>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_362") ?></label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="name" value="<?php echo $poll->name ?>">
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_363") ?></label>
	    <div class="col-sm-10">
	      <textarea name="question" rows="3" class="form-control"><?php echo nl2br($poll->question) ?></textarea>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_365") ?></label>
	    <div class="col-sm-3"><p><?php echo lang("ctn_277") ?></p>
	    <select name="days" class="form-control">
	    <option value="0">0</option>
	    <?php for ($i=1;$i<=365;$i++) : ?>
	    	<option value="<?php echo $i ?>" <?php if ($i == $time['days']) {
    echo "selected";
} ?>><?php echo $i ?> <?php echo lang("ctn_277") ?></option>
	    <?php endfor; ?>
	    </select>
	    </div>
	    <div class="col-sm-3"><p><?php echo lang("ctn_278") ?></p>
	    <select name="hours" class="form-control">
	    <option value="0">0</option>
	    <?php for ($i=1;$i<=24;$i++) : ?>
	    	<option value="<?php echo $i ?>" <?php if ($i == $time['hours']) {
    echo "selected";
} ?>><?php echo $i ?> <?php echo lang("ctn_278") ?></option>
	    <?php endfor; ?>
	    </select>
	    </div>
	    <div class="col-sm-3"><p><?php echo lang("ctn_378") ?></p>
	    <select name="minutes" class="form-control">
	    <option value="0">0</option>
	    <?php for ($i=1;$i<=60;$i++) : ?>
	    	<option value="<?php echo $i ?>" <?php if ($i == $time['mins']) {
    echo "selected";
} ?>><?php echo $i ?> <?php echo lang("ctn_378") ?></option>
	    <?php endfor; ?>
	    </select>
	    </div>
	</div>
	<?php if ($poll->timestamp < time() && $poll->timestamp > 0) : ?>
		<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_501") ?></label>
		    <div class="col-sm-10">
		    <input type="checkbox" name="reset_expired" value="1" />
			<span class="help-block"><?php echo lang("ctn_502") ?></span>
			</div>
		</div>
	<?php endif;  ?>
	<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label"></label>
	    <div class="col-sm-10">
		<span class="help-text"><?php echo lang("ctn_366") ?></span>
		</div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_495") ?></label>
	    <div class="col-sm-10">
	      <select name="public" class="form-control">
	      <option value="0"><?php echo lang("ctn_496") ?></option>
	      <option value="1" <?php if ($poll->public == 1) {
    echo "selected";
} ?>><?php echo lang("ctn_497") ?></option>
	      </select>
	      <span class="help-text"><?php echo lang("ctn_498") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_499") ?></label>
	    <div class="col-sm-10">
	      <input type="checkbox" class="form-control" name="user_restriction" value="1" <?php if ($poll->user_restricted) {
    echo "checked";
} ?>>
	      <span class="help-text"><?php echo lang("ctn_500") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_367") ?></label>
	    <div class="col-sm-10">
	      <input type="checkbox" class="form-control" name="ip_restriction" value="1" <?php if ($poll->ip_restricted) {
    echo "checked";
} ?>>
	      <span class="help-text"><?php echo lang("ctn_368") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_434") ?></label>
	    <div class="col-sm-10">
	      <input type="checkbox" class="form-control" name="cookie_restriction" value="1" <?php if ($poll->cookie_restricted) {
    echo "checked";
} ?>>
	      <span class="help-text"><?php echo lang("ctn_435") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_370") ?></label>
	    <div class="col-sm-10">
	      <input type="checkbox" class="form-control" name="show_results" value="1" <?php if ($poll->show_results) {
    echo "checked";
} ?>>
	      <span class="help-text"><?php echo lang("ctn_371") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_372") ?></label>
	    <div class="col-sm-10">
	      <select name="vote_type" class="form-control">
	      <option value="0" <?php if ($poll->vote_type ==0) {
    echo "selected";
} ?>><?php echo lang("ctn_373") ?></option>
	      <option value="1" <?php if ($poll->vote_type ==1) {
    echo "selected";
} ?>><?php echo lang("ctn_374") ?></option>
	      </select>
	      <span class="help-text"><?php echo lang("ctn_375") ?></span>
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_376") ?></label>
	    <div class="col-sm-10">
	      <select name="themeid" class="form-control">
	      <?php foreach ($themes->result() as $r) : ?>
	      	<option value="<?php echo $r->ID ?>" <?php if ($r->ID == $poll->themeid) {
    echo "selected";
} ?>><?php echo $r->name ?></option>
	      <?php endforeach; ?>
	      </select>
	      <span class="help-text"><?php echo lang("ctn_377") ?></span>
	    </div>
	</div>
	<hr>
	<input type="submit" class="btn btn-primary form-control" value="<?php echo lang("ctn_380") ?>">

	<?php echo form_close() ?>
  </div>
</div>

</div>