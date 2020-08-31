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
    
});

