<style>
.mobile_hide {display: none !important;}
</style>
<script type="text/javascript">
tinyMCE.init({
    mode : "specific_textareas",
    editor_selector : "tinymce",
	relative_urls : false, remove_script_host : false, theme : "advanced",
	plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,Block,embed,images,quotez,Pastez,video,music,vote,votemusic,slide,attach",
	theme_advanced_buttons1 : "forecolor,Pastez,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,outdent,indent",
	theme_advanced_buttons2 : "formatselect,fontsizeselect,|,bullist,numlist,removeformat,link,unlink",
	theme_advanced_buttons3 : "tablecontrols,embed,fullscreen",
    theme_advanced_buttons4 : "votemusic,vote,images,video,music,slide,quotez,Block,attach",
	theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
    extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen]",
    content_css : '<?php echo BASE_ASSET ?>css/tinymce_content.css',
    width: '100%',
    height: 850,
    entity_encoding : "raw",
    theme_advanced_resize_horizontal: false,
    theme_advanced_path : false,
    setup : function(ed) {
        ed.onKeyUp.add(function(ed, e) {
            var strip = (tinyMCE.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"");
            var text = strip.split(' ').length + " từ, " +  strip.length + " chữ tự";
            tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
        });
        ed.onLoadContent.add(function(ed, e) {
            var strip = (tinyMCE.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"");
            var text = strip.split(' ').length + " từ, " +  strip.length + " chữ tự";
            tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
        });
    }
});
tinyMCE.init({
    mode : "specific_textareas",
    editor_selector : "tinymce_gallery",
	relative_urls : false, remove_script_host : false, theme : "advanced",
	plugins : "inlinepopups,images",
	theme_advanced_buttons1 : "code,|,images",
	theme_advanced_buttons2 : "", theme_advanced_buttons3 : "", theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "right", theme_advanced_statusbar_location : "",
	theme_advanced_resizing : false, width: '100%', height: 320,
    entity_encoding : "raw",
    content_css : '<?php echo BASE_ASSET ?>css/tinymce_content.css'
});
tinyMCE.init({
    mode : "specific_textareas",
    editor_selector : "tinymcemini",
	relative_urls : false, remove_script_host : false, theme : "advanced",
	plugins : "inlinepopups,preview,media,fullscreen,embed",
	theme_advanced_buttons1 : "code,link,unlink,image,media,preview,fullscreen,embed",
	theme_advanced_buttons2 : "", theme_advanced_buttons3 : "", theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "bottom", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "",
	theme_advanced_resizing : false, width: '100%', height: 350,
    entity_encoding : "raw"
});
tinyMCE.init({
    mode : "specific_textareas",
    editor_selector : "tinymce_link_ul",
	relative_urls : false, remove_script_host : false, theme : "advanced",
	plugins : "inlinepopups",
	theme_advanced_buttons1 : "code,bullist,link,unlink",
	theme_advanced_buttons2 : "", theme_advanced_buttons3 : "", theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "bottom", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "",
	theme_advanced_resizing : false, width: '100%', height: 350,
    entity_encoding : "raw",
    content_css : '<?php echo BASE_ASSET ?>css/tinymce_link_ul.css'
});
</script>
<script src="<?php echo URL_JS ?>/jquery.ui.touch-punch.min.js"></script>