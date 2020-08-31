$(function(){
    var ul = $('#js_append_html');
    
    var is_uploading = false;
    $('#upload2').fileupload({
        dropZone: $('#drop'),
        add: function (e, data) {
            if(is_uploading==false) {
                is_uploading = true;
                $('#upload2').hide();
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
            $('#btn_insert').show();
            var $e = data.context.find('img').parents('li');
            $e.html('');
            var obj = JSON.parse(data.result);
            $.each(obj.list, function (i, fb) {
                $e.append('<img data-id="'+obj.id+'" src="'+fb+'" />');
            });
            data.context.find('img:eq(0)').addClass('active');
            data.context.find('img').click(function(){
                data.context.find('img.active').removeClass('active');
                $(this).addClass('active');
            });
        },
        fail:function(e, data){
            data.context.addClass('error');
        }
    });
    
    $("#submitfile").click(function() {
        // To Display progress bar
        $("#loading").show();
        // Transfering form information to different page without page refresh
        var filename = $("#filename").val();
        $.ajax({
            type:"post",
            url:"/api/resizeVideo",
            data:"filename="+filename,
            success:function (data) {
            $('.list_uploading').show();
            $('#btn_insert2').show();
            var $e = $('.workingvideo');
            //$e.html('');
            var obj = jQuery.parseJSON(data);
            if(obj.status=='error') {
                alert(obj.msg);
                $("#loading").hide();
                $(".list_uploading").hide();
            };
            $.each(obj.list, function (index, element) {
                $e.append('<img data-id="'+obj.id+'" src="'+element+'" />');
            });
            $("#loading").hide();
            $("img:eq(0)", $e).addClass('active');
            //$e.find('img:eq(0)').addClass('active');
            $("img", $e).click(function(){
                $('img.active', $e).removeClass('active');
                $(this).addClass('active');
                $("#loading").hide();
            });
        }
        });
    });
    $(document).on('drop dragover', function (e) {
        $(this).addClass('hover');
        e.preventDefault();
    });
    
    $('#btn_insert').click(function(){
        $(this).hide();
        tinyMCEPopup.requireLangPack();        
        var obj = $('#js_append_html li:eq(1)');
        var _this = obj.find('img.active');
        var id = _this.attr('data-id');
        var src = encodeURIComponent(_this.attr('src')).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28'). replace(/\)/g, '%29').replace(/\*/g, '%2A');
        obj.html('<img style="border: none;margin: 59px 0;" src="img/loading_icon.gif" />');
        $.ajax({
    		type: "GET",
    		url: "/api/setVideo?id="+id+"&image="+src,
    		dataType: "html",
    		success: function(msg){
    			tinyMCEPopup.editor.execCommand('mceInsertContent', false, msg);
                tinyMCEPopup.close();
    		},
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
    	});
        return false;
    });
    $('#btn_insert2').click(function(){
        $(this).hide();
        tinyMCEPopup.requireLangPack();        
        var obj = $('#js_append_html li:eq(0)');
        var _this = obj.find('img.active');
        var id = _this.attr('data-id');
        var src = encodeURIComponent(_this.attr('src')).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28'). replace(/\)/g, '%29').replace(/\*/g, '%2A');
        obj.html('<img style="border: none;margin: 59px 0;" src="img/loading_icon.gif" />');
        $.ajax({
            type: "GET",
            url: "/api/setVideo?id="+id+"&image="+src,
            dataType: "html",
            success: function(msg){
                tinyMCEPopup.editor.execCommand('mceInsertContent', false, msg);
                tinyMCEPopup.close();
            },
            error: function(request,error) {
                alert("Can't do because: " + error);
            }
        });
        return false;
    });
});


$(document).ready(function(){
    var d = new Date();
    var year = d.getFullYear();
    
    for($i=1; $i<=12; $i++) $('select[name=month]').append('<option value="'+$i+'">'+$i+'</option>');
    for($i=1; $i<=31; $i++) $('select[name=day]').append('<option value="'+$i+'">'+$i+'</option>');
    for($i=2014; $i<=year; $i++) $('select[name=year]').append('<option value="'+$i+'">'+$i+'</option>');
    
    $('select[name=all_user]').change(function(){
        $('select[name=year]').val('');
        $('select[name=month]').val('');
        $('select[name=day]').val('');
    });
    $('#btn_back_upload').click(function(){
        $(this).blur();
        //$('#inp_upload').click();
        $('.box-drop-drag').show();
        $('#history').hide();
        return false;
    });
    $('#btn_old_upload').click(function(){
        $(this).blur();
        $('#upload').hide();
        $('#inp_upload').click();
        return false;
    });
    $('#history form').submit(function(){
        $('#history .list_img').html('');
        var dataz = $(this).serialize();
        var page = $(this).find('input[name=page]').val();
        $.getJSON("/api/getVideo?"+dataz, function( data ) {
            var count = 0;
            $.each(data, function(key, one) {
                count++;
                var file = one.file;
                var name = one.name;
                var duration = one.duration;
                var iframe = one.iframe;
                var tpl = $('<li><img src="'+file+'" /><p title="'+name+'">'+name+'</p><span class="duration">'+duration+'</span></li>');
                tpl.click(function(){
                    var content = '<p style="text-align: center;"><iframe src="'+iframe+'" frameborder="0" width="100%" style="max-width:560px;" height="315" allowfullscreen="true"></iframe></p><p>&nbsp;</p>';
                    tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
                    tinyMCEPopup.editor.save();
                    tinyMCEPopup.close();
                    return false;
                });
                tpl.appendTo($('#history .list_img'));
            });
            var html_paging = '<button class="btn">Trang '+page+'</button>';
            if(count==20) html_paging += '<button class="btn blue js" data-page="'+(parseInt(page)+1)+'">Trang tiếp theo</button>';
            if(page>1) html_paging = '<button class="btn blue js" data-page="'+(parseInt(page)-1)+'">Trang trước</button>'+html_paging;
            var paging = $('<li class="paging">'+html_paging+'</li>');
            paging.find('.btn.js').click(function(){
                $(this).blur();
                $('#history input[name=page]').val($(this).attr('data-page'));
                $('#history form').submit();
                setTimeout(function(){
                    $('#history input[name=page]').val(1);
                }, 2000);
                return false;
            });
            paging.appendTo($('#history .list_img'));
        });
        return false;
    });
    $('#history form').submit();
});