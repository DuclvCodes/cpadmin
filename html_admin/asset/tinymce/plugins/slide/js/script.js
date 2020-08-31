$(function(){
    var ul = $('#js_append_html');
    var is_uploading = false;
    $('#upload').fileupload({
        dropZone: $('#drop'),
        add: function (e, data) {
            if(is_uploading==false) {
                is_uploading = true;
                $('#history').hide();
                $('.list_uploading').show();
            }
            var tpl = $('<li class="working"><input class="inp_working" type="text" value="0" data-width="105" data-height="105"'+
                'data-thickness=".2" data-skin="tron" data-fgColor="#1990db" data-readOnly="1" data-bgColor="#3e4043" /></li>');
            data.context = tpl.appendTo(ul);
            tpl.find('input.inp_working').knob();
            var jqXHR = data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            data.context.find('input.inp_working').val(progress).change();
        },
        done: function (e, data) {
            var $e = data.context.find('canvas');
            if(data.result!='') {
                var res = data.result.split('||');
                $e.parent().before('<img src="'+res[0]+'" /><p>'+res[1]+'</p>');
            }
            $e.parent().remove();
            data.context.find('.inp_working').remove();
            data.context.removeClass('working');
            if($('#js_append_html li.working').length==0) window.location.reload();
        },
        fail:function(e, data){
            data.context.addClass('error');
        }
    });
    $(document).on('drop dragover', function (e) {
        $(this).addClass('hover');
        e.preventDefault();
    });
    
});


$(document).ready(function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var year = d.getFullYear();
    for($i=1; $i<=12; $i++) {
        if(month==$i) $('select[name=month]').append('<option selected="selected" value="'+$i+'">'+$i+'</option>');
        else $('select[name=month]').append('<option value="'+$i+'">'+$i+'</option>');
    }
    for($i=1; $i<=31; $i++) {
        if(day==$i) $('select[name=day]').append('<option selected="selected" value="'+$i+'">'+$i+'</option>');
        else $('select[name=day]').append('<option value="'+$i+'">'+$i+'</option>');
    }
    for($i=2014; $i<=year; $i++) {
        if(year==$i) $('select[name=year]').append('<option selected="selected" value="'+$i+'">'+$i+'</option>');
        else $('select[name=year]').append('<option value="'+$i+'">'+$i+'</option>');
    }
    $('select[name=all_user]').change(function(){
        $('select[name=year]').val('');
        $('select[name=month]').val('');
        $('select[name=day]').val('');
    });
    $('#btn_back_upload').click(function(){
        $(this).blur();
        $('#inp_upload').click();
        return false;
    });
    
    var first_insert = true;
    var ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();
    if($(n).attr('class') == 'tkp_one') first_insert=false;
    $('#history form').submit(function(){
        $('#history .list_img').html('');
        var dataz = $(this).serialize();
        var page = $(this).find('input[name=page]').val();
        $.getJSON("/api/getImages&"+dataz, function( data ) {
            var count = 0;
            $.each(data, function(key, one) {
                count++;
                var file = one.file;
                var name = one.name;
                var tpl = $('<li><img src="'+file+'" /><p title="'+name+'">'+name+'</p></li>');
                tpl.click(function(){
                    if($(this).hasClass('active')) alert('Ảnh này đã được chèn vào nội dung.');
                    else {
                        
                        if(first_insert==true) tinyMCEPopup.execCommand('mceInsertContent', false, '<div class="tkp_tinyslide"><br data-mce-type="bookmark"></div>');
                        first_insert = false;
                        
                        $(this).addClass('active');
                        var content = '<p class="tkp_one"><img src="'+file.replace('/resize/150x105/', '/')+'" alt="'+name+'" />'+name+'</p>';
                        tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
                        tinyMCEPopup.editor.save();
                    }
                    return false;
                });
                tpl.appendTo($('#history .list_img'));
            });
            var html_paging = '<button class="btn">Trang '+page+'</button>';
            if(count==20) html_paging += '<button class="btn blue js" data-page="'+(parseInt(page)+1)+'">Trang tiếp theo</button>';
            if(page>1) html_paging = '<button class="btn blue js" data-page="'+(parseInt(page)-1)+'">Trang trước</button>'+html_paging;
            var paging = $('<li class="paging">'+html_paging+'</li>');
            paging.find('.btn.js').click(function(){
                $(this).blur();
                $('#history input[name=page]').val($(this).attr('data-page'));
                $('#history form').submit();
                setTimeout(function(){
                    $('#history input[name=page]').val(1);
                }, 2000);
                return false;
            });
            paging.appendTo($('#history .list_img'));
        });
        return false;
    });
    $('#history form').submit();
});