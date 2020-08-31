$(function(){
    var ul = $('#js_append_html');
    $('#btn_upload').click(function(){
        $('#inp_upload').click();
        return false;
    });
    
    var is_uploading = false;
    $('#upload').fileupload({
        dropZone: $('#drop'),
        add: function (e, data) {
            if(is_uploading==false) {
                is_uploading = true;
                $('#upload').hide();
                $('.list_uploading').show();
            }
            
            var tpl = $('<li class="working"><input class="inp_working" type="text" value="0" data-width="220" data-height="220"'+
                'data-thickness=".1" data-skin="tron" data-fgColor="#1990db" data-readOnly="1" data-bgColor="#3e4043" /></li>');
            data.context = tpl.appendTo(ul);
            tpl.find('input.inp_working').knob();
            var jqXHR = data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            if(progress>=100) {
                data.context.find('input.inp_working').parents('li').html('<img style="border: none;margin: 59px 0;" src="img/loading_icon.gif" />');
            }
            else {
                data.context.find('input.inp_working').val(progress).change();
            }
        },
        done: function (e, data) {
            tinyMCEPopup.editor.execCommand('mceInsertContent', false, data.result);
            tinyMCEPopup.close();
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