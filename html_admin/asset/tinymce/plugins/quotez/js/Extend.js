$(document).ready(function(){
    $('input[name=type]').change(function(){
        var val = $(this).val();
        if(val=='right') $('#preview table').attr('style', 'float: right; width: 250px; border: 1px solid #d6dce8; background: #eee; margin-left: 8px; text-align: justify;');
        else if(val=='left') $('#preview table').attr('style', 'float: left; width: 250px; border: 1px solid #d6dce8; background: #eee; margin-right: 8px; text-align: justify;');
        else $('#preview table').attr('style', 'width: 450px; border: 1px solid #d6dce8; background: #eee; margin: 8px auto; text-align: justify;');
    });
});
function insertblock() {
    tinyMCEPopup.requireLangPack();
    $('#preview .n_hide').remove();
    var content = $('#preview').html();
    tinyMCEPopup.editor.execCommand('mceInsertContent', false,content);
    tinyMCEPopup.close();
}