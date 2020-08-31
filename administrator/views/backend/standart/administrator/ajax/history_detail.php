<div class="modal-footer" style="padding: 5px 15px;">
    <button type="button" class="btn red mini" data-dismiss="modal" aria-hidden="true"><i class="icon-eject"></i> Đóng</button>
</div>
<div class="modal-body">
    <table class="table table-bordered" id="tbl_detail_history">
		<tbody>
            <tr>
                <?php
                $this->load->model('News_model');
                $this->load->model('Category_model');
                $this->load->model('Tag_model');
                $clsNews = new News_model();
                $clsCategory = new Category_model();
                $this->load->model('User_model'); $clsUser = new User_model();
                $clsTag = new Tag_model();
                $obj = json_decode($one['data']); if ($obj) {
                    foreach ($obj as $key=>$o) {
                        ?>
                <td style="width:20%">
                <?php
                $arr = array();
                        $arr['content']             = 'Nội dung';
                        $arr['title']               = 'Tiêu đề';
                        $arr['intro']               = 'Mô tả ngắn';
                        $arr['status']              = 'Trạng thái';
                        $arr['news_path']           = 'Tin liên quan';
                        $arr['meta_title']          = 'Tiêu đề Google';
                        $arr['meta_keyword']        = 'Từ khóa Google';
                        $arr['tags']                = 'Từ khóa CMS';
                        $arr['meta_description']    = 'Mô tả Google';
                        $arr['push_date']           = 'Giờ xuất bản';
                        $arr['category_id']         = 'Chuyên mục';
                        $arr['image']               = 'Hình ảnh';
                        $arr['last_edit_user']      = 'Người sửa';
                        $arr['tag_path']            = 'Từ khóa';
                        $arr['last_change_status']  = 'Thay đổi trạng thái';
                        $arr['type_post']           = 'Loại bài';
                        $arr['royalty_error']       = 'Ghi chú';
                        $arr['royalty']             = 'Nhuận bút';
                        $arr['intro_detail']        = 'Mô tả trang chi tiết';
                        $arr['slide']               = 'Ảnh TO đầu nội dung';
                        $arr['is_trash']            = 'Xóa tạm';
                        $arr['push_user']           = 'Người xuất bản';
                        $arr['signature']           = 'Tác giả';
                        $arr['news_suggest']           = 'Tin nên đọc';
                        if (isset($arr[$key])) {
                            echo $arr[$key];
                        } else {
                            echo $key;
                        } ?>
                </td>
                <td>
                <?php
                if ($key=='last_change_status') {
                    $o = date('d/m/Y H:i', $o);
                } elseif ($key=='status') {
                    $o = $clsNews->getTitleStatus($o);
                } elseif ($key=='push_date') {
                    $o = date('d/m/Y H:i', strtotime($o));
                } elseif ($key=='category_id') {
                    $o = $clsCategory->getTitle($o);
                } elseif ($key=='image') {
                    $o = '<img src="'.MEDIA_DOMAIN.$o.'" width="250" />';
                } elseif ($key=='last_edit_user' || $key=='push_user') {
                    $o = $clsUser->getFullname($o);
                } elseif ($key=='type_post') {
                    $o = $clsNews->getType($o);
                } elseif ($key=='royalty') {
                    $o = toString($o);
                } elseif ($key=='is_trash') {
                    if ($o==1) {
                        $o = 'Đã xóa tạm';
                    } else {
                        $o = 'Khôi phục';
                    }
                } elseif ($key=='tag_path') {
                    $arr = pathToArray($o);
                    $o = '';
                    if ($arr) {
                        foreach ($arr as $id) {
                            $o .= $clsTag->getTitle($id).', ';
                        }
                    }
                    $o = rtrim($o, ', ');
                } elseif ($key=='news_path' || $key=='news_suggest') {
                    $arr = pathToArray($o);
                    $o = '';
                    if ($arr) {
                        foreach ($arr as $id) {
                            $o .= '<p><a href="'.str_replace('cms.', 'www.', $clsNews->getLink($id)).'" target="_blank">'.$clsNews->getTitle($id).'</a></p>';
                        }
                    }
                }
                        echo $o; ?>
                </td>
            </tr>
            <?php
                    }
                } else {
                    echo '<p style="font-size: 27px;color: #999;margin: 45px 0;text-align: center;">Không có gì thay đổi</p>';
                } ?>
		</tbody>
	</table>
</div>