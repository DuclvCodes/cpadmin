<div class="page-container row-fluid">
	<?=getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
                        <?php
                        if ($is_trash) {
                            echo 'Thùng rác';
                        } elseif ($status==4 && strtotime($push_date)>time()) {
                            echo 'Bài hẹn giờ';
                        } else {
                            echo $clsNews->getTitleStatus($status);
                        }
                        ?>
						&nbsp;<small><?=$title?></small>
                        <a href="#top-trend" data-toggle="modal" class="btn green pull-right"><i class="icon-pencil"></i> Viết gì hôm nay?</a>
                        <?php if ($me['is_push']) {
                            ?><a id="btn_open_box_news" href="#" class="btn red pull-right"><i class="icon-plus"></i> Hộp tin</a><?php
                        } ?>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Bài viết</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Chỉnh sửa</a></li>
					</ul>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
						<div class="row-fluid">
							<div class="span9">
                                <?php if ($editing) {
                            ?>
                                <div class="alert alert-block alert-error fade in">
									<button type="button" class="close" data-dismiss="alert"></button>
									<h4 class="alert-heading">Cảnh báo!</h4>
									<p id="has_user_editing">Tin này đang được duyệt bởi <b><?php echo $editing ?></b></p>
									<p><a class="btn red" href="javascript:history.back()">Back</a></p>
								</div>
                                <?php
                        } ?>
                                <?php if ($msg) {
                            echo $msg;
                        } ?>
                                
                                <?php if ($is_trash==0) {
                            ?>
                                <div class="well" style="padding: 8px 0; border-left: 0; border-right: 0;">
        							<div class="controls">
										<div>
                                            <?php if ($allStatus) {
                                foreach ($allStatus as $kstatus=>$tstatus) {
                                    ?>
                                            <button type="button" class="btn_status btn <?=($status==$kstatus)?'red':'blue'?>" data-key="<?=$kstatus?>"><?=($status==$kstatus)?'<i class="icon-ok"></i> ':''?><?php echo $tstatus; ?></button>
            								<?php
                                }
                            } ?>
                                            <a class="btn" target="_blank" href="http://demo.phapluatplus.vn/category/news-d<?=$news_id?>.html?xemnhanh">Xem nhanh</a>
                                            <?php if ($me['level'] < 2) {
                                ?>
                                            <button type="button" class="btn_status pull-right btn green" data-key="-2"><i class="icon-ok"></i> Ẩn tin nhanh</button>
                                            <?php
                            } ?>
                                            <?php if (!$status) {
                                ?>
                                            <span id="post_has_auto_save" class="pull-right" style="line-height: 34px; color: #777;"><i class="icon-ok" style="font-size: 15px; color: #35aa47;"></i> Auto Save</span>
                                            <?php
                            } ?>
                                        </div>
									</div>
        						</div>
                                <?php
                        } ?>
                                
								<div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group">
        									<label class="control-label" for="f_title">Tiêu đề bài viết</label>
        									<div class="controls">
        										<input name="title" type="text" id="f_title" <?=CMS_MTL?'maxchar="'.CMS_MTL.'"':''?> class="<?=CMS_MTL?'maxchar':''?> m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo htmlspecialchars($title) ?>" />
        									</div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label class="control-label" for="f_type_post">Loại bài</label>
    									<div class="controls">
    										<select name="type_post" class="m-wrap span12" id="f_type_post">
                                                <option value="0">--- Select ---</option>
                                                <?php $allType = $clsNews->getAllType(); if ($allType) {
                            foreach ($allType as $key=>$one) {
                                ?>
                                                <option value="<?=$key?>" <?php if ($type_post==$key) {
                                    echo 'selected="selected"';
                                } ?>><?=$one?></option>
                                                <?php
                            }
                        } ?>
                                            </select>
    									</div>
                                    </div>
                                    
								</div>
                                <div class="control-group">
									<label class="control-label" for="f_intro">Mô tả ngắn</label>
									<div class="controls">
                                        <textarea name="intro" id="f_intro" maxchar="32" class="<?=CMS_MIL?'maxchar':''?> m-wrap span12 required" rows="3" style="margin-bottom: 0;" ><?php echo $intro ?></textarea>
									</div>
								</div>
                                <?php if (!$intro_detail) {
                            ?><div style="text-align: right; margin-bottom: 8px;" class="root ">+ <a href="#filed_detail" class="btn_open_hide">Thêm mô tả dài</a></div><?php
                        } ?>
                                
                                <div class="control-group <?=$intro_detail?'':'hide'?>" id="filed_detail">
									<label class="control-label" for="f_intro_detail">Mô tả dài</label>
									<div class="controls">
                                        <textarea name="intro_detail" id="f_intro_detail" class="m-wrap span12" rows="3" ><?php echo $intro_detail ?></textarea>
									</div>
								</div>
                                
                                <div class="portlet box blue" style="margin-bottom: 0; border-bottom: 0;">
                                	<div class="portlet-title" style="border-bottom: 0;">
                                		<div class="caption"><i class="icon-comment"></i> Nội dung</div>
                                        <div class="tools">
    										<label style="margin-bottom: 0; font-size: 12px;"><input type="checkbox" name="is_fix_tag" value="1" /> Kiểm tra từ khóa bản sắc</label>
    									</div>
                                	</div>
                                </div>
                                <textarea name="content" id="f_content" class="tinymce m-wrap span12" rows="3"><?php echo $content ?></textarea>
                                
                                <div class="row-fluid" style="margin: 8px 0;">
                                    <div class="span6">
                                        
                                    </div>
                                    <div class="span6 control-group" style="text-align: right; margin-bottom: 0;">
                                        <div class="span6"><input maxlength="80" style="margin-bottom: 0; float: left;" name="signature" type="text" id="f_signature"  class="m-wrap span12" placeholder="Tên tác giả" value="<?php echo $signature ?>" /></div>
                                        <div class="span6"><?php echo $clsSource->getSelect('source_id', $source_id, 'span12 select2', false, 'Chọn nguồn') ?></div>
                                    </div>
                                </div>
                                
                                <div class="portlet box blue box_news_suggest" style="margin-top: 18px;">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-globe"></i> Nên đọc</div>
                                        <div class="tools">
                                            <input type="text" placeholder="Từ khóa ..." />
                                            <button type="button" class="btn mini btn_sm"><i class="icon-search"></i></button>
                                        </div>
                                    </div>
                                        <div class="portlet-body">
                                        <ul class="tkp_list"></ul>
                                        <div class="_related_1404022217 _related_1404022217_bottom">
                                            <div><strong class="_related_1404022217_letter">Nên đọc</strong></div>
                                            <div class="wrap_suggest">
                                            <?php $news_suggest = pathToArray($news_suggest); if ($news_suggest) {
                            foreach ($news_suggest as $key=>$sid) {
                                ?>
                                            <div class="_related_1404022217_item <?=($key==3)?'_related_1404022217_item_last':''?>"><input type="hidden" name="news_suggest[]" value="<?=$sid?>"/><a class="_related_1404022217_photo js" target="_blank" href="<?=str_replace(ADMIN_DOMAIN, DOMAIN, $clsNews->getLink($sid))?>"><img src="<?=$clsNews->getImage($sid, 174, 104)?>" alt="" width="174" height="104"></a><i style="margin-left:5px;float:right" class="icon-remove"></i> <a class="_related_1404022217_title" target="_blank" href="<?=str_replace('cms.', 'demo.', $clsNews->getLink($sid))?>"> <?=$clsNews->getTitle($sid)?></a></div>
                                            <?php
                            }
                        } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                        <label class="control-label" for="f_news_path">Tin liên quan</label>
                                        <div class="js_field_path" data-limit="10" data-class="news" data-name="news_path" data-value="<?php echo $news_path ?>" data-placeholder="Danh sách tin liên quan" ></div>
                                </div>
                                
                                <div class="portlet box blue" style="margin-top: 18px;">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-globe"></i> Hỗ trợ SEO</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="control-group hide">
                                        <label class="control-label" for="f_meta_title">Tiêu đề Google</label>
                                        <div class="controls">
                                                <input size="70" name="meta_title" type="text" id="f_meta_title" class="m-wrap span12 maxlength" value="<?php echo htmlspecialchars($meta_title) ?>" />
                                        </div>
                                        </div>
                                        <div class="control-group" style="position: relative;">
                                            <label class="control-label" for="f_meta_keyword">Từ khóa Google</label>
                                            <div class="controls">
                                                <textarea size="255" name="meta_keyword" id="f_meta_keyword" class="m-wrap span12 maxlength required" rows="3" ><?php echo $meta_keyword ?></textarea>
                                            </div>
                                        <div style="position: absolute;bottom: -13px;right: 0;">+ <a id="btn_copy_keyword" href="#">Sao chép xuống ô dưới</a></div>
        								</div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_tags">Từ khóa CMS</label>
                                            <div class="controls" style="display: inline-block; width: 100%;">
                                                    <input name="tags" type="text" id="f_tags" class="tags m-wrap span12" value="<?php echo $tags ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group hide">
                                            <label class="control-label" for="f_meta_description">Mô tả Google</label>
                                            <div class="controls">
                                            <textarea size="160" name="meta_description" id="f_meta_description" class="m-wrap span12 maxlength" rows="3" ><?php echo $meta_description ?></textarea>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                                <?php if ($me['level']<=2) {
                            ?>
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-money"></i> Nhuận bút</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="control-group">
                                            <div class="row-fluid">
                                                <div class="span3">
                                                        <label class="control-label" for="f_royalty">Nhuận bút</label>
                                                        <div class="controls">
                                                        <input type="text" name="royalty" value="<?=($royalty>1)?$royalty:''?>" id="f_royalty" class="mask_currency m-wrap span12" />
                                                </div>
                                                </div>
                                                <div class="span9">
                                                    <label class="control-label" for="f_royalty_error">Ghi chú</label>
                                                    <div class="controls">
                                                    <textarea maxlength="160" name="royalty_error" id="f_royalty_error" class="m-wrap span12" rows="3" ><?=$royalty_error?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                        } ?>
                                <div class="control-group" style="text-align: right;">
                                    <p style="line-height: 31px; padding-right: 8px; margin: 0;">
                                        <?php if ($status<4) {
                            ?>
                                            <span>Giờ xuất bản: </span>
                                            <a href="#" id="btn_push_date">Ngay lập tức</a>
                                            <input name="push_hour" value="<?=date('h:i A')?>" id="f_push_hour" type="text" class="clockface m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 100px; background: #FFF; display: none;" />
                                            <input name="push_date" value="<?=date('d/m/Y')?>" type="text" value="" class="datepicker m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 180px; background: #FFF; text-align: center; display: none;" />
                                        <?php
                        } else {
                            ?>
                                            <span>Giờ xuất bản: </span>
                                            <input name="push_hour" value="<?=$push_date?date('h:i A', strtotime($push_date)):date('h:i A')?>" id="f_push_hour" type="text" class="clockface m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 100px; background: #FFF;" />
                                            <input name="push_date" value="<?=$push_date?date('d/m/Y', strtotime($push_date)):date('d/m/Y')?>" type="text" value="" class="datepicker m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 180px; background: #FFF; text-align: center;" />
                                        <?php
                        } ?>
                                    </p>
								</div>
                                <?php if ($is_trash==0) {
                            ?>
                                <div class="well" style="padding: 8px 0; border-left: 0; border-right: 0;">
                                <div class="controls">
                                    <div>
                                        <?php if ($allStatus) {
                                foreach ($allStatus as $kstatus=>$tstatus) {
                                    ?>
                                        <button type="button" class="btn_status btn <?=($status==$kstatus)?'red':'blue'?>" data-key="<?=$kstatus?>"><?=($status==$kstatus)?'<i class="icon-ok"></i> ':''?><?php echo $tstatus; ?></button>
                                                                    <?php
                                }
                            } ?>
                                        <a class="btn" target="_blank" href="http://demo.xemnhanh/category/news-d<?=$news_id?>.html?xemnhanh">Xem nhanh</a>
                                        <?php if (!$status) {
                                ?>
                                        <span class="pull-right" style="line-height: 34px; color: #777;"><i class="icon-ok" style="font-size: 15px; color: #35aa47;"></i> Auto Save</span>
                                        <?php
                            } ?>
                                    </div>
                                </div>
                                </div>
                                <p>
                                <span class="label label-success">NOTE:</span>&nbsp;
                                Nhấn <code>Ctrl+S</code> để lưu bài. Hoặc <code><input type="submit" value="Submit" style=" background: none; border: none; margin: 0; padding: 2px 4px; color: #d14; "/></code>
                                </p>
                                <?php
                        } ?>
                                
                                </div>
                                <!--/span-->
                                <div class="span3">
                                <?php getBlock('message'); ?>
                                
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-bookmark"></i> Thông tin chung</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="control-group">
                                            <label class="control-label" for="f_action_path">Bạn muốn gửi bài này cho ai?</label>
                                            <div class="controls" style="display: inline-block; width: 100%;">
                                                    <input name="action_path" type="text" id="f_action_path" class="m-wrap span12" value="<?php echo trim($action_path, '|') ?>" />
                                            </div>
                                            
                                            <div class="alert alert-info">
                                                <span class="help-block">Tác giả: <b><?php echo $clsUser->getLashName($user_id) ?></b> viết lúc <b><?php echo date('H:i d/m/y', strtotime($reg_date)) ?></b></span>
                                                <?php if ($last_edit_user) {
                            ?>
                                                <span class="help-block">Sửa lần cuối: <b><?php echo $clsUser->getLashName($last_edit_user) ?></b> lúc <b><?php echo date('H:i d/m/y', $last_edit) ?></b></span>
                                                <?php
                        } ?>
                                                <span class="help-block">Views: <b id="txt_views"><?=$views?></b> &nbsp; <i class="icon-refresh"></i> <a href="#" class="btn_views" data-id="<?=$news_id?>">Sync</a></span>
                                            </div>
                                            
                                            <?php if ($is_trash==0) {
                            ?>
                                            <div class="alert alert-block alert-success fade in">
            									<button type="button" class="close" data-dismiss="alert"></button>
            									<?php if ($status==4) {
                                ?>
                                                <p><i class="icon-caret-right"></i> <a target="_blank" href="https://developers.facebook.com/tools/debug/sharing/?q=<?=rawurlencode(str_replace(ADMIN_DOMAIN,DOMAIN, $clsNews->getLink($news_id)))?>">Sửa lỗi share Facebook</a></p>
                                                <?php if ($me['is_push']) {
                                    ?><p><i class="icon-caret-right"></i> <a target="_blank" href="https://www.google.com/webmasters/tools/googlebot-fetch?hl=vi&siteUrl=<?=PCMS_URL?>/&path=<?=str_replace(PCMS_URL.'/', '', $clsNews->getLink($news_id))?>">Tìm nạp như Google</a></p><?php
                                } ?>
                                                <p><i class="icon-caret-right"></i> <a href="/news/live?id=<?=$news_id?>">Tường thuật trực tiếp</a></p>
                                                <?php
                            } ?>
                                                <p><i class="icon-caret-right"></i> <a href="/history?news_id=<?=$news_id?>" target="_blank">Lịch sử chỉnh sửa bài</a></p>
            								</div>
                                            
                                            <div class="controls controls-row">
                                                <?php if ($status != 4) {
                                ?>
                                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" href="/<?php echo $mod ?>/trash?id=<?php echo $_GET['id'] ?>" class="btn red pull-left">Bỏ vào thùng rác</a>
                                                <?php
                            } ?>
                                                <?php if ($status==4) {
                                ?>
                                                <a href="#" class="btn green pull-right modal_box_news">
                                                    <i class="icon-plus"></i> Thêm vào Hộp tin</a>
                                                <?php
                            } ?>
                                            </div>
                                            <?php
                        } else {
                            ?>
                                            <div class="controls controls-row">
                                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" href="/<?php echo $mod ?>/delete?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                                <a href="/<?php echo $mod ?>/restore?id=<?php echo $_GET['id'] ?>" class="btn green pull-right"><i class="icon-undo"></i> Phục hồi</a>
                                            </div>
                                            <?php
                        } ?>
                                                </div>

                                        </div>
                                </div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-picture"></i> Ảnh đại diện</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail">
                                                                <img id="img_image_preview" src="<?php if ($image) {
                            echo MEDIA_DOMAIN.$image;
                        } else {
                            echo BASE_ASSET.'images/no-photo.jpg';
                        } ?>" alt="" />
                                                        </div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
                                                        <div>
                                                                <span class="btn btn-file"><span class="fileupload-new">Tải lên</span>
                                                                <span class="fileupload-exists">Thay đổi</span>
                                                                <input id="file_image" type="file" class="default" name="image" /></span>
                                                                
                                                                <?php if ($image) {
                            ?>
                                                                <input id="txt_image" type="hidden" name="image" value="<?=MEDIA_DOMAIN.$image?>" />
                                                                <?php
                        } else {
                            ?>
                                                                <input id="txt_image" type="hidden" name="image" disabled="disabled" />
                                                                <?php
                        } ?>
                                                                <a id="btn_get_image_content_next" href="#" class="btn" style="float: right; display: none;"><i class="icon-chevron-right"></i></a>
                                                                <a id="btn_get_image_content" href="#" class="btn green" style="float: right;">Nội dung <span></span></a>
                                                                                                                    <a id="btn_get_image_content_prev" href="#" class="btn" style="float: right; display: none;"><i class="icon-chevron-left"></i></a>
                                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
                                                        </div>
                                                </div>
                                        </div>                                        
        							</div>
        						</div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-folder-open"></i> Chuyên mục</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_title">Chuyên mục chính</label>
        									<div class="controls" style="display: inline-block; width: 100%;">
                                                <select name="category_id" class="span12 required"><option value="">-- Chuyên mục --</option><?php echo $html_category_id ?></select>
        									</div>
        								</div>
                                        <?php if ($is_null_cat_path) {
                            ?>
                                        <div class="root">+ <a href="#wrap_category_path" class="btn_open_hide">Thêm chuyên mục liên quan</a></div>
                                        <div class="control-group hide" id="wrap_category_path">
        									<label class="control-label" for="f_title">Chuyên mục liên quan</label>
        									<div class="controls" style="height: 200px;overflow: auto;border: 1px solid #ccc;padding: 8px;">
        										<?php echo $html_category_path ?>
        									</div>
        								</div>
                                        <?php
                        } else {
                            ?>
                                        <div class="control-group" id="wrap_category_path">
        									<label class="control-label" for="f_title">Chuyên mục liên quan</label>
        									<div class="controls" style="height: 200px;overflow: auto;border: 1px solid #ccc;padding: 8px;">
        										<?php echo $html_category_path ?>
        									</div>
        								</div>
                                        <?php
                        } ?>
        							</div>
        						</div>
                                
                                
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-cogs"></i> Cài đặt</div>
        							</div>
        							<div class="portlet-body">
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_photo" value="0" />
            												<input name="is_photo" value="1" type="checkbox" class="toggle" <?php if ($is_photo) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Tin ảnh</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_video" value="0" />
            												<input name="is_video" value="1" type="checkbox" class="toggle" <?php if ($is_video) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Tin video</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_audio" value="0" />
            												<input name="is_audio" value="1" type="checkbox" class="toggle" <?php if ($is_audio) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Tin audio</td>
        										</tr>
                                                                                        <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_pick" value="0" />
            												<input name="is_pick" value="1" type="checkbox" class="toggle" <?php if ($is_pick) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Nổi bật mục</td>
        										</tr>
                                                                                        <tr>
        										</tr>
                                                                                        <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_comment" value="0" />
            												<input name="is_comment" value="1" type="checkbox" class="toggle" <?php if ($is_comment) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Bình luận</td>
        										</tr>
                                                                                        <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_index" value="0" />
            												<input name="is_index" value="1" type="checkbox" class="toggle" <?php if ($is_index) {
                            echo 'checked="checked"';
                        } ?> />
            											</div>
        											</td>
        											<td>Cho phép Google tìm thấy</td>
        										</tr>
                                                <?php if ($me['level']<=2) {?>
                                                <tr>
                                                    <td>
                                                        <div class="toggle_button">
                                                            <input type="hidden" name="active_audio" value="0" />
                                                            <input name="active_audio" value="1" type="checkbox" class="toggle" <?php if ($active_audio) {
                            echo 'checked="checked"';
                        } ?> />
                                                        </div>
                                                    </td>
                                                    <td>Kích hoạt tin audio</td>
                                                </tr>
                                                <?php } ?>
                                                <?php if ($me['level']<=2) {?>
                                                <tr>
                                                    <td>
                                                        <div class="toggle_button">
                                                            <input type="hidden" name="is_emagazine" value="0" />
                                                            <input name="is_emagazine" value="1" type="checkbox" class="toggle" <?php if ($is_emagazine) {
                            echo 'checked="checked"';
                        } ?> />
                                                        </div>
                                                    </td>
                                                    <td>Kích hoạt tin E-Magazine</td>
                                                </tr>
                                                <?php } ?>
        									</tbody>
        								</table>
        							</div>
        						</div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-flag"></i> Khác</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="row-fluid">
                                            <div class="control-group">
            									<label class="control-label" for="f_title">Dòng sự kiện</label>
            									<div class="controls" style="display: inline-block; width: 100%;">
            										<?php echo $clsChannel->getSelect('channel_id', $channel_id, 'span12 select2') ?>
            									</div>
            								</div>
                                        </div>
        							</div>
        						</div>
                                
							</div>
							<!--/span-->
						</div>
                        <input name="status" value="<?=$status?>" type="hidden" />
					</form>
                    <br /><br />
                    <br /><br />
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<?php if (DEVICE=='desktop') {
                            getBlock('tinymce');
                        } else {
                            getBlock('tinymce_mobile');
                        } ?>
