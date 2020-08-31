var ed = top.tinymce.activeEditor, dom = ed.dom, n = ed.selection.getNode();
var img = ed.selection.getNode();
//if(n.nodeName == 'FIGURE' && $(n).hasClass('tkpNoEdit')) {
    var src = $(n).find('img').attr('src');
    if(typeof(src) == 'undefined') var src = img.src;
    //var src = img.src;
    //console.log(src);
    var caption = $(n).find('figcaption').text();
//}
//else {
//    alert('Không tìm thấy hình ảnh');
//    ed.windowManager.close();
//}
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
    
    var new_width = $(n).find('img').width();
    var new_height = $(n).find('img').height();
    var new_image = src, jcrop_api;
    var crop_x, crop_y, crop_w, crop_h, pre_w, pre_h;
    $('#img_preview').attr('src', src);
    $('#caption').val(caption); 
    
    if($(n).hasClass('right')) $('.nav_radio input[value=right]').prop( "checked", true );
    else if($(n).hasClass('left')) $('.nav_radio input[value=left]').prop( "checked", true );
    else if($(n).hasClass('full')) $('.nav_radio input[value=full]').prop( "checked", true );
    else if($(n).hasClass('center')) $('.nav_radio input[value=center]').prop( "checked", true );
    else if($(n).hasClass('large')) $('.nav_radio input[value=large]').prop( "checked", true );
    else $('.nav_radio input[value=none]').prop( "checked", true );
    handleUniform();
    var old_class = $('.nav_radio input[name=align]:checked').val();
    $('#resize_w').val(new_width);
    $('#resize_h').val(new_height);
    
    $('#btn_insert_content').click(function(){
        /*$(n).removeClass('tkpNoEdit');
        $(n).find('img').attr('src', new_image);
        $(n).find('img').attr('width', new_width);
        $(n).find('img').attr('height', new_height);
        var new_class = $('.nav_radio input[name=align]:checked').val();
        if(old_class!=new_class) {
            if(old_class!='' && old_class!='none') $(n).removeClass(old_class);
            if(new_class!='' && new_class!='none') $(n).addClass(new_class);
        }
        $(n).addClass('tkpNoEdit');*/
        var new_class = $('.nav_radio input[name=align]:checked').val();
        if(new_class=='none') new_class = '';
        caption = $('#caption').val();
        var _caption = '';
        if(caption) _caption = '<figcaption><h2>'+caption+'</h2></figcaption>';
        ed.execCommand('mceInsertContent', false, '<figure class="tkpNoEdit '+new_class+'"><img src="'+new_image+'" alt="'+caption+'" width="'+new_width+'" height="'+new_height+'" />'+_caption+'</figure>');
        ed.undoManager.add();
        ed.save();
        ed.windowManager.close();
        return false;
    });
    $('#btn_cancel').click(function(){
        ed.windowManager.close();
        return false;
    });
    
    $('#btn_resize').click(function(){
        $('.tools .button-group').hide();
        $('.tools .resize').css('display', 'inline-block').find('input:eq(0)').focus();
    });
    
    var resize_tyle = $('#resize_h').val()/$('#resize_w').val();
    $('#resize_w').keyup(function(){
        var val = ($(this).val())*(resize_tyle);
        $('#resize_h').val(parseInt(val));
    });
    $('#resize_h').keyup(function(){
        var val = ($(this).val())/(resize_tyle);
        $('#resize_w').val(parseInt(val));
    });
    
    $('#btn_crop').click(function(){
        $('.tools .button-group').hide();
        $('.tools .crop').css('display', 'inline-block');
        $('#img_preview').Jcrop({
          onChange:   showCoords,
          onSelect:   showCoords,
          onRelease:  clearCoords,
          aspectRatio: 16 / 9
        },function(){
            jcrop_api = this;
        });
        
    });
    $('#btn_paint').click(function(){
        $('.tools .button-group').hide();
        $('.tools .paint').css('display', 'inline-block');
        $.ajax({
    		type: "POST",
    		url: "/tinymce/editimage?news_id="+news_id,
    		data:  {action: 'paint', image: $('#img_preview').attr('src')},
    		dataType: "html",
    		success: function(msg){
    			if(parseInt(msg)!=0) {$('#img_preview').attr('src', msg); new_image = msg;}
                else alert('ERR');
                $('.tools .button-group').show();
                $('.tools .paint').hide();
    		},
            error: function(request,error) {
                console.log(arguments);
                alert ( " Can't do because: " + error );
                $('.tools .button-group').show();
                $('.tools .paint').hide();
            }
    	});
    });
    $('.tools .resize .btn_ok').click(function(){
        $('.tools .button-group').show();
        $('.tools .resize').hide();
        new_width = $('#resize_w').val();
        new_height = $('#resize_h').val();
        src = $('#img_preview').attr('src').replace(/\/resize\/([0-9]*)x([0-9]*)\//gm, "/").replace('/files/', '/resize/'+new_width+'x'+new_height+'/files/');
        $('#img_preview').attr('src', src);
        new_image = src;
    });
    $('.tools .crop .btn_ok').click(function(){
        $('.tools .button-group').show();
        $('.tools .crop').hide();
        jcrop_api.destroy();
        pre_w = $('#img_preview').width();
        pre_h = $('#img_preview').height();
        crop_x = parseInt($('#crop_x').val()*new_width/pre_w);
        crop_y = parseInt($('#crop_y').val()*new_height/pre_h);
        crop_w = parseInt($('#crop_w').val()*new_width/pre_w);
        crop_h = parseInt($('#crop_h').val()*new_height/pre_h);
        new_width = crop_w; new_height = crop_h;
        $('#resize_w').val(new_width);
        $('#resize_h').val(new_height);
        $.ajax({
    		type: "POST",
    		url: "/tinymce/image",
    		data:  {news_id: news_id, action: 'crop', x: crop_x, y: crop_y, w: crop_w, h: crop_h, image: $('#img_preview').attr('src')},
    		dataType: "html",
    		success: function(msg){
    			if(parseInt(msg)!=0) {$('#img_preview').attr('src', msg);new_image=msg;}
                else alert('ERR');
    		},
            error: function(request,error) {
                console.log(arguments);
                alert ( " Can't do because: " + error );
            }
    	});
    });
    $('.tools .resize .btn_cancel').click(function(){
        $('.tools .button-group').show();
        $('.tools .resize').hide();
    });
    $('.tools .crop .btn_cancel').click(function(){
        $('.tools .button-group').show();
        $('.tools .crop').hide();
        jcrop_api.destroy();
    });
    function showCoords(c) {
        $('#crop_x').val(c.x);
        $('#crop_y').val(c.y);
        $('#crop_w').val(c.w);
        $('#crop_h').val(c.h);
    }
    function clearCoords() {
        $('#coords input').val('');
    }
});