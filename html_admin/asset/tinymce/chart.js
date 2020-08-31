$(document).ready(function(){
    
    var html = $('#inp_data').html();
    $('#inp_data').append(html).find('.control-group:last-child').addClass('last').find('.js').removeClass('js');
    $('#inp_data .control-group.last input').focus(function(){
        $(this).parents('.last').before(html).prev().find('input:eq(0)').focus();
        event_inp();
    });
    function event_inp() {
        $('#inp_data .control-group input.js').removeClass('js').blur(function(){
            var val1 = $(this).parents('.control-group').find('input:eq(0)').val();
            var val2 = $(this).parents('.control-group').find('input:eq(1)').val();
            if(val1=='' && val2=='') $(this).parents('.control-group').remove();
        });
    }
    
    var chart;
    function event_gen(data){
        var type = $('select[name=type]').val();
        var width = $('input[name=width]').val();
        var height = $('input[name=height]').val();
        if(type==1) {if(!width) width = 500; if(!height) height = 350;}
        else {if(!width) width = 400; if(!height) height = 200;}
        $('#chart_1').width(width).height(height);
        if(type==1) {
            chart = AmCharts.makeChart("chart_1", {
                "type": "pie",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color":    '#888',
                "dataProvider": data,
                "valueField": "income",
                "titleField": "year"
            });
        }
        else {
            chart = AmCharts.makeChart("chart_1", {
                "type": "serial",
                "theme": "light",
                "pathToImages": "/asset/plugins/amcharts/amcharts/images/",
                "autoMargins": false,
                "marginLeft": 30,
                "marginRight": 8,
                "marginTop": 10,
                "marginBottom": 26,
                "fontFamily": 'Arial',            
                "color":    '#888',
                "dataProvider": data,
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "startDuration": 1,
                "graphs": [{
                    "alphaField": "alpha",
                    "dashLengthField": "dashLengthColumn",
                    "fillAlphas": 1,
                    "title": "Income",
                    "type": "column",
                    "valueField": "income"
                }, {
                    "bullet": "round",
                    "dashLengthField": "dashLengthLine",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "expenses"
                }],
                "categoryField": "year",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                }
            });
        }
    }
    var abc = [{ "year": 2009, "income": 53.5 }, { "year": 2010, "income": 26.2 }, { "year": 2011, "income": 30.1 }, { "year": 2012, "income": 29.5 }, { "year": 2013, "income": 30.6 }];
    event_gen(abc);
    
    $('#btn_gen').click(function(){
        var data = new Array;
        $('#inp_data .control-group').each(function(){
            var val1 = $(this).find('input:eq(0)').val();
            var val2 = $(this).find('input:eq(1)').val();
            if(val1!='' || val2!='') data.push({"year": val1, "income": val2});
        });
        event_gen(data);
        $(this).blur();
        return false;
    });
    
    $("#btn_insert_content").on('click', function () {
        var news_id = $(this).attr('news-id');
        var tmp = new AmCharts.AmExport(chart);
        tmp.init();
        tmp.output({
            output: 'datastring',
            format: 'jpg'
        },function(data) {
            $.post("/tinymce/chart?news_id="+news_id, {
             imageData: encodeURIComponent(data)
            },
            function(msg) {
             top.tinymce.activeEditor.execCommand('mceInsertContent', false, msg);
        top.tinymce.activeEditor.windowManager.close();
            });
        });
        $(this).blur();
    });
});
