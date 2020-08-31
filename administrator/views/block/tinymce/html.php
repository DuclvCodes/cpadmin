<script type="text/javascript">
var MEDIA_DOMAIN = '<?=MEDIA_DOMAIN?>';
var LENGTH_MEDIA_DOMAIN = MEDIA_DOMAIN.length;
var EDITED = 0;
var news_id = <?=$_GET['id']?>;
tinymce.PluginManager.add('block', function(editor, url) {
    function createBlockList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn Box tin nên đọc',
                url: '/tinymce/related?news_id='+news_id,
                width: 700,
                height: 650
            });
        };
    }
    editor.addButton('block', {
        icon: 'options',
        tooltip: 'Chèn tin nên đọc',
        stateSelector: 'div._related_1404022217',
        onclick: createBlockList()
    });
    editor.addMenuItem('block', {
        icon: 'options',
        text: 'Chèn Box tin nên đọc',
        context: 'insert',
        shortcut: 'Meta+O',
        prependToContext: true,
        onclick: createBlockList()
    });
    editor.addShortcut('Meta+O', '', createBlockList());
});
tinymce.PluginManager.add('crawler', function(editor, url) {
    function getLinkNews() {
        return function() {
            editor.windowManager.open({
                title: 'Bóc tin',
                url: '/tinymce/getNews?news_id='+news_id,
                width: 450,
                height: 250
            });
        };
    }
    editor.addButton('crawler', {
        icon: 'strikethrough',
        tooltip: 'Bóc tin',
        onclick: getLinkNews(),
        context: 'insert',
        prependToContext: true,
        stateSelector: 'a[href]'
    });
});
tinymce.PluginManager.add('link', function(editor, url) {
    function createLinkList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn liên kết',
                url: '/tinymce/link?news_id='+news_id,
                width: 450,
                height: 250
            });
        };
    }
    
    editor.addButton('link', {
        icon: 'link',
        tooltip: 'Chèn liên kết',
        onclick: createLinkList(),
        stateSelector: 'a[href]'
    });
    
    editor.addButton('unlink', {
        icon: 'unlink',
        tooltip: 'Remove link',
        cmd: 'unlink',
        stateSelector: 'a[href]'
    });

    editor.addMenuItem('link', {
        icon: 'link',
        text: 'Chèn liên kết',
        shortcut: 'Meta+K',
        onclick: createLinkList(),
        stateSelector: 'a[href]',
        context: 'insert',
        prependToContext: true
    });
    editor.addShortcut('Meta+K', '', createLinkList());
    editor.addCommand('mceLink', createLinkList());
});

tinymce.PluginManager.add('media', function(editor, url) {
    function createMediaList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn video',
                url: '/tinymce/media?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_full_video() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_1_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn video',
                url: '/tinymce/media?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_lager_video() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_2_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn video',
                url: '/tinymce/media?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    editor.addButton('media', {
        icon: 'media',
        tooltip: 'Chèn video',
        stateSelector: 'iframe.tkp_video',
        onclick: createMediaList()
    });
    editor.addMenuItem('createBox_full_video', {
        icon: 'media',
        text: 'Chèn video Full',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_full_video()
    });
    editor.addMenuItem('createBox_lager_video', {
        icon: 'media',
        text: 'Chèn video Rộng',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_lager_video()
    });
    editor.addMenuItem('media', {
        icon: 'media',
        text: 'Chèn video',
        context: 'insert',
        prependToContext: true,
        onclick: createMediaList()
    });
});

tinymce.PluginManager.add('quote', function(editor, url) {
    function createQuoteList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn trích dẫn',
                url: '/tinymce/quote',
                width: 400,
                height: 327
            });
        };
    }
    editor.addMenuItem('quote', {
        icon: 'blockquote',
        text: 'Chèn trích dẫn',
        context: 'insert',
        prependToContext: true,
        onclick: createQuoteList()
    });
    editor.addButton('quote', {
        icon: 'blockquote',
        tooltip: 'Chèn trích dẫn',
        context: 'insert',
        stateSelector: 'div._related_1404022217',
        onclick: createQuoteList()
    });
});

tinymce.PluginManager.add('attach', function(editor, url) {
    function createAttachList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn file đính kèm',
                url: '/tinymce/attach',
                width: 400,
                height: 327
            });
        };
    }
    editor.addMenuItem('attach', {
        icon: 'attach',
        text: 'Chèn file đính kèm',
        context: 'insert',
        prependToContext: true,
        onclick: createAttachList()
    });
});

tinymce.PluginManager.add('info', function(editor, url) {
    function createInfoList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn box thông tin',
                url: '/tinymce/info',
                width: 400,
                height: 327
            });
        };
    }
    editor.addMenuItem('info', {
        icon: 'flipv',
        text: 'Chèn box thông tin',
        context: 'insert',
        prependToContext: true,
        onclick: createInfoList()
    });
    editor.addButton('info', {
        icon: 'flipv',
        tooltip: 'Chèn box thông tin',
        context: 'insert',
        stateSelector: 'div._related_1404022217',
        onclick: createInfoList()
    });
});

