var offset = 0;
var limit = 10;
function search(is_more){
    if(is_more==true) offset = offset + limit;
    else offset = 0;
    var keyword = $('input[name="search_keyword"]').val();
    $.ajax({
        url : "/api/loadRelationNews",
        type : "GET",
        data : {q:keyword, limit:limit, offset:offset},
        success : function(html){
            if(html) {
                $('#art-sugg-content').html(html);
                $('#btn_readmore').show();
            }
            else {
                $('#art-sugg-content').html('');
                $('#btn_readmore').hide();
            }
        }
    });
}