<div class="modal-header">

	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

	<h3>Kho tin tổng hợp</h3>

</div>

<div class="modal-footer" style="padding: 5px 15px;">

    <span style="float: left;font-size: 14px;line-height: 34px;"><?php echo $oneStore['title'] ?></span>

	<a href="/ajax/saveStore?id=<?php echo $_GET['id'] ?>&store_id=<?php echo $_GET['store_id'] ?>" class="btn green">Lấy tin</a>

</div>

<div class="modal-body" id="modal_body_box_news">

    <iframe frameborder="0" width="100%" height="450" src="http://news..vn//iframe/detailNews?id=<?php echo $_GET['id'] ?>"></iframe>

</div>