tinymce.PluginManager.add('vote', function(editor, url) {
    function createVoteList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn bình chọn',
                url: '/tinymce/vote',
                width: 400,
                height: 425
            });
        };
    }
    editor.addMenuItem('vote', {
        icon: 'anchor',
        text: 'Chèn bình chọn',
        context: 'insert',
        prependToContext: true,
        onclick: createVoteList()
    });
    editor.addButton('vote', {
        icon: 'anchor',
        tooltip: 'Chèn bình chọn',
        context: 'insert',
        stateSelector: 'div._related_1404022217',
        onclick: createVoteList()
    });
});

tinymce.PluginManager.add('image', function(editor, url) {
    function createImageList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createSlideList() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            var myNode = selection.getNode();
            if($(myNode).hasClass('tkp_tinyslide')) {
                alert(selection.getNode().innerHTML);
            }
            else {
                editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_tinyslide tkpNoEdit"><div id="id_of_tinyslide" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
                editor.undoManager.add();
                editor.save();
                dom.get('id_of_tinyslide').focus();
                dom.setAttrib('id_of_tinyslide', 'id', null);
                editor.addVisual();
                editor.windowManager.open({
                    title: 'Chèn hình ảnh',
                    url: '/tinymce/image?news_id='+news_id,
                    width: 800,
                    height: 550
                });
            }
        };
    }
    function createBox_1_image() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_1_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_2_image() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_2_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_3_image() {
         return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_3_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_1_image_full() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_1_image tkp_box_1_image_full tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_2_image_full() {
        return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_2_image tkp_box_2_image_full tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_3_image_full() {
         return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_3_image tkp_box_3_image_full tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_text_image() {
         return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_text_image tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    function createBox_image_text() {
         return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="tkp_box_image_text tkpNoEdit"><div id="id_of_box" class="tkp_wrap tkpEdit">&nbsp;</div></div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn hình ảnh',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }

    function createBox_info_emagazine() {
         return function() {
            var editor = top.tinymce.activeEditor, selection = editor.selection, dom = editor.dom;
            editor.execCommand('mceInsertRawHTML', false, '<div class="container check-author"> <div class="author"> <div class="row"> <div class="col-md-7"> <div class="info-author-left"> <p>Bài viết: Tác giả</p> <p>Minh họa: <?=DOMAIN_NAME?></p> <p>Thiết kế: <?=DOMAIN_NAME?></p> </div> </div> <div class="col-md-5 text-right"> <div class="info-author-right text-right"> <p><?=DOMAIN_NAME?></p> <p>20.09.2018</p> </div> </div> </div>  </div> </div>');
            editor.undoManager.add();
            editor.save();
            dom.get('id_of_box').focus();
            dom.setAttrib('id_of_box', 'id', null);
            editor.addVisual();
            editor.windowManager.open({
                title: 'Chèn thông tin emagazine',
                url: '/tinymce/image?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    editor.addButton('image', {
        icon: 'image',
        tooltip: 'Chèn hình ảnh',
        stateSelector: 'figure.image',
        onclick: createImageList()
    });
    editor.addMenuItem('image', {
        icon: 'image',
        text: 'Chèn hình ảnh',
        context: 'insert',
        prependToContext: true,
        onclick: createImageList()
    });
    editor.addMenuItem('insert_slide', {
        icon: 'image',
        text: 'Chèn slide',
        context: 'insert',
        prependToContext: true,
        onclick: createSlideList()
    });
    editor.addMenuItem('box_1_image_full', {
        icon: 'options',
        text: 'Hộp 1 ảnh full',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_1_image_full()
    });
    editor.addMenuItem('box_2_image_full', {
        icon: 'options',
        text: 'Hộp 2 ảnh full',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_2_image_full()
    });
    editor.addMenuItem('box_3_image_full', {
        icon: 'options',
        text: 'Hộp 3 ảnh full',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_3_image_full()
    });
    editor.addMenuItem('box_1_image', {
        icon: 'options',
        text: 'Hộp 1 ảnh',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_1_image()
    });
    editor.addMenuItem('box_2_image', {
        icon: 'options',
        text: 'Hộp 2 ảnh',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_2_image()
    });
    editor.addMenuItem('box_3_image', {
        icon: 'options',
        text: 'Hộp 3 ảnh',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_3_image()
    });
    editor.addMenuItem('box_text_image', {
        icon: 'options',
        text: 'Hộp text-ảnh',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_text_image()
    });
    editor.addMenuItem('box_image_text', {
        icon: 'options',
        text: 'Hộp ảnh-text',
        context: 'insert',
        prependToContext: true,
        onclick: createBox_image_text()
    });
    editor.addMenuItem('info_emagazine', {
        icon: 'options',
        text: 'Info thông tin',   
        context: 'insert',
        prependToContext: true,
        onclick: createBox_info_emagazine()
    });
});

tinymce.PluginManager.add('editimage', function(editor, url) {
    function createEditImage() {
        return function() {
            editor.windowManager.open({
                title: 'Sửa hình ảnh',
                url: '/tinymce/editimage?news_id='+news_id,
                width: 550,
                height: 560
            });
        };
    }
});

tinymce.PluginManager.add('chart', function(editor, url) {
    function createChartList() {
        return function() {
            editor.windowManager.open({
                title: 'Chèn biểu đồ',
                url: '/tinymce/chart?news_id='+news_id,
                width: 800,
                height: 550
            });
        };
    }
    editor.addMenuItem('chart', {
        icon: 'charts',
        text: 'Chèn biểu đồ',
        context: 'insert',
        prependToContext: true,
        onclick: createChartList()
    });
});

tinyMCE.init({
    selector : ".tinymce",
    plugins : "hr,textcolor,colorpicker,autosave,wordcount,code,fullscreen,table,noneditable,block,link,media,image,paste,quote,info,vote,chart,attach,searchreplace,editimage,crawler",
    toolbar1: "alignleft,aligncenter,alignjustify,alignright,outdent indent,preview,bold,italic,underline,strikethrough,superscript,subscript,formatselect,fontsizeselect,fontselect",
    toolbar2: "undo,redo,forecolor,backcolor,code,vote,link,unlink,image,media,block,quote,info,numlist,bullist,hr,crawler",
    content_css : '/asset/tinymce/tinymce_content.css?v=1.2.4',
    font_formats: 'Roboto=roboto;Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
    autosave_ask_before_unload: true,
    autosave_interval: "5s",
    autosave_retention: "180m",
    //noneditable_editable_class: "tkpEdit",
//    noneditable_noneditable_class: "tkpNoEdit",
    height: 500,
    branding: false,
    theme_advanced_toolbar_location : "bottom",
    menubar:false,
    setup : function(ed) {
        ed.on('Click', function(e) {
            if (e.target.nodeName=='IMG') {
                ed.windowManager.open({
                    title: 'Sửa hình ảnh',
                    url: '/tinymce/editimage?news_id='+news_id,
                    width: 750,
                    height: 560
                });
            }
        });
    },
    style_formats : [
        {title : 'Size 16', inline : 'span', styles : {'font-size' : '16px'}},
        {title : 'Size 18', inline : 'span', styles : {'font-size' : '18px'}},
        {title : 'Size 20', inline : 'span', styles : {'font-size' : '20px'}},
        {title : 'Size 22', inline : 'span', styles : {'font-size' : '22px'}},
        {title : 'Size 24', inline : 'span', styles : {'font-size' : '24px'}},
        {title : 'Size 26', inline : 'span', styles : {'font-size' : '26px'}},
        {title : 'Size 28', inline : 'span', styles : {'font-size' : '28px'}},
        {title : 'Size 30', inline : 'span', styles : {'font-size' : '30px'}},
        {title : 'Size 32', inline : 'span', styles : {'font-size' : '32px'}},
                {title : 'Subtitle', block : 'h2'}
    ],
    paste_preprocess: function(plugin, args) {
        args.content = args.content.replace(/<div/gi, "<p");    
        args.content = args.content.replace(/<\/div>/gi, "</p>");
        args.content = args.content.replace(/<strong/gi, "<b");    
        args.content = args.content.replace(/<\/strong>/gi, "</b>");
        args.content = args.content.replace(/<em/gi, "<i");    
        args.content = args.content.replace(/<\/em>/gi, "</i>");
        args.content = strip_tags(args.content,'<h1><h2><h3><h4><p><b><u><i><img><table><tr><td><th><tbody><thead><ul><li><figure><figcaption>');
        args.content = args.content.replace(/<(p)[^>]+>/ig,'<$1>');
        var $contentz = $('<div/>').html(args.content);
        var url = '';
//        $contentz.find('img').each(function(){
//            url = $(this).attr('src');
//            if(url.substring(0, LENGTH_MEDIA_DOMAIN)!=MEDIA_DOMAIN) $(this).remove();
//        });
        $contentz.find('p').each(function(){
            $(this).attr('style', 'text-align: justify;');
            if($(this).html().length<=1) $(this).remove();
        });
        args.content = $contentz.html();
    },
    entity_encoding : "raw",
    paste_as_text: false,
});
function strip_tags(b,k){var e="",f=!1,g=[],h=[],d="",a=0,l="",c="";k&&(h=k.match(/([a-zA-Z0-9]+)/gi));b+="";g=b.match(/(<\/?[\S][^>]*>)/gi);for(e in g)if(!isNaN(e)){c=g[e].toString();f=!1;for(l in h)if(d=h[l],a=-1,0!=a&&(a=c.toLowerCase().indexOf("<"+d+">")),0!=a&&(a=c.toLowerCase().indexOf("<"+d+" ")),0!=a&&(a=c.toLowerCase().indexOf("</"+d)),0==a){f=!0;break}f||(b=b.split(c).join(""))}return b};
</script>