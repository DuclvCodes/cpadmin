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
    
    $('.nav_radio input[type=radio]').change(function(){
        var val = $(this).val();
        if(val=='left') $('.quote-inner').css('float', 'left').css('margin', '0 13px 0 0');
        else if(val=='center') $('.quote-inner').addClass('quote_center');
        else if(val=='right') $('.quote-inner').css('float', 'right').css('margin', '0 0 0 13px');
    });
    $('#btn_insert_content').click(function(){
        var info = $('textarea[name=info]').val();
        var fullname = $('input[name=fullname]').val();
        $('#js_wrap_quote blockquote.quote').html(info);
        if(fullname) $('#js_wrap_quote p.tkpEdit').html(fullname);
        else $('#js_wrap_quote p.tkpEdit').remove();
        
        top.tinymce.activeEditor.execCommand('mceInsertContent', false, $('#js_wrap_quote').html()+'<p></p>');
        top.tinymce.activeEditor.windowManager.close();
        return false;
    });
});
