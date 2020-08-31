var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
$(document).ready(function(){
    
    $('.btn_open_hide').click(function(){
        $(this).parents('.parent').addClass('hide');
        $($(this).attr('href')).removeClass('hide').find('input[type=text]:eq(0)').focus();
        return false;
    });
    
    $('#btn_search').click(function(){
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
                    height: '146px'
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
        $(this).blur();
    });
    
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
    
    var selectedElm = selection.getNode();
    var anchorElm = dom.getParent(selectedElm, 'a[href]');
        
    if(anchorElm) {
        if(dom.getAttrib(anchorElm, 'target')!='_blank') $('input[name=tab]').click();
        if(dom.getAttrib(anchorElm, 'rel')!='nofollow') $('input[name=index]').click();
    }
    
    $('#frm_link').submit(function(){
        var link = $('input[name=link]').val(); 
        if(link=='') {editor.execCommand('unlink'); editor.windowManager.close(); return false;}
        var news_id = $('input[name=news_id]').val();
        if(link.substr(0, 7)=='mailto:') {}
        else if(!isValidUrl(link)) {editor.windowManager.alert('Bạn nhập liên kết không đúng định dạng. Vui lòng nhập lại.'); return false;}
        
        $.ajax({
            type: "POST",
            url: "/ajax/crawlerNews",
            data:  {link: link,news_id:news_id},
            dataType: "html",
            success: function(msg){
                if(msg === 'error') alert ("Xảy ra lỗi trong quá trình vận hành. Hãy xóa hết nội dung và thử lại");
                else {
                    var arr = $.parseJSON(msg);
                    //console.log(arr);
                    if(arr.mess === 'success') insertContent(arr.content);
                    else alert (arr.mess);
                }
            },
            error: function(request,error) {alert ( " Can't do because: " + error );}
        });
        $(this).blur();
        return false; 
    });
    
});
function isValidUrl(url){if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url)) return true;else return false;}
function insertContent(content) {
    editor.execCommand('mceInsertContent', false, content);
    editor.windowManager.close();
}