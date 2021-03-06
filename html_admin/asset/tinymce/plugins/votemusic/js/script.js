$(document).ready(function(){
    var ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();
    if(n.nodeName == 'DIV' && $(n).attr('class') == 'tkp_area_votemusic') {
        var id = $(n).find('.vote_id').text();
        $.ajax({
    		type: "GET",
    		url: 'api/getVote?id='+id,
    		dataType: "html",
    		success: function(msg){
                var data = jQuery.parseJSON(msg);
                $('#frm_vote input[name=vote_id]').val(id);
                $('#frm_vote textarea[name=title]').val(data.title);
                if(data.is_predict==1) $('#frm_vote input[name=is_predict]').attr('checked', 'checked');
                var all_ans = jQuery.parseJSON(data.answers);
                var all_youtube = jQuery.parseJSON(data.youtube);
                $.each(all_ans, function(index, value) {
                    if(index>1) $('.add_choose').click();
                    $('#frm_vote .icon-remove:eq('+index+')').parents('.control-group').find('input:eq(0)').val(value);
                });
                $.each(all_youtube, function(index, value) {
                    $('#frm_vote .icon-remove:eq('+index+')').parents('.control-group').find('input:eq(1)').val(value);
                });
                $('#lbl_submit').text('Cập nhật');
    		},
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
    	});
    }
    var i = 3;
    $('.add_choose').click(function(){
        var obj = $(this).parents('.control-group');
        obj.before('<div class="control-group"><div class="controls"><div class="row-fluid"><div class="span5"><input name="answers[]" value="" class="m-wrap required" placeholder="Lựa chọn '+i+'" /></div><div class="span7"><input name="youtube[]" value="" class="m-wrap required" placeholder="Youtube ..." /><a href="#" class="btn green mini btn_upload js">Tải lên</a></div></div><i class="icon-remove js_close"></i></div></div>');
        event_remove();
        event_upload();
        i++;
        if(i==4) $('.icon-remove').removeClass('hide');
        $('.icon-remove:last').parents('.control-group').find('input:eq(0)').focus();
        return false;
    });
    function event_remove() {
        $('.js_close').removeClass('js_close').click(function(){
            $(this).parents('.control-group').remove();
            i--;
            if(i==3) $('.icon-remove').addClass('hide');
            var k = 1;
            $('.icon-remove').each(function(){
                $(this).parents('.control-group').find('input:eq(0)').attr('placeholder', 'Lựa chọn '+k);
                k++;
            });
            return false;
        });
    }
    event_remove();
    function event_upload() {
        $('.btn_upload.js').removeClass('js').click(function(){
            var milliseconds = new Date().getTime();
            $(this).attr('id', 'tkp_'+milliseconds)
            $('#frm_upload').attr('for', 'tkp_'+milliseconds).find('input').click();
            return false;
        });
    }
    event_upload();
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
    			if($('#frm_vote input[name=vote_id]').val()>0) $(n).remove();
                tinyMCEPopup.editor.execCommand('mceInsertContent', false, msg);
                tinyMCEPopup.close();
    		},
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
    	});
        return false;
    });
    $('#frm_upload input').change(function(){
        if($(this).val()!='') $(this).parents('form').submit();
    });
    $('#frm_upload').submit(function(){
        var e = $('#'+$(this).attr('for')).parent().find('input');
        e.val('Loading ...');
        $(this).ajaxSubmit({
            success: function(responseText, statusText, xhr, $form){
                e.val(responseText);
            }
        });
        return false;
    });
});