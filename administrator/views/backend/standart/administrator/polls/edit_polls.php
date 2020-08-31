
<!--<link href="http://poll.local/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="http://poll.local/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript">
$.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<script src="http://poll.local/bootstrap/js/bootstrap.min.js"></script>
--->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h3 class="page-title">
			Polls
                        <a href="<?php echo site_url("polls/create") ?>" class="btn green pull-right"><?php echo lang("ctn_360") ?></a>
			</h3>
                        <ul class="breadcrumb">
                            <li>
                                    <i class="icon-home"></i>
                                    <a href="/">Bảng điều khiển</a> 
                                    <i class="icon-angle-right"></i>
                            </li>
                            <li class="active">Bình chọn<i class="icon-angle-right"></i></li>
                          </ul>
                        
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                    <div class="row-fluid">
                        <div class="page-toolbar">
                            <div class="span12">
                            <input type="text" class="form-control input-sm" placeholder="Tìm kiếm bình chọn" id="form-search-input" />
                                <input type="hidden" id="search_type" value="0">
                                    
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                    <select name="status" class="m-wrap span2">
                                      <option><a href="#" onclick="change_search(0)"><span class="glyphicon glyphicon-ok" id="search-like"></span>Giống</a></option>
                                      <option><a href="#" onclick="change_search(1)"><span class="glyphicon glyphicon-ok no-display" id="search-exact"></span>Chính xác</a></option>
                                      <option><a href="#" onclick="change_search(2)"><span class="glyphicon glyphicon-ok no-display" id="name-exact"></span>Tên bình chọn</a></option>
                                    </select>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                    </div>
                    <div class="span12">
                    <table id="poll-table" class="table table-striped table-bordered table-advance table-hover act_default">
                        <thead>
                            <tr>
                                <td class="background_white"><?php echo lang("ctn_362") ?></td>
                                <td class="background_white"><?php echo lang("ctn_352") ?></td>
                                <td class="background_white"><?php echo lang("ctn_381") ?></td>
                                <td class="background_white"><?php echo lang("ctn_382") ?></td>
                                <td class="background_white"><?php echo lang("ctn_383") ?></td>
                                <td class="background_white"><?php echo lang("ctn_52") ?></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready(function() {

                   var st = $('#search_type').val();
                    var table = $('#poll-table').DataTable({
                        "dom" : "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                      "processing": false,
                        "pagingType" : "full_numbers",
                        "pageLength" : 15,
                        "serverSide": true,
                        "orderMulti": false,
                        "order": [

                        ],
                        "columns": [
                        null,
                        null,
                        null,
                        null,
                        null,
                        { orderable: false}
                    ],
                        "ajax": {
                            url : "<?php echo site_url("polls/poll_page/" . $page) ?>",
                            type : 'GET',
                            data : function ( d ) {
                                d.search_type = $('#search_type').val();
                            }
                        },
                        "drawCallback": function(settings, json) {
                        $('[data-toggle="tooltip"]').tooltip();
                      }
                    });
                    $('#form-search-input').on('keyup change', function () {
                    table.search(this.value).draw();
                });

                } );
                function change_search(search) 
                    {
                      var options = [
                        "search-like", 
                        "search-exact",
                        "name-exact",
                      ];
                      set_search_icon(options[search], options);
                        $('#search_type').val(search);
                        $( "#form-search-input" ).trigger( "change" );
                    }

                function set_search_icon(icon, options) 
                    {
                      for(var i = 0; i<options.length;i++) {
                        if(options[i] == icon) {
                          $('#' + icon).fadeIn(10);
                        } else {
                          $('#' + options[i]).fadeOut(10);
                        }
                      }
                    }
                </script>
                </div>
        </div>