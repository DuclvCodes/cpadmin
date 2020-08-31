function insertblock() {
    tinyMCEPopup.requireLangPack();
    var content = '';
    var lines = $('textarea[name=content]').val().split('\n');
    for(var i = 0;i < lines.length;i++){
        content += '<p>'+lines[i]+'</p>';
    }
    tinyMCEPopup.editor.execCommand('mceInsertContent', false,content);
    tinyMCEPopup.close();
}