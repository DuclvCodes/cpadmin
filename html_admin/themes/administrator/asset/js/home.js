$(document).ready(function(){
    
    $('.easy-pie-chart .number.hits').easyPieChart({
        animate: 1000,
        size: 75,
        lineWidth: 3,
        barColor: App.getLayoutColorCode('green')
    });
    $('.easy-pie-chart .number.used').easyPieChart({
        animate: 1000,
        size: 75,
        lineWidth: 3,
        barColor: App.getLayoutColorCode('red')
    });
    function initMemcache() {
        var data_memcache = [];
        var totalPoints_memcache = 250;
        function getMEMData(value) {
            if (data_memcache.length > 0) data_memcache = data_memcache.slice(1);
            while (data_memcache.length < totalPoints_memcache) {
                var y = value;
                if (y < 0) y = 0;
                if (y > 100) y = 100;
                data_memcache.push(y);
            }
            var res = [];
            for (var i = 0; i < data_memcache.length; ++i) res.push([i, data_memcache[i]])
            return res;
        }
        $('#load_statistics_loading_memcache').hide();
        $('#load_statistics_content_memcache').show();
        var updateInterval = 7000;
        var i = 1;
        function statisticsUpdate() {
            $.getJSON('/ajax/server_MEM', function (json) {
                $('.easy-pie-chart .number.hits').data('easyPieChart').update(json.hit_percent);
                $('.easy-pie-chart .number.hits span').text(json.hit_percent);
                $('.easy-pie-chart .number.used').data('easyPieChart').update(json.mem_used_percent);
                $('.easy-pie-chart .number.used span').text(json.mem_used_percent);
                
                $('#lbl_TotalHits').text(json.keyspace_hits);
                $('#lbl_Misses').text(json.keyspace_misses);
                $('#txt_Memory').text(json.used_memory_human);
                $('#txt_Memory_Total').text(json.used_memory_peak_human);
                
                setTimeout(statisticsUpdate, updateInterval);
            });
        }
        statisticsUpdate();
        
        $('.btn_ajax').click(function(){
            var obj = $(this);
            var title = $(this).text();
            var cls = $(this).attr('class');
            $(this).removeClass('blue').removeClass('green').addClass('red').text('Loading ...');
            $.getJSON(obj.attr('href'), function (json) {
                if(json.res=='0') alert('Có lỗi xảy ra. Vui lòng thử lại sau');
                obj.text(title).attr('class', cls);
            });
            return false;
        });
    }
    initMemcache();
    
    
    
    
});