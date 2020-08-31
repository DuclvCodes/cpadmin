<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <title>Code thời tiết, tỷ giá vàng</title>
    </head>
    <body>
    <select class="sel_weather" style="width:40%;margin-bottom:10px;">
        <option rel="0" value="0">Xem tất cả</option>
        
        <option rel="1" value="1">TP.HỒ CHÍ MINH</option>
        
        <option rel="2" value="2">HÀ NỘI</option>
        
        <option rel="5" value="5">ĐÀ NẴNG</option>
        
        <option rel="3" value="3">HẢI PHÒNG</option>
        
        <option rel="6" value="6">CẦN THƠ</option>
        
        <option rel="7" value="7">AN GIANG</option>
        
        <option rel="8" value="8">BR-VŨNG TÀU</option>
        
        <option rel="15" value="15">BÌNH DƯƠNG</option>
        
        <option rel="16" value="16">BÌNH PHƯỚC</option>
        
        <option rel="17" value="17">BÌNH THUẬN</option>
        
        <option rel="14" value="14">BÌNH ĐỊNH</option>
        
        <option rel="11" value="11">BẠC LIÊU</option>
        
        <option rel="9" value="9">BẮC CẠN</option>
        
        <option rel="10" value="10">BẮC GIANG</option>
        
        <option rel="12" value="12">BẮC NINH</option>
        
        <option rel="13" value="13">BẾN TRE</option>
        
        <option rel="19" value="19">CAO BẰNG</option>
        
        <option rel="18" value="18">CÀ MAU</option>
        
        <option rel="22" value="22">ĐIỆN BIÊN</option>
        
        <option rel="20" value="20">ĐĂK LĂK</option>
        
        <option rel="21" value="21">ĐĂK NÔNG</option>
        
        <option rel="23" value="23">ĐỒNG NAI</option>
        
        <option rel="24" value="24">ĐỒNG THÁP</option>
        
        <option rel="25" value="25">GIA LAI</option>
        
        <option rel="26" value="26">HÀ GIANG</option>
        
        <option rel="27" value="27">HÀ NAM</option>
        
        <option rel="29" value="29">HÀ TĨNH</option>
        
        <option rel="32" value="32">HÒA BÌNH</option>
        
        <option rel="33" value="33">HƯNG YÊN</option>
        
        <option rel="30" value="30">HẢI DƯƠNG</option>
        
        <option rel="31" value="31">HẬU GIANG</option>
        
        <option rel="34" value="34">KHÁNH HÒA</option>
        
        <option rel="35" value="35">KIÊN GIANG</option>
        
        <option rel="36" value="36">KON TUM</option>
        
        <option rel="37" value="37">LAI CHÂU</option>
        
        <option rel="41" value="41">LONG AN</option>
        
        <option rel="40" value="40">LÀO CAI</option>
        
        <option rel="38" value="38">LÂM ĐỒNG</option>
        
        <option rel="39" value="39">LẠNG SƠN</option>
        
        <option rel="42" value="42">NAM ĐỊNH</option>
        
        <option rel="43" value="43">NGHỆ AN</option>
        
        <option rel="44" value="44">NINH BÌNH</option>
        
        <option rel="45" value="45">NINH THUẬN</option>
        
        <option rel="46" value="46">PHÚ THỌ</option>
        
        <option rel="47" value="47">PHÚ YÊN</option>
        
        <option rel="48" value="48">QUẢNG BÌNH</option>
        
        <option rel="49" value="49">QUẢNG NAM</option>
        
        <option rel="50" value="50">QUẢNG NGÃI</option>
        
        <option rel="51" value="51">QUẢNG NINH</option>
        
        <option rel="52" value="52">QUẢNG TRỊ</option>
        
        <option rel="53" value="53">SÓC TRĂNG</option>
        
        <option rel="54" value="54">SƠN LA</option>
        
        <option rel="58" value="58">THANH HÓA</option>
        
        <option rel="56" value="56">THÁI BÌNH</option>
        
        <option rel="57" value="57">THÁI NGUYÊN</option>
        
        <option rel="59" value="59">TIỀN GIANG</option>
        
        <option rel="60" value="60">TRÀ VINH</option>
        
        <option rel="4" value="4">TT HUẾ</option>
        
        <option rel="61" value="61">TUYÊN QUANG</option>
        
        <option rel="55" value="55">TÂY NINH</option>
        
        <option rel="62" value="62">VĨNH LONG</option>
        
        <option rel="63" value="63">VĨNH PHÚC</option>
        
        <option rel="64" value="64">YÊN BÁI</option>
        
    </select>
<div class="clear">&nbsp;</div>
<div class="temp_title">
    <img id="img_cloud"/>
    <span id="temp_text"></span>
</div>
<div class="clear">&nbsp;</div>
<div class="temp_desc" id="temp_desc"></div>
<script>
    var data = <?php echo json_encode($data);?>;
    function change(){
        var rel = $('.sel_weather').val();
        console.log(rel);
        $('#img_cloud').attr('src', data[rel][0]);
        $('#temp_text').html(data[rel][1] + '<sup>o</sup>C');
        $('#temp_desc').html(data[rel][2]);
    }
    $('.sel_weather').change(function(){
        change()
    });
    <?php
        if(!empty($_GET['d'])){
            ?>
                $('.sel_weather option[value='+<?php echo $_GET['d'];?>+']').attr('selected','selected');
            <?php
        }
    ?>
    change();
</script>
</body>
</html>