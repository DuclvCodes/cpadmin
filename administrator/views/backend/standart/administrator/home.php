<script src="<?php echo BASE_ASSET ?>plugins/flot/jquery.flot.js"></script>
<script src="<?php echo BASE_ASSET ?>plugins/flot/jquery.flot.resize.js"></script>
<script src="<?php echo BASE_ASSET ?>plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<link href="<?php echo BASE_ASSET ?>plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php getBlock('menu') ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN PAGE -->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid">
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12">
					<!-- BEGIN STYLE CUSTOMIZER -->
					
					<!-- END BEGIN STYLE CUSTOMIZER -->    
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
						Bảng điều khiển
                        <small style="float: right; margin-top: 19px;font-family: Arial;">Giờ hệ thống: <?=date('H:i:s - d/m/Y')?></small>
					</h3>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<div id="dashboard">
				<!-- BEGIN DASHBOARD STATS -->
                <?php if ($clsUser->permission('home')) {
    ?>
				<div class="row-fluid">
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<div class="dashboard-stat blue">
							<div class="visual">
								<i class="icon-bolt"></i>
							</div>
							<div class="details">
								<div class="number" id="lbl_exitRate"><?=toString($realtime)?></div>
								<div class="desc">người</div>
							</div>
							<a class="more" href="#">Truy cập online <i class="m-icon-swapright m-icon-white"></i></a>
						</div>
					</div>
					<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
						<div class="dashboard-stat purple">
							<div class="visual">
								<i class="icon-user"></i>
							</div>
							<div class="details">
								<div class="number" id="lbl_visitor"><?=toString($ga['visits'])?></div>
								<div class="desc">người</div>
							</div>
							<a class="more" href="#">Số khách truy cập hôm nay <i class="m-icon-swapright m-icon-white"></i></a>
						</div>
					</div>
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<div class="dashboard-stat green">
							<div class="visual">
								<i class="icon-eye-open"></i>
							</div>
							<div class="details">
								<div class="number" id="lbl_pageviews"><?=toString($ga['pageviews'])?></div>
								<div class="desc">trang</div>
							</div>
							<a class="more" href="#">Lượt xem trang hôm nay <i class="m-icon-swapright m-icon-white"></i></a>
						</div>
					</div>
					<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<div class="dashboard-stat yellow">
							<div class="visual">
								<i class="icon-bar-chart"></i>
							</div>
							<div class="details">
								<div class="number" id="lbl_avgTimeOnPage"><?=date('i:s', intval($ga['timeOnPage']))?></div>
								<div class="desc"></div>
							</div>
							<a class="more" href="#">Thời gian trung bình trên trang <i class="m-icon-swapright m-icon-white"></i></a>
						</div>
					</div>
				</div>
                <?php
} ?>
				<!-- END DASHBOARD STATS -->
				<div class="clearfix"></div>
				
                <div class="row-fluid">
						<div class="span6">
							<div class="portlet box blue">
								<div class="portlet-title">
									<div class="caption"><i class="icon-flag"></i>Top bài ngày hôm nay</div>
								</div>
                                <style>
                                #wrap_topviews li {position: relative;}
                                #wrap_topviews .image {float: left; margin-right: 8px;}
                                #wrap_topviews .cont-col1 .label {text-align: center;}
                                #wrap_topviews .date {position: absolute; right: 0; top: 0;}
                                #wrap_topviews .desc {white-space: nowrap;overflow: hidden;-ms-text-overflow: ellipsis;-o-text-overflow: ellipsis;text-overflow: ellipsis; margin-right: 77px;}
                                </style>
								<div class="portlet-body" id="wrap_topviews" style="font-family: Arial;">
									<ul class="feeds">
                                        <?php
                                        
                                        $CI =& get_instance();
                                        $CI->load->model('News_model');
                                        $CI->load->model('Box_model');
                                        $CI->load->model('User_model');
                                        $oneBox = $CI->Box_model->getOne(BOX_TOPVIEWS);
                                        $allNews = pathToArray($oneBox['news_path_show']);
                                        $clsNews = new News_model();
                                        $clsUser = new User_model();
                                        $clsBox = new Box_model();
                                        if ($allNews) {
                                            foreach ($allNews as $key=>$news_id) {
                                                $oneNews = $clsNews->getOne($news_id); ?>
										<li>
                                            <span class="image tooltips" data-placement="right" data-original-title="<?=$clsUser->getFullName($oneNews['user_id'])?>">
                                                <img src="<?=$CI->User_model->getImage($oneNews['user_id'], 28, 28, 'image', '/files/user/noavatar.jpg')?>" />
                                            </span>
                                            <div class="desc">
												<a href="<?=str_replace(ADMIN_DOMAIN, DOMAIN, $clsNews->getLink($news_id))?>" target="_blank" title="<?=htmlentities($oneNews['title'])?>"><?=$oneNews['title']?></a>
											</div>
											<div class="date"><span class="label label-warning label-mini"><?php echo toString($oneNews['views']) ?> lượt đọc</span></div>
										</li>
										<?php if ($key==7) {
                                                    break;
                                                }
                                            }
                                        } ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="portlet box green tasks-widget">
								<div class="portlet-title">
									<div class="caption"><i class="icon-tags"></i>Từ khóa HOT trong ngày</div>
								</div>
								<div class="portlet-body">
									<div style="height: 273px; overflow: hidden;"><iframe style="border: none;" scrolling="no" style="border:none;" width="100%" height="273" src="https://www.google.com/trends/hottrends/widget?pn=p28&tn=50&h=313"></iframe></div>
								</div>
							</div>
						</div>
					</div>
                
                <?php if (isset($visits)) {
                                            ?>
                <div class="portlet solid bordered light-grey">
					<div class="portlet-title">
						<div class="caption"><i class="icon-bar-chart"></i>Site Visits</div>
					</div>
					<div class="portlet-body">
						<div id="site_statistics_loading">
							<img src="/asset/img/ajax-loading.gif" alt="loading" />
						</div>
						<div id="site_statistics_content" class="hide">
							<div id="site_statistics" class="chart"></div>
						</div>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            var json = '<?=$visits?>';
                            json = JSON.parse(json);
                            var today = [];
                            var yesterday = [];
                            $.each(json, function (i, one) {
                                today[i] = [i, one.today];
                                yesterday[i] = [i, one.yesterday];
                            });
                            $('#site_statistics_loading').hide();
                            $('#site_statistics_content').show();
                            var plot_statistics = $.plot($("#site_statistics"), [{data: today,label: "Hôm nay"}, {data: yesterday,label: "Hôm qua"}], {
                                series: {lines: {show: true,lineWidth: 2,fill: true,fillColor: {colors: [{opacity: 0.05}, {opacity: 0.01}]}},points: {show: true},shadowSize: 2},
                                grid: {hoverable: true,clickable: true,tickColor: "#eee",borderWidth: 0},
                                colors: ["#d12610", "#37b7f3", "#52e136"],
                                xaxis: {ticks: 11,tickDecimals: 0},
                                yaxis: {ticks: 11,tickDecimals: 0}
                            });
                        });
                        </script>
					</div>
				</div>
                <?php
										} ?>
				<?php if ($clsUser->permission('home')) {?>
                <div class="row-fluid">
					<div class="span6">
                        <div class="portlet solid bordered light-grey">
							<div class="portlet-title">
								<div class="caption"><i class="icon-leaf"></i>Cache</div>
                                <div class="tools">
									<div class="btn-group pull-right" data-toggle="buttons-radio">
                                        <a href="/ajax/serverFlush" class="btn_ajax red btn mini flushCache">Flush Cache</a>
									</div>
								</div>
							</div>
							<div class="portlet-body">
                                <div class="row-fluid">
									<div class="span4">
										<div class="easy-pie-chart">
											<div class="number hits"><span>_</span>%</div>
											<a class="title" href="#">Hits</a>
										</div>
									</div>
                                    <div class="span4">
										<div class="easy-pie-chart">
											<div class="number used"><span>_</span>%</div>
											<a class="title" href="#">Used</a>
										</div>
									</div>
                                    <div class="span4">
                                        <p>Total hits: <span id="lbl_TotalHits">__</span></p>
                                        <p>Misses: <span id="lbl_Misses">__</span></p>
                                        <p style="border-top: 1px solid #bababa;padding-top: 8px;">Memory Used: <span id="txt_Memory"></span></p>
                                        <p>Total Memory: <span id="txt_Memory_Total">__</span></p>
									</div>
                                </div>
							</div>
						</div>
                        <?php if ($me['group_id']==7) {
                                            ?>
                        <div class="portlet solid bordered light-grey" style="height: 148px;" data-svr="">
							<div class="portlet-title">
								<div class="caption"><i class="icon-hdd"></i>Bandwidth</div>
                                <div class="tools">
									<div class="btn-group pull-right">
                                        <button style="margin-right: 5px;" class="btn mini green" disabled="">Use: <span id="txt_bw"></span> Mbps</button>
										<button style="margin-right: 5px;" class="btn mini" disabled="">Limit: <span class="txtmax"></span> Mbps</button>
                                        <div class="btn-group pull-right select-server bw">
											<a href="" class="btn mini dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Server <span class="t"></span> <span class="icon-angle-down"></span></a>
											<ul class="dropdown-menu pull-right">
												<li><a href="javascript:;" data-svr="WEB" data-max="<?=$sysbw?>" data-hdd="<?=$syshdd.' / '.$sysinfo[2]?>" >WEB</a></li>
												<li><a href="javascript:;" data-svr="MEDIA" data-max="<?=$M_sysbw?>" data-hdd="<?=$M_syshdd.' / '.$M_sysinfo[2]?>" >MEDIA</a></li>
                                                <li><a href="javascript:;" data-svr="DATA" data-max="<?=$D_sysbw?>" data-hdd="<?=$D_syshdd.' / '.$D_sysinfo[2]?>" >DATA</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
                            <div class="portlet-body">
								<div id="load_statistics_loading_bw">
									<img src="/asset/img/ajax-loading.gif" alt="loading" />
								</div>
								<div id="load_statistics_content_bw" class="hide">
									<div id="load_statistics_bw" style="height:108px;"></div>
								</div>
							</div>
						</div>
                        <?php
                                        } ?>
						<!-- END PORTLET-->
					</div>
                    
                    <?php if ($me['group_id']==7) {
                                            ?>
					<div class="span6">
						<!-- BEGIN PORTLET-->
						<div class="portlet solid bordered light-grey" data-svr="">
							<div class="portlet-title">
								<div class="caption"><i class="icon-bolt"></i>CPU Load</div>
                                <div class="tools">
									<div class="btn-group pull-right">
                                        <button style="margin-right: 5px;" class="btn mini green" disabled="">Use: <span id="txt_cpu"></span> %</button>
										<button style="margin-right: 5px;" class="btn mini" disabled="">Total: <span class="txtmax"></span> core</button>
                                        <div class="btn-group pull-right select-server cpu">
											<a href="" class="btn mini dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Server <span class="t"></span> <span class="icon-angle-down"></span></a>
											<ul class="dropdown-menu pull-right">
												<li><a href="javascript:;" data-svr="WEB" data-max="<?php echo $sysinfo[0] ?>">WEB</a></li>
												<li><a href="javascript:;" data-svr="MEDIA" data-max="<?php echo $M_sysinfo[0] ?>">MEDIA</a></li>
                                                <li><a href="javascript:;" data-svr="DATA" data-max="<?php echo $D_sysinfo[0] ?>">DATA</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div id="load_statistics_loading">
									<img src="/ucp/themes/img/loading.gif" alt="loading" />
								</div>
								<div id="load_statistics_content" class="hide">
									<div id="load_statistics" style="height:108px;"></div>
								</div>
							</div>
						</div>
						<!-- END PORTLET-->
						<!-- BEGIN PORTLET-->
						<div class="portlet solid bordered light-grey" data-svr="">
							<div class="portlet-title">
								<div class="caption"><i class="icon-bolt"></i>RAM Load</div>
                                <div class="tools">
									<div class="btn-group pull-right">
										<button style="margin-right: 5px;" class="btn mini green" disabled="">Use: <span id="txt_ram"></span> %</button>
                                        <button style="margin-right: 5px;" class="btn mini" disabled="">Total: <span class="txtmax"></span> GB</button>
                                        <div class="btn-group pull-right select-server ram">
											<a href="" class="btn mini dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Server <span class="t"></span> <span class="icon-angle-down"></span></a>
											<ul class="dropdown-menu pull-right">
												<li><a href="javascript:;" data-svr="WEB" data-max="<?php echo toBytes($sysinfo[1]/1024) ?>" >WEB</a></li>
												<li><a href="javascript:;" data-svr="MEDIA" data-max="<?php echo toBytes($M_sysinfo[1]/1024) ?>" >MEDIA</a></li>
                                                <li><a href="javascript:;" data-svr="DATA" data-max="<?php echo toBytes($D_sysinfo[1]/1024) ?>" >DATA</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div id="load_statistics_loading_ram">
									<img src="/ucp/themes/img/loading.gif" alt="loading" />
								</div>
								<div id="load_statistics_content_ram" class="hide">
									<div id="load_statistics_ram" style="height:108px;"></div>
								</div>
							</div>
						</div>
						<!-- END PORTLET-->
					</div>
                    <?php
                                        } ?>
                    
				</div>
				<?php } ?>
                <div class="clearfix"></div>
				
			</div>
		</div>
		<!-- END PAGE CONTAINER-->    
	</div>
	<!-- END PAGE -->
</div>
<script type="text/javascript">
$(document).on("click", '.flushCache', function(event) { 
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
</script>
<script src="<?php echo BASE_ASSET ?>js/home.js" type="text/javascript"></script>
