<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Cài đặt tên miền</h3>
</div>
<div class="modal-footer" style="padding: 5px 15px;">
	<button type="button" class="btn green" id="btn_add_box_save">Cập nhật</button>
</div>
<style type="text/css">
#modal_body_box_news .row-fluid label a.external_link {display: none; zoom: 0.8; margin-left: 8px;}
#modal_body_box_news .row-fluid label:hover a.external_link {display: inline;}
</style>
<div class="modal-body" id="modal_body_box_news">
    <div id="lbl_res_js"></div>
	<form id="frm_setting_store" action="/ajax/setSettingStore" method="post" class="form-horizontal">
        
        <div class="row-fluid profile">
            <div class="span4">
                <div class="scoller" style="height: 332px; overflow: auto;">
                    <ul class="unstyled profile-nav" style="margin-bottom: 0;">
                        <?php if ($data) {
    foreach ($data as $key=>$oneDomain) {
        ?>
        				<li class="<?=$key?'':'active'?>"><a href="#tab_domain_<?=$key?>" data-toggle="tab"><?php echo $oneDomain->title ?></a></li>
                        <?php
    }
} ?>
        			</ul>
                </div>
            </div>
            <div class="tab-content span8">
                <?php if ($data) {
    foreach ($data as $key=>$oneDomain) {
        $allCat = $oneDomain->list;
        $total = count($allCat);
        $avg = ceil($total/2);
        $avg--; ?>
                <div class="tab-pane <?=$key?'':'active'?>" id="tab_domain_<?=$key?>">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i> Chọn</th>
                                <th class="hidden-phone"><i class="icon-folder-open"></i> Chuyên mục</th>
                                <th><i class="icon-link"></i> Xem nhanh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($allCat) {
            foreach ($allCat as $key=>$oneCat) {
                ?>
                            <tr>
                                <td><input <?php if ($oneCat->is_register=='1') {
                    echo 'checked="checked"';
                } ?> name="category_path[]" type="checkbox" value="<?php echo $oneCat->id ?>" /></td>
                                <td class="hidden-phone"><?php echo $oneCat->title ?></td>
                                <td><a class="btn mini blue-stripe" href="<?php echo $oneCat->link ?>" target="_blank">Xem</a></td>
                            </tr>
                            <?php
            }
        } ?>
                        </tbody>
                    </table>
                </div>
                <?php
    }
} ?>
            </div>
            
        </div>
        <input name="action" value="set" type="hidden" />
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.scoller').mCustomScrollbar();
    $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)").each(function(){
        if(!$(this).hasClass('toggle')) {
            $(this).uniform();
            $(this).addClass('toggle');
        }
    });
    
    $('#frm_setting_store').unbind().submit(function(){
        var _this = $(this);
        var el = $('#frm_setting_store');
        App.blockUI(el);
        $.ajax({type: "POST", url: _this.attr('action'), data: _this.serialize(), dataType: "html",success: function(msg){
            App.unblockUI(el);
            $('#lbl_res_js').html(msg);
        }});
        return false;
    });
    $('#btn_add_box_save').unbind().click(function(){
        $('#frm_setting_store').submit();
        return false;
    });
});
</script>
<?php die() ?>