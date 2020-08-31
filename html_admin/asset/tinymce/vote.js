$(document).ready(function(){
    var ed = top.tinymce.activeEditor, dom = ed.dom, n = ed.selection.getNode();
    if(n.nodeName == 'P' && $(n).hasClass('tkp_area_vote')) {
        var id = $(n).find('.vote_id').text();
        $.ajax({
    		type: "GET",
    		url: '/vote/getVote?id='+id,
    		dataType: "html",
    		success: function(msg){
                var data = jQuery.parseJSON(msg);
                $('#frm_vote input[name=vote_id]').val(id);
                $('#frm_vote textarea[name=title]').val(data.title);
                var all_ans = jQuery.parseJSON(data.answers);
                $.each(all_ans, function(index, value) {
                    if(index>1) $('.add_choose').click();
                    $('#frm_vote .icon-remove:eq('+index+')').parents('.control-group').find('input').val(value);
                });
                $('#btn_insert_content').html('<i class="icon-ok"></i> Cập nhật');
                $('#btn_add').click();
    		},
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
    	});
    }
    var i = 3;
    $('.add_choose').click(function(){
        var obj = $(this).parents('.control-group');
        obj.before('<div class="control-group"><div class="controls"><input type="text" name="answers[]" value="" class="span12 m-wrap required" placeholder="Lựa chọn '+i+'" /><i class="icon-remove js_close"></i></div></div>');
        event_remove();
        i++;
        if(i==4) $('.icon-remove').removeClass('hide');
        $('.icon-remove:last').parents('.control-group').find('input').focus();
        return false;
    });
    function event_remove() {
        $('.js_close').removeClass('js_close').click(function(){
            $(this).parents('.control-group').remove();
            i--;
            if(i==3) $('.icon-remove').addClass('hide');
            var k = 1;
            $('.icon-remove').each(function(){
                $(this).parents('.control-group').find('input').attr('placeholder', 'Lựa chọn '+k);
                k++;
            });
            return false;
        });
    }
    event_remove();
    $('#frm_vote .required').each(function(){
        var e = $(this).parents('.control-group');
        $(this).keyup(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
        $(this).change(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
    });
    $('#frm_vote').submit(function(){
        var is_error = false;
        $(this).find('.required').each(function(){
            var val = $(this).val();
            if(!val || val=='' || val=='0') {
                $(this).parents('.control-group').addClass('error');
                is_error = true;
            }
        });
        if(is_error==true) {
            $(this).find('.error:eq(0) .required').focus();
            alert('Vui lòng nhập đầy đủ thông tin');
            return false;
        }
        var url = $(this).attr('action');
        $.ajax({
    		type: "POST",
    		url: url,
    		data:  $('#frm_vote').serialize(),
    		dataType: "html",
    		success: function(msg){
    			//if($('#frm_vote input[name=vote_id]').val()>0) $(n).remove();
                ed.execCommand('mceInsertContent', false, msg);
                ed.windowManager.close();
    		},
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
    	});
        return false;
    });
    $('.btn_one_vote').click(function(){
        var id = $(this).attr('data-id');
        var title = $(this).text();
        ed.execCommand('mceInsertContent', false, '<p class="tkpNoEdit tkp_area_vote widget_vote"><span class="vote_id" style="display:none">'+id+'</span>'+title+'</p>');
        ed.windowManager.close();
        return false;
    });
    $('.scoller').slimScroll({height: '311px'});
    $('#btn_add').click(function(){
        $('#frm_vote').show();
        $('#frm_list').hide();
        return false;
    });
    $('#btn_search').click(function(){
        $('#frm_vote').hide();
        $('#frm_list').show();
        return false;
    });
});