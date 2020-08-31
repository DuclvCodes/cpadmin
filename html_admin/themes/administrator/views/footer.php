
<script type="text/javascript" src="<?=BASE_ASSET?>js/jquery.min.js"></script>
<script src="<?=BASE_ASSET?>js/jquery.twentytwenty.js" type="text/javascript"></script>
<script src="<?=BASE_ASSET?>js/jquery.event.move.js" type="text/javascript"></script>
<script src="<?=BASE_ASSET?>js/jquery.exslider.js" type="text/javascript"></script>
<script src="<?=BASE_ASSET?>js/tekplus.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(function(){
         
            $(document).on( 'scroll', function(){
         
                if ($(window).scrollTop() > 100) {
                    $('.scroll-top-wrapper').addClass('show');
                } else {
                    $('.scroll-top-wrapper').removeClass('show');
                }
            });
         
            $('.scroll-top-wrapper').on('click', scrollToTop);
        });
         
        function scrollToTop() {
            verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
            element = $('body');
            offset = element.offset();
            offsetTop = offset.top;
            $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
        }
        
    });
</script>
<script type="text/javascript" src="<?=BASE_ASSET?>js/jquery.webticker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=BASE_ASSET?>js/webticker.css" />
<script type="text/javascript" src="<?=BASE_ASSET?>js/jquery.bxslider.js"></script>
<link type="text/css" href="<?=BASE_ASSET?>js/jquery.bxslider.css" />
<script type="text/javascript" src="<?=BASE_ASSET?>js/inewsticker.js"></script>
<script type="text/javascript" src="<?=BASE_ASSET?>/script.js?v=<?=VERSION?>"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=<?=FB_APPID?>";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'vi'}</script>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-9759960868797154",
          enable_page_level_ads: true
     });
</script>
</html>