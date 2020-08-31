<?= get_header(); ?>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3LZFVP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<main>
<div class="inner" style="background-color: white;">
<div class="top-main">
<?php getBlock('breaknews') ?>
<?php getBlock('fanpage') ?>
<div class="clearfix"></div>
</div>
<div class="main-1">
<?php getBlock('pick', 'News') ?>
<div class="col-fixed-300 pull-right">
<?php getBlock('parner', 'News') ?>
</div>
<div class="clearfix"></div>
</div>
<div id="multimedia_box" class="main-2">
<?php getBlock('box_nb_2_full', 'News') ?>
</div>
<!--<div class="ads-full">
    <img src="<?=URL_IMAGES?>/1000x90.png">
</div>-->
<div class="main-3">
<div class="main-31 pull-left" style="width: calc(100% - 300px - 30px);">
<!-- Chính trị xã hội -->
<?php getBlock('box_nb_11', 'News') ?>
<div class="ads-670">
    <?php echo $ads[16]; ?>    
    <!--<img src="<?=URL_IMAGES?>/670x90.png">-->
    <!--<script type="text/javascript" src="//media1.admicro.vn/ads_codes/ads_box_479462.ads"></script>-->
</div>

<?php echo $ads[17]; ?>
<!-- Pháp luật plus -->
<?php getBlock('box_nb_6') ?>
<?php echo $ads[18]; ?>
<!-- Điều tra bạn đọc -->
<?php getBlock('box_nb_3') ?>
<?php echo $ads[19]; ?>
<!-- Kinh tế công nghiệp -->
<?php getBlock('box_nb_5', 'News') ?>
<?php echo $ads[20]; ?>
<!-- BĐS -->
<?php getBlock('box_nb_15', 'News') ?>
<div class="ads-670">
    <?php echo $ads[21]; ?>
</div>
<!-- Doanh nghiệp doanh nhân -->
<?php getBlock('box_nb_16') ?>
<div class="ads-670" style="overflow: hidden;">
    <!--<img src="<?=URL_IMAGES?>/670x90.png">-->
</div>
<?php getBlock('box_nb_17', 'News') ?>
<?php echo $ads[23]; ?>
<?php getBlock('box_nb_7', 'News') ?>
<?php echo $ads[24]; ?>
<?php getBlock('box_nb_9', 'News') ?>
<?php echo $ads[25]; ?>
</div>
<div class="col-fixed-300 main-32 pull-right">
<?php echo $ads[26]; ?>
<?php getBlock('paper', 'Library') ?>
<!--<img src="<?=URL_IMAGES?>/300x600.png">-->
<?php echo $ads[27]; ?>
<?php getBlock('raovat', 'News') ?>
<?php echo $ads[28]; ?>
<!--<img src="<?=URL_IMAGES?>/300x250.png">-->
<!--<img src="<?=URL_IMAGES?>/300x90.png" style="margin-top: 10px">
<img src="<?=URL_IMAGES?>/300x90.png" style="margin-top: 10px">-->
<?php getBlock('docnhieu', 'News') ?>
<?php echo $ads[5]; ?>
</div>
</div>
<div class="ads-full">
    <img src="<?=URL_IMAGES?>/1000x90.png">
</div>
<?php getBlock('box_nb_1_full') ?>
<!--<div style="display: none; padding: 8px 0;"><img src="/ads/banner web_final.png"></div>-->
</div>

</main>

<div class="scroll-top-wrapper show">
  <span class="scroll-top-inner">
    <i class="fa fa-2x fa-arrow-circle-up"></i>
  </span>
</div>
</body>
<?= get_footer(); ?>