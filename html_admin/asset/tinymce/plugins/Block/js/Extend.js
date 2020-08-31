var i=0;
function setNews(key) {
    if(i<=3){                         
        if(key=="") {
            document.getElementById('search_keyword').focus();
            return false;
        }                       
        $(document).ready(function(){
            var imageContainer = $('._related_1404022217');
            $.ajax({
                type : "GET",
                url : "/api/pluginSearch",
                data : {id:key},
                success : function(html){
                    if(html!="") {
                        imageContainer.find('._related_1404022217_item_last').removeClass('_related_1404022217_item_last');
                        imageContainer.append(html);
                        i=i+1;
                        imageContainer.find('._related_1404022217_item:last').addClass('_related_1404022217_item_last');
                        $('._related_1404022217_item a').unbind().click(function(){
                            if(confirm("Bạn có chắc chắn muốn xóa bài này ra khỏi box?")==true) {
                                $(this).parents('._related_1404022217_item').remove();
                                i--;
                            }
                            return false;
                        });
                    }
                    else {
                        alert('Không có kết quả với từ khóa "'+key+'"');  
                    }
                }                
            });
        });       
    }
    else {
        alert('Block chỉ hiển thị được 4 bài viết');
        return false;
    } 
}
function setOneNews() {  
    var key = document.getElementById('IDkeyword').value;
    setNews(key);
}
function insertblock() {
    tinyMCEPopup.requireLangPack();  
    $('#preview').find('.n_hide').remove();
    var content = $('#preview').html();                                     
    tinyMCEPopup.editor.execCommand('mceInsertContent', false,content);
    tinyMCEPopup.close();
}
$(document).ready(function(){
    $('input[name=type]').change(function(){
        var val = $(this).val();
        $('._related_1404022217').removeClass('_related_1404022217_bottom');
        $('._related_1404022217').removeClass('_related_1404022217_left');
        $('._related_1404022217').removeClass('_related_1404022217_right');
        $('._related_1404022217').addClass(val);
    });
});