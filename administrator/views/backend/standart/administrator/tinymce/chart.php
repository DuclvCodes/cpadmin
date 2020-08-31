<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="/asset/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/asset/css/style-responsive.css" rel="stylesheet" type="text/css"/>

    <style>
    body.chart {font-family: Arial; overflow: hidden;}
    #wrap_chart {padding: 15px; height: 230px; overflow: hidden;font-family: Arial; font-size:14px; line-height:25px;color:#111;}
    #chart_1 a {display: none !important;}
    </style>
</head>

<body class="chart">
<div class="modal-footer">
    <button type="submit" id="btn_gen" class="btn red">Tạo biểu đồ</button>
    <button type="submit" news-id="2059443" id="btn_insert_content" class="btn green"><i class="icon-signout"></i> Chèn vào nội dung</button>
    <div style="float: left;">
        <input type="text" name="width" value="" placeholder="Width" style="width: 50px;" />
        <input type="text" name="height" value="" placeholder="Height" style="width: 50px;" />
        <select name="type" style="width: 120px;">
            <option value="0">Biểu đồ cột</option>
            <option value="1">Biểu đồ tròn</option>
        </select>
    </div>
    <div style="clear: both;"></div>
</div>

<form class="horizontal-form" action="" method="post" style="padding: 15px;">
    <div class="row-fluid">
        <div class="span8">
            <div style="text-align: center;">
                <div style="display: inline-block;"><div id="chart_1" class="chart" style="height: 200px; width: 400px;"></div></div>
            </div>
        </div>
        <div class="span4" id="inp_data">
            <div class="control-group">
                <div class="controls">
                    <input name="x[]" type="text" class="m-wrap span6 js" value="" placeholder="X" />
                    <input name="y[]" type="text" class="m-wrap span6 js" value="" placeholder="Y" />
                </div>
            </div>
        </div>
    </div>
</form>


<script src="/asset/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="/asset/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="/asset/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="/asset/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/asset/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="/asset/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="/asset/plugins/amcharts/amexport_combined.js" type="text/javascript"></script>

<script src="/asset/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>

<script src="/asset/tinymce/chart.js" type="text/javascript"></script>

</body>
</html>