var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
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
    
    var onlyText = isOnlyTextSelected();
    var selectedElm = selection.getNode();
    var anchorElm = dom.getParent(selectedElm, 'a[href]');
    var data_text = anchorElm ? (anchorElm.innerText || anchorElm.textContent) : selection.getContent({format: 'text'});
    var data_href = anchorElm ? dom.getAttrib(anchorElm, 'href') : '';
    $('input[name=title]').val(data_text);
    $('input[name=link]').val(data_href);
    
    if(anchorElm) {
        if(dom.getAttrib(anchorElm, 'target')!='_blank') $('input[name=tab]').click();
        if(dom.getAttrib(anchorElm, 'rel')!='nofollow') $('input[name=index]').click();
	}
    
    $('#frm_link').submit(function(){
        var link = $('input[name=link]').val(); if(link=='') {editor.execCommand('unlink'); editor.windowManager.close(); return false;}
        if(link.substr(0, 7)=='mailto:') {}
        else if(!isValidUrl(link)) {editor.windowManager.alert('Bạn nhập liên kết không đúng định dạng. Vui lòng nhập lại.'); return false;}
        var tab = null; if($('input[name=tab]').is(":checked")) tab = '_blank';
        var index = null; if($('input[name=index]').is(":checked")) index = 'nofollow';
        data_text = $('input[name=title]').val() ? $('input[name=title]').val() : data_text;
        
        var linkAttrs = {
			href: link,
            rel: index,
            target: tab
		};
        
        if(anchorElm) {
			editor.focus();
			if(onlyText) {
				if("innerText" in anchorElm) anchorElm.innerText = data_text;
                else anchorElm.textContent = data_text;
			}
			dom.setAttribs(anchorElm, linkAttrs);
			selection.select(anchorElm);
			editor.undoManager.add();
		}
        else {
            if(onlyText) editor.insertContent(dom.createHTML('a', linkAttrs, dom.encode(data_text)));
            else editor.execCommand('mceInsertLink', false, linkAttrs);
        }
        editor.windowManager.close();
        return false;
    });
    
    function js_event() {
        $('.btn_insert').removeClass('btn_insert').click(function(){
            var href = $(this).attr('href');
            var title = $(this).text();
            if($('input[name=title]').val()=='') $('input[name=title]').val(title);
            $('input[name=link]').val(href);
            if(!$('input[name=tab]').is(":checked")) $('input[name=tab]').click();
            if($('input[name=index]').is(":checked")) $('input[name=index]').click();
            $('#frm_link').submit();
            return false;
        });
    }
    
});
function isValidUrl(url){if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url)) return true;else return false;}
function isOnlyTextSelected(anchorElm) {
    var html = selection.getContent();if (/</.test(html) && (!/^<a [^>]+>[^<]+<\/a>$/.test(html) || html.indexOf('href=') == -1)) {return false;}
    if(anchorElm) {
        var nodes = anchorElm.childNodes, i;if (nodes.length === 0) {return false;}
        for (i = nodes.length - 1; i >= 0; i--) {if (nodes[i].nodeType != 3) {return false;}}
    }
    return true;
}