/*
      Field Path
     
==================================*/

(function($){
 	$.fn.extend({
        
 		FieldPath: function(options) {
			var defaults = {
                limit: 10,
				placeholder: 'Tìm kiếm ...',
				name : '',
                value : '',
				iClass : ''
			}
			var options =  $.extend(defaults, options);
            var html = '<form class="control" method="post" action="" style="margin:0" ><input autofocus="true" name="keyword" type="text" placeholder="từ khóa ..." class="m-wrap"><button class="btn blue"><i class="icon-arrow-right"></i> Tìm kiếm</button></form>';
            $('body').append('<div id="modal_field_path" class="modal hide fade" data-backdropz="static"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h3>'+options.placeholder+'</h3></div><div class="modal-body">'+html+'</div><ul class="listItem" style="margin: 0 16px;padding: 0;list-style: none;height: 400px;overflow: auto;"></ul><div class="modal-footer"><button type="button" data-dismiss="modal" class="btn">Đóng</button></div></div>');
            var $modal_field_path = $('#modal_field_path');
            function event_remove($obj) {
                $obj.find('.js_remove').removeClass('js_remove').click(function(){
                    $(this).parents('li').remove();
                });
            }
            function event_submit($obj) {
                $modal_field_path.find('form').unbind().submit(function(){
                    App.blockUI($modal_field_path.find('ul.listItem'));
                    var keyword = $(this).find('input[name=keyword]').val();
                    $.ajax({type: "POST", url: "/ajax/getFieldPath", data: {iClass: options.iClass, name: options.name, keyword: keyword}, dataType: "html",success: function(msg){
                        App.unblockUI($modal_field_path.find('ul.listItem'));
                        $modal_field_path.find('ul.listItem').html(msg);
                        $modal_field_path.find('ul.listItem li a').unbind().click(function(){
                            var li = $(this).parents('li').html();
                            $(this).css('font-weight', 'bold');
                            $obj.find('ul.listItem').append('<li>'+li+'</li>');
                            event_remove($obj);
                            return false;
                        });
                    }});
                    return false;
                });
            }
            
            return this.each(function() {
                var opts = options;
                var $obj = $(this);
                if(options.iClass=='') alert('Field Path Error: not found class');
                else {
                    if(options.value!='') {
                        $.ajax({type: "POST", url: "/ajax/FieldPathInit", data: {iClass: options.iClass, name: options.name, value: options.value}, dataType: "html",success: function(msg){
                            $obj.append('<div class="alert alert-block alert-info fade in"><ul style="list-style:none; margin:0 0 5px; padding:0;" class="listItem">'+msg+'</ul><a href="#modal_field_path" data-toggle="modal" class="btn mini blue btn_add"><i class="icon-plus"></i> Thêm</a></div>');
                            event_remove($obj);
                            event_submit($obj);
                        }});
                    }
                    else {
                        $obj.append('<div class="alert alert-block alert-info fade in"><ul style="list-style:none; margin:0 0 5px; padding:0;" class="listItem"></ul><a href="#modal_field_path" data-toggle="modal" class="btn mini blue btn_add"><i class="icon-plus"></i> Thêm</a></div>');
                        event_submit($obj);
                    }
                    
                }
    		});
    	}
	});
})(jQuery);