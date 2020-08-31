<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Hộp tin <span id="letter_box_news" style="font-family: Arial;font-weight: normal;font-size: 14px;color: #AAA;margin-left: 8px;"></span></h3>
</div>
<div class="modal-footer hide" style="padding: 5px 15px;">
    <button type="button" class="btn black hide" id="btn_add_box_back" style="float: left;"><i class="icon-arrow-left"></i> Quay lại</button>
    <button type="button" data-dismiss="modal" class="btn hide">Đóng</button>
    <button type="button" class="btn green hide" id="btn_add_box_save">Lưu thay đổi</button>
</div>
<div class="modal-body" id="modal_body_box_news">
    <div class="tbl_box_news">
        <?php if ($allBox) {
    foreach ($allBox as $key=>$box_id) {
        $oneBox = $clsBox->getOne($box_id); ?>
            <?php if ($key%3==0) {
            echo '<tr>';
        } ?>
            <button class="btn blue btn_add_into_box" data-id="<?php echo $box_id ?>"><?php echo $oneBox['title'] ?> <i class="m-icon-swapright m-icon-white"></i></button>
            <?php if ($key%3==2) {
            echo '</tr>';
        } ?>
        <?php
    }
} ?>
        <?php $v = (($key+1)%3); if ($v!=0) {
    echo str_repeat('<td></td>', 3-$v);
} ?>
    </div>
    <div class="oneBox" style="display: none;"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var isMobile = (/iphone|ipod|ipad|android|ie|blackberry|fennec/).test(navigator.userAgent.toLowerCase());
    if(isMobile){
        $('input[name=numSortBox]').css('display', 'inline');
    } else $('input[name=numSortBox]').css('display', 'inline');

    $('.btn_add_into_box').unbind().click(function(){
        var el = $('#modal_body_box_news');
        App.blockUI(el);
        $('#btn_add_box_save').removeClass('hide').unbind();
        $('#mnu_box_news .modal-footer').removeClass('hide');
        var id = $(this).data('id');
        $.ajax({type: "POST", url: "/ajax/getOneBox", data: {id: id, news_id: '<?php echo $news_id ?>'}, dataType: "html",success: function(msg){
            if(parseInt(msg)!=0) {
                App.unblockUI(el);
                el.find('.oneBox').html(msg).fadeIn();
                el.find('.tbl_box_news').hide();
                $('#btn_add_box_back').removeClass('hide');
                $(window).resize();
                $('#btn_add_box_save').click(function(){
                    var news_path = '|';
                        var newsId = 0, numIndex = 1, arrSortNews = [];
                        el.find('.oneItem').each(function(){
                            numIndex = parseInt($(this).find('input[name=numSortBox]').val(), 10);
                            
                            newsId = $(this).data('id');
                            if(!isNaN(numIndex)) {
                                arrSortNews.push([
                                    numIndex, newsId
                                ]);
                            }
                        });
                        if(isMobile) {
                            arrSortNews.sort(function(a, b){
                                return a[0] - b[0];
                            });
                        }
                        $.each(arrSortNews, function(index, item){
                            news_path += item[1]+'|';
                        });

                    App.blockUI(el);
                    $.ajax({type: "POST", url: "/ajax/updateOneBox", data: {id: id, news_path: news_path}, dataType: "html",success: function(msg){
                        App.unblockUI(el);
                        $('#lbl_res_oneBox').html(msg).fadeIn();
                        setTimeout(function(){
                            $('#lbl_res_oneBox').fadeOut();
                        }, 2000);
                        $('.boxnews_tile.bg-red').addClass('bg-grey').removeClass('bg-red');
                        $(window).resize();
                    }});
                    
                });
            }
        }});
    });
    $('#btn_add_box_back').unbind().click(function(){
        var el = $('#modal_body_box_news');
        $('#mnu_box_news .modal-footer').addClass('hide');
        el.find('.oneBox').hide();
        el.find('.tbl_box_news').fadeIn();
        $(this).addClass('hide');
        $('#btn_add_box_save').addClass('hide');
        $('#letter_box_news').text('');
        $(window).resize();
    });
});
</script>
<?php die(); ?>