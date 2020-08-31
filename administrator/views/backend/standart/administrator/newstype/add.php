<style>
.btn_trash {line-height: 16px; margin-top: 7px; text-decoration: none; border-bottom: 1px solid #d84a38; color: #d84a38; display: inline-block; font-size: 12px; padding: 0 3px;}
.btn_trash:hover {background: #d84a38; color: #FFF !important;}
.tbl_vertical_center td {vertical-align: middle !important;}
#form_default label.lv2 {margin-left: 20px;}
</style>
<div class="page-container row-fluid">
    <?php getBlock('menu') ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title">
                            Thêm chuyên gia
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                                <i class="icon-home"></i>
                                <a href="/">Bảng điều khiển</a> 
                                <i class="icon-angle-right"></i>
                        </li>
                        <li>
                                <a href="/newstype">Loại bài viết</a>
                                <i class="icon-angle-right"></i>
                        </li>
                        <li><a href="#">Thêm mới</a></li>
                    </ul>
                </div>
            </div>
            <div class="row-fluid" style="font-family: Arial;">
                <div class="span12">
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
                    <div class="row-fluid">
                        <div class="span8">
                        <?php if (isset($msg)) {
    echo $msg;
} ?>
                            <div class="control-group">
                                <label class="control-label" for="f_title">Tên loại bài viết</label>
                                <div class="controls">
                                        <input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="f_title">Miêu tả</label>
                                <div class="controls">
                                        <textarea name="description" id="f_intro_detail" class="m-wrap span12" rows="3" ></textarea>
                                </div>
                            </div>
                            </div>
                            <div class="span4">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-share"></i> Cài đặt</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
                                        </div>                                                                                                                                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   
</div>