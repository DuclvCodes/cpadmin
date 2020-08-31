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
    $('.tab_btn .btn').click(function(){
        var id = $(this).attr('href');
        if(id=='#tab-1' && $(this).hasClass('red')) {$('#btn_tab_1').click(); return false;}
        $('.tab_btn .btn.red').removeClass('red').addClass('blue');
        $('.tab_content').addClass('hide');
        $(this).addClass('red').removeClass('blue');
        $(id).removeClass('hide');
        return false;
    });
    
    $('.oneVideo .btn_Insert').click(function(){
        var content = $(this).parents('.oneVideo').find('.embed').html();
        //content = $("<div\>").html(content).text();
        insertContent(content);
        return false;
    });
    
    $('#form-youtube').submit(function(){
        var youtube = $('input[name=youtube]').val();
        var id = youtube_parser(youtube);
        var content = '<iframe class="you_video" width="100%" height="450" src="https://www.youtube.com/embed/'+id+'?rel=0" frameborder="0" allowfullscreen></iframe>';
        insertContent(content);
        return false;
    });
    
    $('#form-embed').submit(function(){
        var embed = $('textarea[name=embed]').val();
        insertContent(embed);
        return false;
    });
    
    $('#btn_tab_1').click(function(){
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
                $('.uploadbar').css('margin-top', '15px');
                $('.progress-striped').removeClass('progress-striped');
                $('#list_images_cover').html(xhr.responseText).parents('.row-fluid').removeClass('hide');
                $('.btn_setcover').click(function(){
                    var id = $(this).attr('data-id');
                    var image = $(this).attr('data-image');
                    $.ajax({
                		type: "POST", url: "", data:  {action: 'setcover', id: id, image: image}, dataType: "html",
                		success: function(msg){
                			insertContent(msg);
                		},
                        error: function(request,error) {
                            console.log(arguments); alert ( " Can't do because: " + error );
                        }
                	});
                    return false;
                });
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
function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    return (match&&match[7].length==11)? match[7] : false;
}