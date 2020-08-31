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
    
    $('#btn_upload').click(function(){
        $('#frm_upload input[type=file]').click();
        return false;
    });
    
    $('#frm_upload input[type=file]').change(function(){
        $(this).parents('form').submit();
    });
    
    $('#frm_upload').submit(function() {
        $('#frm_upload').addClass('hide');
        $('.uploadbar').removeClass('hide');
        $(this).ajaxSubmit({
            uploadProgress: function(event, position, total, percentComplete) {
                $('.uploadbar .bar').css('width', percentComplete+'%');
                $('#lbl_upload').text(parseInt(percentComplete)+'%');
                if(percentComplete==100) {
                    $('.uploadbar').css('margin-top', '60px');
                    setTimeout(function(){
                        $('.progressbar').removeClass('hide');
                        setTimeout(function(){$('.progressbar .bar').css('width', '100%');}, 200);
                    }, 1000);
                }
            },
            complete: function(xhr) {
                insertContent(xhr.responseText);
            }
        });
        return false; 
    });
});
var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
function insertContent(content) {
    editor.execCommand('mceInsertContent', false, content);
    editor.windowManager.close();
}