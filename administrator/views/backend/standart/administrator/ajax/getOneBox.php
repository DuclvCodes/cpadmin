<style>
.boxnews_tile {width: auto !important; height: inherit !important; float: none !important; margin-right: 0 !important; font-family: Arial; cursor: move; border: 0; position: relative; overflow: inherit;}
.boxnews_tile h3 {font-size: 13px; line-height: 20px !important;}
.boxnews_tile .tile-body {margin-bottom: 0 !important; padding: 5px;}
.boxnews_tile .btn_remove {position: absolute;top: 5px;right: 5px; display: none; opacity: 0.5; width: 45px; height: 45px !important;}
.boxnews_tile:hover .btn_remove {display: block;}
.boxnews_tile .btn_remove:hover {opacity: 1;}
#listNewsOrder li.sortable-placeholder{border:1px dashed #CCC; height: 50px; list-style: none; margin-bottom: 5px;}
#listNewsOrder input[name=numSortBox] {
    display: none;
width: 25px;
margin-right: 25px;
}
@media only screen and (max-width: 980px) {
    #listNewsOrder input[name=numSortBox] {
        display: block;
        width: 30px;
        height: 36px;
        text-align: center;
        background: #f5f5f5;
        border: none;
    }
}
</style>

<?php $is_show=true; if ($allNews and in_array($news_id, $allNews)) {
    $is_show=false; ?><div class="alert alert-error" style="font-family: Arial;"><button class="close" data-dismiss="alert"></button><b><?php echo $oneNews['title'] ?></b>&nbsp;đã có trong danh sách</div><?php
} ?>
<?php if ($oneBox['count_item']>0 || $oneBox['count_item_2']>0) {
        ?><div class="alert" style="font-family: Arial;">BOX chỉ hiển thị <?php if ($oneBox['count_item']>0) {
            echo '<b>'.$oneBox['count_item'].'</b> bài viết trang chủ';
        }
        if ($oneBox['count_item_2']) {
            echo ' và <b>'.$oneBox['count_item_2'].'</b> bài viết trang chuyên mục';
        } ?>. Hiện tại đang có <b id="lbl_total_news"></b> bài viết <span id="lbl_remove_less" style="margin-left: 8px;">[<a href="#" style="color: #c09853;">xóa bớt</a>]</span></div><?php
    } ?>

<div id="lbl_res_oneBox"></div>

<ul id="listNewsOrder" style="margin: 0;list-style-type: none;">
    <?php if ($oneNews && $is_show) {
        $push_date=strtotime($oneNews['push_date']); ?>
    <li class="oneItem" data-id="<?php echo $news_id ?>">
        <div class="tile double bg-red boxnews_tile" style="width: inherit !important;">
            <div class="tile-body">
                <img src="<?php echo $clsNews->getImage($news_id, 45, 45) ?>" width="45" height="45" alt="" class="pull-right" />
                <input type="number" name="numSortBox" value="1" class="pull-right" />
                <h3><?php echo $oneNews['title'] ?></h3>
                <div><span class="label label-<?=($push_date>time())?'warning':'success'?>"><?php if ($push_date>time()) {
            echo 'HẸN GIỜ ';
        }
        echo date('H:i d/m/Y', $push_date) ?></span></div>
            </div>
            <button class="btn mini blue btn_remove"><i class="icon-remove"></i></button>
        </div>
    </li>
    <?php
    } ?>
    
    <?php if ($allNews) {
        foreach ($allNews as $index => $news_id) {
            $oneNews = $clsNews->getOne($news_id);
            $push_date=strtotime($oneNews['push_date']); ?>
    <li class="oneItem" data-id="<?php echo $news_id ?>">
        <div class="tile double bg-grey boxnews_tile" style="width: inherit !important;">
            <div class="tile-body">
                <img src="<?php echo $clsNews->getImage($news_id, 45, 45) ?>" width="45" height="45" alt="" class="pull-right" />
                <input type="number" name="numSortBox" value="<?= ($index+1) ?>" class="pull-right" />
                <h3><?php echo $oneNews['title'] ?></h3>
                <div><span class="label label-<?=($push_date>time())?'warning':'success'?>"><?php if ($push_date>time()) {
                echo 'HẸN GIỜ ';
            }
            echo date('H:i d/m/Y', $push_date) ?></span></div>
            </div>
            <button class="btn mini blue btn_remove"><i class="icon-remove"></i></button>
        </div>
    </li>
    <?php
        }
    } ?>
</ul>

<div style="clear: both;"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('#letter_box_news').text('<?php echo $oneBox['title'] ?>');
    var total_news = $('#listNewsOrder .oneItem').size();
    var max_news = <?=max($oneBox['count_item'], $oneBox['count_item_2'])?>;
    $('#lbl_total_news').text(total_news);
    if(total_news>max_news) {
        $('#lbl_remove_less a').unbind().click(function(){
            var k=0;
            $('#listNewsOrder li.oneItem').each(function(){
                k++;
                if(k>max_news) $(this).find('.btn_remove').click();
            });
            $('#lbl_remove_less').remove();
            return false;
        });
    }
    else $('#lbl_remove_less').remove();
    $('.boxnews_tile .btn_remove').unbind().click(function(){
        $(this).parents('.oneItem').fadeOut(500, function(){
            $(this).remove();
            $('#lbl_total_news').text($('#listNewsOrder .oneItem').size());
        });
    });
    if($('#listNewsOrder').hasClass('running')) {
        $('#listNewsOrder').sortable('destroy');
        $('#listNewsOrder').sortable();
    } else {
        $('#listNewsOrder').sortable().addClass('running');
    }
});
</script>
<?php die(); ?>