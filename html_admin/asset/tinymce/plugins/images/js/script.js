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
    
    $('#btn_insert').click(function(){
        tinyMCEPopup.requireLangPack();        
        var content = '';
        $('#js_append_html li').each(function(){
            var src = $(this).find('img').attr('src');
            var intro = $(this).find('.description').val();
            if(intro!='') var intro_html = '<td>'+intro+'</td>';
            else var intro_html = '';
            content += '<table class="figure"><tr><td><img src="'+src+'" alt="'+intro+'" /></td></tr><tr class="figcaption">'+intro_html+'</tr></table><p><br data-mce-bogus="1"></p>';
        });
        tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.editor.save();
        tinyMCEPopup.close();
        return false;
    });
});


$(document).ready(function(){
    var d = new Date();
    var year = d.getFullYear();
    for($i=1; $i<=12; $i++) $('select[name=month]').append('<option value="'+$i+'">'+$i+'</option>');
    for($i=1; $i<=31; $i++) $('select[name=day]').append('<option value="'+$i+'">'+$i+'</option>');
    for($i=2014; $i<=year; $i++) $('select[name=year]').append('<option value="'+$i+'">'+$i+'</option>');
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
    $('#history form').submit(function(){
        $('#history .list_img').html('');
        var dataz = $(this).serialize();
        var page = $(this).find('input[name=page]').val();
        $.getJSON("/api/getImages?"+dataz, function( data ) {
            var count = 0;
            $.each(data, function(key, one) {
                count++;
                var file = one.file;
                var name = one.name;
                var tpl = $('<li><img src="'+file+'" /><p title="'+name+'">'+name+'</p></li>');
                tpl.click(function(){
                    if($(this).hasClass('active')) alert('Ảnh này đã được chèn vào nội dung.');
                    else {
                        $(this).addClass('active');
                        var content = '<table class="figure"><tr><td><img src="'+file.replace('/resize/150x105/', '/')+'" alt="'+name+'" /></td></tr><tr class="figcaption"><td>'+name+'</td></tr></table><p><br data-mce-bogus="1"></p>';
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