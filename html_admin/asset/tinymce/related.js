/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    var handleUniform = function () {
        if (!jQuery().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
        if (test.size() > 0) {
            test.each(function () {
                if ($(this).parents(".checker").size() == 0) {
                    $(this).show();
                    $(this).uniform();
                }
            });
        }
    }
    handleUniform();
    $('input[type=text]').focus();
    $('#frm_news').submit(function(){
        var keyword = $('input[name=k]').val();
        var category_id = $('select[name=category_id]').val();
        $.ajax({
    		type: "POST",
    		url: "/ajax/searchNews",
    		data:  {keyword: keyword, category_id: category_id},
    		dataType: "html",
    		success: function(msg){
    			$('#wrap_search').html(msg);
                $('.scoller').slimScroll({
                    height: '200px'
                });
                js_event();
                
                $('#wrap_search').find('a.btn_loadmore').unbind().click(function(){
                    var page = $(this).attr('data-page'); $(this).attr('data-page', page+1);
                    var _this = $(this).parents('tr');
                    $.ajax({
                		type: "POST",
                		url: "/ajax/searchNews?page="+page,
                		data:  {iClass: 'news', keyword: keyword, category_id: category_id},
                		dataType: "html",
                		success: function(msg){
                			if(msg) { _this.before(msg); js_event(); $('.scoller').slimScroll({height: '146px'});}
                            else _this.remove();
                		}
                	});
                    return false;
                });
    		},
            error: function(request,error) {alert ( " Can't do because: " + error );}
    	});
        return false;
    });
    var total = 0;
    function js_event() {
        $('.btn_insert').removeClass('btn_insert').click(function(){
            total++; if(total==1) $('.visible').removeClass('visible');
            if(total==7) {top.tinymce.activeEditor.windowManager.alert('Box này chỉ chọn được tối đa 6 tin'); total=4; return false;}
            var href = $(this).attr('href');
            var title = $(this).text();
            var alt = $(this).attr('title');
            var image = $(this).attr('data-image');
            var classz = '_related_1404022217_item image_suggest';
            var news_type = $("input[name='news_type']:checked"). val();
            if(total==6) classz += ' _related_1404022217_item_last';
            $('._related_1404022217').addClass('suggest_post');
            if(news_type == 'news_title') {
                $('._related_1404022217').append('<div class="suggest_child"><a target="_blank" href="'+href+'" class="" title="'+title+'">'+title+'</a><i style="margin-left:5px;" class="icon-remove"></i></div>');
            }else {
                $('._related_1404022217').append('<div class="'+classz+'"><a class="_related_1404022217_photo" title="'+alt+'" href="'+href+'" target="_blank"><img src="'+image+'" alt="'+alt+'" style="width:154px; height:104px" width="154" height="104"></a><i style="margin-left:5px;" class="icon-remove"></i><a class="_related_1404022217_title" title="'+alt+'" href="'+href+'" target="_blank">'+title+'</a></div>');
            }
            $('._related_1404022217 .image_suggest i.icon-remove').click(function() {
                    $(this).parents('.image_suggest').remove();
                    total--;
            }); 
            $('._related_1404022217 .suggest_child i.icon-remove').click(function() {
                    $(this).parents('.suggest_child').remove();
                    total--;
            });           
            return false;
        });
    }
    $('.nav_radio input[type=radio]').change(function(){
        var val = $(this).val();
        $('._related_1404022217').removeClass('_related_1404022217_bottom').removeClass('_related_1404022217_left').removeClass('_related_1404022217_right').addClass(val);
        $('#wrap_html').slimScroll({
            height: '200px'
        });
    });
    $('#btn_insert_content').click(function(){
        top.tinymce.activeEditor.execCommand('mceInsertContent', false, $('#wrap_html').html());
        top.tinymce.activeEditor.windowManager.close();
        return false;
    });
});