<div id="mnu_box_news" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<div id="top-trend" class="modal hide fade" data-width="600" style="height: 381px; overflow: hidden;"><iframe scrolling="no" style="border:none;" width="600" height="413" src="https://www.google.com/trends/hottrends/widget?pn=p28&amp;tn=50&amp;h=413"></iframe></div>
<script type="text/javascript">
$(document).ready(function(){
    $('.fileupload.fileupload-new .thumbnail').on('click',function(){
        return false;
    }).on('mousedown',function(){
        return false;
    }).on('mouseup',function(){
        return false;
    }).on('mousemove',function(){
        return false;
    });
    
    
    /* SAVE CTRL S */
    $(document).keydown(function(event) {
        if (String.fromCharCode(event.which).toLowerCase() == 's' && (event.ctrlKey||event.metaKey)) {
            event.preventDefault();
            $('form#form_default').submit();
            return false;
        }
    });
    
    var $modal_box_news = $('#mnu_box_news');
    $('a.modal_box_news').click(function(){
        $('body').modalmanager('loading');
        $modal_box_news.load('/ajax/getListBox?news_id=<?php echo $news_id ?>', '', function(){
            $modal_box_news.modal().on("hidden", function() {
                $modal_box_news.empty();
            });
        });
        return false;
    });
    
    $('#btn_open_box_news').click(function(){
        $('body').click();
        $('body').modalmanager('loading');
        $modal_box_news.load('/ajax/getListBox?news_id=0', '', function(){
            $modal_box_news.modal().on("hidden", function() {
                $modal_box_news.empty();
            });
        });
        return false;
    });
});
</script>
<div id="wrap_js_image_content" class="hide"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('body').addClass('page-sidebar-closed');
    $("#f_action_path").select2({
        tags: [<?php if ($allUser) {
                            foreach ($allUser as $key=>$user_id) {
                                if ($key) {
                                    echo ',';
                                }
                                echo "{id: ".$user_id.", text: '".$clsUser->getFullName($user_id)."'}";
                            }
                        } ?>],
        separator: '|'
    });
    $('#btn_copy_keyword').click(function(){
        var str = $('#f_meta_keyword').val();
        $('input[name=tags]').importTags(str);
        return false;
    });
    
    var index_image_content = 1;
    function getImageContent(index) {
        $('.btn.fileupload-exists').click();
        var data = $('#f_slide').val()+' '+$('#f_content').val();
        $('#wrap_js_image_content').html(data);
        $('#wrap_js_image_content').find('._related_1404022217').remove();
        var img = $('#wrap_js_image_content').find('img:eq('+(index_image_content-1)+')').attr('src');
        $('#img_image_preview').attr('src', img);
        var count_img = $('#wrap_js_image_content').find('img').length;
        if(index<=1) $('#btn_get_image_content_prev').hide();
        else if(index<count_img) $('#btn_get_image_content_prev').show();
        if(index>=count_img) $('#btn_get_image_content_next').hide();
        else if(index>0) $('#btn_get_image_content_next').show();
        $('#btn_get_image_content span').html('('+index+'/'+count_img+')');
        $('#txt_image').removeAttr('disabled').val(img);
    }
    $('#btn_get_image_content').click(function(){
        index_image_content = 1;
        getImageContent(index_image_content);
        return false;
    });
    $('#btn_get_image_content_prev').click(function(){
        index_image_content--;
        getImageContent(index_image_content);
        return false;
    });
    $('#btn_get_image_content_next').click(function(){
        index_image_content++;
        getImageContent(index_image_content);
        return false;
    });
    $('#file_image').change(function(){
        if($(this).val()!='') {
            $('#txt_image').attr('disabled', 'disabled');
            index_image_content = 1;
            $('#btn_get_image_content span').html('');
            $('#btn_get_image_content_prev').hide();
            $('#btn_get_image_content_next').hide();
        }
    });
    
    $('.btn_status').click(function(){
        if($('body').hasClass('content_edited')) $('body').removeClass('content_edited');
        var val = $(this).attr('data-key');
        $('#form_default input[name=status]').val(val);
        $('#form_default').submit();
        return false;
    });
    $('#btn_push_date').click(function(){
        $(this).hide();
        $('input[name=push_date]').show();
        $('input[name=push_hour]').show();
        return false;
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    if($('#post_has_auto_savez').length>0) {
        setInterval(function(){
            $('#progress').removeClass('done').addClass('waiting').width('100%');
            $.ajax({
        		type: "POST",
        		url: "/news/edit?autosave=<?=$news_id?>",
        		data:  $('#form_default').serialize(),
        		dataType: "html",
        		success: function(msg){
        			setTimeout(function(){$('#progress').removeClass('waiting').addClass('done').width(0);}, 1000);
        		}
        	});
        }, 10000);
    }
});
</script>
<!--<script type="text/javascript">
$(document).ready(function(){
    if($('#post_has_auto_save').length>0) {
        setInterval(function(){
            $('#progress').removeClass('done').addClass('waiting').width('100%');
            $.ajax({
        		type: "POST",
        		url: "/news/edit?autosave=<?=$news_id?>&id=<?=$news_id?>",
        		data:  $('#form_default').serialize(),
        		dataType: "html",
        		success: function(msg){
        			setTimeout(function(){$('#progress').removeClass('waiting').addClass('done').width(0);}, 1000);
        		}
        	});
        }, 10000);
    }
});
</script>-->
<script type="text/javascript">
$(document).ready(function(){
    $('.btn_views').click(function(){
        var id = $(this).attr('data-id');
        var obj = $(this); obj.text('Loading ...');
        $.ajax({
    		type: "GET", url: "/cron/ga_news?news_id="+id, dataType: "html",
    		success: function(msg){$('#txt_views').text(msg); obj.text('Refresh');}
    	});
        return false;
    });
    
    $('.box_news_suggest').each(function(){
        var obj = $(this);
        var total = obj.find('._related_1404022217_item').length;
        obj.find('.btn_sm').click(function(){
            var title = obj.find('.tools input[type=text]').val();
            $.ajax({
        		type: "POST",
        		url: "/ajax/getNewsSuggest",
        		data:  {iClass: 'news', keyword: title},
        		dataType: "html",
        		success: function(msg){
        			obj.find('.tkp_list').html(msg);
                    obj.find('.tkp_list a').unbind().click(function(){
                        if(total==4) {alert('Chỉ được nhập tối đa 4 bài viết'); return false;} total++;
                        var classz = '_related_1404022217_item'; if(total==4) classz += ' _related_1404022217_item_last';
                        obj.find('.wrap_suggest').append('<div class="'+classz+'"><input type="hidden" name="news_suggest[]" value="'+$(this).attr('data-id')+'"><a class="_related_1404022217_photo js" target="_blank" href="'+$(this).attr('href')+'"><img src="'+$(this).attr('data-image')+'" alt="" width="174" height="104"></a><i style="margin-left:5px;float:right" class="icon-remove"></i> <a class="_related_1404022217_title" target="_blank" href="'+$(this).attr('href')+'">'+$(this).text()+'</a></div>');
                        $('._related_1404022217_item i.icon-remove').click(function() {
                            $(this).parents('._related_1404022217_item').remove();
                            total--;
                        });
                        return false;
                    });
        		}
        	});
            return false;
        });
        obj.find('.tools input[type=text]').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                obj.find('.btn_sm').click();
                return false;
            }
        });
        obj.find('._related_1404022217_photo.js').removeClass('js').click(function(){
            if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                $(this).parents('._related_1404022217_item').remove();
                if(total==4) obj.find('._related_1404022217_item_last').removeClass('_related_1404022217_item_last'); total--;
            }
            return false;
        });
        $('._related_1404022217_item i.icon-remove').click(function() {
            $(this).parents('._related_1404022217_item').remove();
            total--;
        });
    });
    jQuery(window).bind(
        "beforeunload",
        function() {
            if($('body').hasClass('content_edited')) return confirm("Do you really want to close?");
        }
    )
});
</script>