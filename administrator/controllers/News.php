<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class News extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $mod = 'News_model';
        //setLinkDefault();
        $clsCategory = $this->load->model('Category_model');
        $clsUser = $this->load->model('User_model');
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $this->User_model->getMe();
        $assign_list['me'] = $me;
        if (count($_GET) == 0) {
            redirect(base_url('news?user_id='.$me['user_id']));
        }
        $clsClassTable = $this->load->model('News_model');
        
        $this->load->model('Source_model');
        $assign_list['clsSource'] = new Source_model();
        $classTable = ucfirst(strtolower($mod));
        $assign_list["classTable"] = $classTable;
        //$clsClassTable = new $classTable;
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $this->News_model->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        
        #
        $this->load->model('Log_model');
        $clsLogs = new Log_model();
        $assign_list['clsLogs'] = $clsLogs;
        #
        if ($me['level']>=3) {
            $user_id = $me['user_id'];
            if (isset($_GET['status']) && $_GET['status']=='3.4.5') {
                unset($_GET['status']);
                $status_path = '3.4.5';
            }
        }
        $cons = "is_trash=0";
        if (isset($_GET['is_trash']) && $_GET['is_trash']==1) {
            $cons = "is_trash=1";
        }
        if (isset($_GET['status']) && $_GET['status']==0) {
            $user_id = $me['user_id'];
        }
        #
        if (isset($_GET['is_photo'])) {
            $cons .= " and is_photo=".$_GET['is_photo'];
        }
        if (isset($_GET['is_video'])) {
            $cons .= " and is_video=".$_GET['is_video'];
        }
        if (isset($_GET['type_post']) && $_GET['type_post']) {
            $cons .= " and type_post=".$_GET['type_post'];
        }
        if (isset($_GET['push_user']) && $_GET['push_user']) {
            $cons .= " and push_user=".$_GET['push_user'];
        }
        #
        $assign_list['type_is'] = $type_is = isset($_GET['type_is']) ? $_GET['type_is'] : 0;
        if ($type_is>0) {
            if ($type_is==1) {
                $cons .= " and is_photo=1";
            } elseif ($type_is==2) {
                $cons .= " and is_video=1";
            } elseif ($type_is==3) {
                $cons .= " and is_photo=0 and is_video=0";
            }
        }
        #
        
        if (isset($_GET['status'])) {
            if ($_GET['status']==-1) {
                $cons .= " and status=4 and push_date>=now()";
            } elseif ($_GET['status']==-2) {
                $cons .= " and action_path like '%|".$me['user_id']."|%'";
            } else {
                $cons .= " and status=".$_GET['status'];
            }
        }
        $assign_list['push_user'] = isset($_GET['push_user']) ? $_GET['push_user'] : false;
        $assign_list['uid'] = $uid = isset($_GET['uid']) ? $_GET['uid'] : false;
        $assign_list['user_id'] = $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : false;
        $assign_list['status_path'] = $status_path = isset($_GET['status_path']) ? $_GET['status_path'] : false;
        $assign_list['txt_start'] = $txt_start = isset($_GET['txt_start']) ? $_GET['txt_start'] : false;
        $assign_list['txt_end'] = $txt_end = isset($txt_end) ? $txt_end : false;
        
        if (isset($uid) && $uid) {
            $cons .= " and user_id=".$uid;
        } elseif (isset($user_id) && $user_id) {
            $cons .= " and user_id=".$user_id;
        }
        if (isset($status_path) && $status_path) {
            $cons .= " and status in(".addslashes(str_replace(".", ",", $status_path)).")";
        }
        if (isset($txt_start) && $txt_start) {
            $cons .= " and last_change_status>=".strtotime($txt_start.' 00:00:00');
        }
        if (isset($txt_end) && $txt_end) {
            $cons .= " and last_change_status<=".strtotime($txt_end.' 23:59:59');
        }

        # Validate
        if ($user_id && $user_id!=$me['user_id']) {
            redirect(base_url('news?user_id='.$me['user_id']));
        }
        #
        $assign_list['category_id'] = $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : false;
        if ($category_id) {
            $allCat = $this->Category_model->getChild($category_id);
            $allCat[] = $category_id;
            $cons.=" and category_id in (".implode(',', $allCat).")";
        }
        $assign_list['$keyword'] = $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : false;
        if ($keyword) {
            $cons .= " and title like '%".$keyword."%'";
        }
        #
        if (isset($_GET['status'])) {
            $order = "last_change_status desc, news_id desc";
        } else {
            $order = 'reg_date desc, news_id desc';
        }
        #
        $assign_list['push_from'] = $push_from = isset($_GET['push_from']) ? $_GET['push_from'] : false;
        $assign_list['push_to'] = $push_to = isset($_GET['push_to']) ? $_GET['push_to'] : false;
        $assign_list['reg_from'] = $reg_from = isset($_GET['reg_from']) ? $_GET['reg_from'] : false;
        $assign_list['reg_to'] = $reg_to = isset($_GET['reg_to']) ? $_GET['reg_to'] : false;
        
        if(isset($_GET['uid']) && $_GET['uid']) $cons .= " and user_id=".$_GET['uid'];
        elseif(isset($_GET['user_id']) && $_GET['user_id']) $cons .= " and user_id=".$_GET['user_id'];
        if ($push_from) {
            $cons .= " and push_date>='".date('Y-m-d', strtotime($push_from))." 00:00:00'";
        }
        if ($push_to) {
            $cons .= " and push_date<='".date('Y-m-d', strtotime($push_to))." 23:59:59'";
        }
        if ($reg_from) {
            $cons .= " and reg_date>='".date('Y-m-d', strtotime($reg_from))." 00:00:00'";
        }
        if ($reg_to) {
            $cons .= " and reg_date<='".date('Y-m-d', strtotime($reg_to))." 23:59:59'";
        }
        #
        $listItem = $this->News_model->getListPage($cons." order by ".$order, 50, 'ADMIN');
        $paging = $this->News_model->getNavPage($cons, 50, 'ADMIN');
        $totalPost = $this->News_model->getCount($cons, true, 'ADMIN');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        $assign_list['status'] = isset($_GET['status']) ? $_GET['status'] : 0;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Quản lý bài viết - '.DOMAIN_NAME;
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        $assign_list['mod'] = 'news';
        /*=============Content Page==================*/
        
        $this->render('backend/standart/administrator/news/news', $assign_list);
    }
    public function add()
    {
        $this->load->model('News_model');
        $this->load->model('User_model');
        
        $me = $this->User_model->getMe();
        if (!$me) {
            die('need login ...');
        }
        $data = array();
        $data['last_edit'] = time();
        $data['reg_date'] = date("Y-m-d H:i:s");
        $data['user_id'] = $me['user_id'];
        $data['last_change_status'] = time();
        $data['is_index'] = 1;
        $data['is_comment'] = 1;
        $data['is_ads'] = 0;
        $data['is_pick'] = 1;
        $data['is_trash'] = 0;
        $data['content'] = '<p style="text-align: justify;"> </p>';
        #
        $all = $this->News_model->getAll('user_id="'.$me['user_id'].'" and title="" order by news_id desc limit 1', false);
        if ($all) {
            $news_id = $all[0];
            $oneNews = $this->News_model->getOne($news_id);
            if ($oneNews['is_trash']==1) {
                $this->News_model->deleteArrKey('ADMIN');
            }
            $this->News_model->updateOne($news_id, $data);
            redirect('/news/edit?id='.$news_id);
        } else {
            if ($this->News_model->insertOne($data)) {
                $this->News_model->deleteArrKey('ADMIN');
                $this->News_model->deleteArrKey('CMS');
                $maxId = $this->News_model->getMaxID('CMS');
                redirect('/news/edit?id='.$maxId);
            }
        }
    }
    public function edit()
    {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list["clsNews"] = $clsNews;
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        $oneItem = $clsNews->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        if (isset($oneItem['is_pack'])) {
            redirect('/pack/edit?id='.$_GET['id']);
        }
        #
        $assign_list['msg'] = '';
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $this->User_model->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsNews->getPermissionEdit($oneItem, $me)) {
            die('Stopped ... Bạn không có quyền');
        }
        #
        $tableName = $clsNews->tbl;
        $pkeyTable = $clsNews->pkey;
        #

        if ($this->input->post() && $this->input->post('title')) {
            $data['title'] = $this->input->post('title');
            $data['status'] = $this->input->post('status');
            $data['is_index'] = $this->input->post('is_index');
            $data['is_comment'] = $this->input->post('is_comment');
            $data['is_ads'] = $this->input->post('is_ads');
            $data['is_pick'] = $this->input->post('is_pick');
            $data['meta_title'] = $this->input->post('meta_title');
            $data['push_date'] = datepicker2db($this->input->post('push_date'), false).' '.date('H:i:s', strtotime($this->input->post('push_hour')));
            //unset($push_date);
            $data['royalty'] = toNumber($this->input->post('royalty'));

            $data['slug'] = toSlug($this->input->post('title'));
            if (!$this->input->post('tags')) {
                $data['tags'] = $this->input->post('meta_keyword');
            }
            $data['content'] = str_replace('<p> </p>', '', $this->input->post('content'));
            $data['content'] = str_replace('<p style="text-align: left;"> </p>', '', $this->input->post('content'));
            $data['content'] = str_replace('<p><strong> </strong></p>', '', $this->input->post('content'));
            $data['content'] = str_replace('<p style="text-align: justify;"> </p>', '', $this->input->post('content'));
            $data['content'] = str_replace('         ', ' ', $this->input->post('content'));
            if ($this->input->post('action_path')) {
                $data['action_path'] = '|'.$this->input->post('action_path').'|';
                if ($data['action_path']!=$oneItem['action_path']) {
                    $this->load->model('Chat_model');
                    $clsChat = new Chat_model();
                    $old_arr = pathToArray($oneItem['action_path']);
                    $arr = pathToArray($_POST['action_path']);
                    $body = '<b>'.$me['fullname'].'</b> đã đánh dấu bạn trong bài viết <b>'.$data['title'].'</b>';
                    if ($arr) {
                        foreach ($arr as $user_id) {
                            if (!in_array($user_id, $old_arr)) {
                                $clsChat->sendMessenger($user_id, $body);
                            }
                        }
                    }
                    $clsNews->deleteArrKey('CMS');
                }
            } else {
                $data['action_path'] = '';
            }
            #
            $data['category_path'] = arrayToPath($this->input->post('category_path'));
            $data['news_path'] = arrayToPath($this->input->post('news_path'));
            $data['news_suggest'] = arrayToPath($this->input->post('news_suggest'));
            
            //when user copy and paste to input content, submit post and download file image to storage to our place
            $this->load->helper('simple_html_dom');
            $this->load->model('File_model');
            $clsFile = new File_model();
            $html = str_get_html($data['content']);
            $image = $html->find('img');
            foreach ($image as $key=> $link_image) {
                $host_image = parse_url($link_image->src,PHP_URL_HOST);
                $host_media_server = parse_url(MEDIA_DOMAIN,PHP_URL_HOST);
                if ($host_image['host'] != $host_media_server['host']) {
                    $image_url = strtok($image[$key]->src, '?');
                    $new_image       = $clsFile->downloadMedia($image_url, 'image', '', $me['username']);
                    $link_image->src = MEDIA_DOMAIN.$new_image;
                    $clsImage->insertOne(array('title'=>$data['title'], 'user_id'=>$me['user_id'], 'news_id'=> $_GET['id'], 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$new_image), true, 'USER_'.$me['user_id']);
                }
            }
            $data['content'] = $html->save();
            $html->clear();

            if ($this->input->post('image')) {
                $host_image = parse_url($this->input->post('image'));
                $host_media_server = parse_url(MEDIA_DOMAIN);
                if($host_image['host'] != $host_media_server['host']) {
                    $image_url_feature = strtok($this->input->post('image'), '?');
                    $data['image'] = $clsFile->downloadMedia($image_url_feature, 'image', '', $me['username']);
                }else {
                    $array_path_image = explode('/', $this->input->post('image'));
                    $out = array_diff_key($array_path_image, array(0,1,2,3,4));
                    if ((strpos($this->input->post('image'), 'resize') !== false)) {
                        $data['image'] = '/'.implode('/', $out);
                    } else {
                        $data['image'] = str_replace(MEDIA_DOMAIN, '', $this->input->post('image'));
                    }
                }
                    
            } elseif ($_FILES['image']['name']) {
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $data['image'] = ftpUpload('image', 'News', $data['slug'].'-'.date('His'), time(), MAX_WIDTH, MAX_HEIGHT);
            } elseif (!$oneItem['image'] && $data['content']) {
                $this->load->helper('simple_html_dom');
                $html = str_get_html($this->input->post('slide').' '.$data['content']);
                if ($html) {
                    $first_img = $html->find('img', 0);
                    if ($first_img) {
                        $array_path_image = explode('/', $first_img->src);
                        $out = array_diff_key($array_path_image, array(0,1,2,3,4));
                        if ((strpos($first_img->src, 'resize') !== false)) {
                            $data['image'] = '/'.implode('/', $out);
                        } else {
                            $data['image'] = str_replace(MEDIA_DOMAIN, '', $first_img->src);
                        }
                        //if(substr($data['image'], 0, 8) == '/resize_') $data['image'] = '';
                    } else {
                        foreach ($html->find('iframe') as $e) {
                            $src = $e->src;
                            if (stripos($src, '/watch/')) {
                                $video_id = intval(end(explode('/watch/', $src)));
                                $this->load->model('Video_model');
                                $clsVideo = new Video_model();
                                $oneVideo = $clsVideo->getOne($video_id);
                                $data['image'] = $oneVideo['image'];
                                break;
                            }
                        }
                    }
                }
                $html->clear();
            }
            #
            if ($data['status']==4 && strpos($data['content'], 'figure')) {
                $this->load->helper('simple_html_dom');
                $html = str_get_html($data['content']);
                foreach ($html->find('table.figure') as $e) {
                    $caption = $e->find('tr.figcaption td', 0)->plaintext;
                    if (!$caption || $caption==' ') {
                        $e->find('tr.figcaption td', 0)->innertext = '';
                        $caption=$data['title'];
                    }
                    $e->find('img', 0)->alt=$caption;
                }
                $data['content'] = $html->outertext;
            }
            #check news is Advertisment article
            if ($_GET['is_ads'] == 1) {
                $data['is_ads'] = 1;
                $clsNews->deleteCache(MEMCACHE_NAME.'_ALL_BOX_ADS');
            }
            #
            $data['last_edit'] = time();
            $data['last_edit_user'] = $me['user_id'];
            if ($data['status']!=$oneItem['status']) {
                $data['last_change_status'] = time();
            }
            #
            if ($data['status']==4 && $oneItem['status']!=4) {
                $data['push_user'] = $me['user_id'];
            }
            if ($data['status']==5 && $oneItem['status']!=5) {
                $data['unpush_user'] = $me['user_id'];
            }
            #
            if ($data['status']==4 && strtotime($data['push_date'])>time()) {
                $data['last_change_status'] = strtotime($data['push_date']);
            }
            if ($oneItem['status']==0) {
                $data['reg_date'] = date("Y-m-d H:i:s");
            }
            #
            $this->load->model('Tag_model');
            $clsTag = new Tag_model();
            $data['tag_path'] = $clsTag->stringToPathID($this->input->post('tags'));
            if ($this->input->post('is_fix_tag')) {
                if ($data['is_fix_tag']==1) {
                    $data['content'] = $clsTag->pickToContent($data['content']);
                }
                unset($data['is_fix_tag']);
            }
            #
            if (!isset($_GET['autosave'])) {
                $this->load->model('History_model');
                $clsHistory = new History_model();
                //$data = $_POST;
                $data['news_id'] = $_GET['id'];
                $clsHistory->add($data, 'EDIT', $me['user_id']);
            }
            #
            if ($this->input->post('slide')) {
                $data['slide'] = $this->input->post('slide');
                $this->load->helper('simple_html_dom');
                $html = str_get_html($data['slide']);
                $data['slide']='';
                if ($html) {
                    foreach ($html->find('table.figure') as $key=>$e) {
                        if ($key) {
                            $data['slide'] .= "[n]";
                        }
                        $data['slide'] .= $e->find('img', 0)->src.'[v]'.trim($e->find('tr.figcaption', 0)->plaintext);
                    }
                }
            }

            $data['meta_keyword'] = $this->input->post('meta_keyword');
            $data['type_post'] = $this->input->post('type_post');
            $data['intro'] = $this->input->post('intro');
            $data['intro_detail'] = $this->input->post('intro_detail');
            $data['tags'] = $this->input->post('tags');
            $data['is_pick'] = $this->input->post('is_pick');
            $data['is_video'] = $this->input->post('is_video');
            $data['is_photo'] = $this->input->post('is_photo');
            $data['is_photo'] = $this->input->post('is_photo');
            $data['is_emagazine'] = $this->input->post('is_emagazine');
            $data['category_id'] = $this->input->post('category_id');
            $data['slug_search'] = toNormal($this->input->post('title').'. '.$data['intro'].'. '.$data['tags']);
            $data['signature'] = $this->input->post('signature');
            $data['image_intro'] = $this->input->post('image_intro');
            $data['channel_id'] = $this->input->post('channel_id');
            $data['source_id'] = $this->input->post('source_id');
            $data['active_audio'] = $this->input->post('active_audio');
            #
            if ($clsNews->updateOne($_GET['id'], $data)) {
                $this->load->model('Box_model');
                $clsBox = new Box_model();
                if ($data['status']==1) {       //post trạng thái chờ biên tập
                    if ($oneItem['status']==0) {    //bài hiện tại status đang viết
                        $clsNews->sendNews($_GET['id']);
                    } elseif ($oneItem['action_path']!=$data['action_path']) {
                        $clsNews->sendNews($_GET['id'], pathToArray($oneItem['action_path']));
                    }
                } elseif ($data['status']==4 && $oneItem['status']!=4) { // Xuat ban tin
                    if ($data['is_pick']) {
                        $clsNews->sendToBoxNB($_GET['id']);
                    }
                    if (strtotime($data['push_date'])>time() && ($data['status']!=$oneItem['status'] || $data['push_date']!=$oneItem['push_date'])) {
                        $clsBox->checkTimerFromNews($_GET['id']);
                    }
                    $clsNews->deleteArrKey('CATEGORY'.$oneItem['category_id']);
                } elseif ($oneItem['status']==4 && $data['status']!=4) { // Go tin hoac tra lai bai
                    $clsBox->removeNews($_GET['id']);
                    $clsNews->deleteArrKey('CATEGORY'.$oneItem['category_id']);
                } elseif ($oneItem['status']==4 && $data['status']==4) { // Cap nhat giu trang thai xuat ban
                    if ($oneItem['is_video']!=$data['is_video']) {
                        if ($data['is_video']==1) {
                            $clsBox->addNews(BOX_VIDEO, $_GET['id']);
                        } else {
                            $clsBox->removeNews($_GET['id'], array(BOX_VIDEO));
                        }
                        $clsNews->deleteArrKey();
                    }
                    if ($oneItem['is_photo']!=$data['is_photo']) {
                        if ($data['is_photo']==1) {
                            $clsBox->addNews(BOX_PHOTO, $_GET['id']);
                        } else {
                            $clsBox->removeNews($_GET['id'], array(BOX_PHOTO));
                        }
                        $clsNews->deleteArrKey();
                    }
                }
                //update tags
                //if($data['tags'] != $oneItem['tags']) {
                    $clsNews->deleteArrKey('LIST_TAGS');
                //}
                if ($data['status']!=$oneItem['status'] || $data['push_date']!=$oneItem['push_date']) {
                    $clsNews->deleteArrKey();
                    $clsNews->deleteArrKey('CMS');
                    $clsNews->deleteArrKey('ADMIN');
                    $clsNews->deleteArrKey('ALLNEWS');
                    $oneItem['category_id'] = 0; // delete cache on catpage
                    if (strtotime($data['push_date'])>time()) {
                        $clsBox->checkTimerFromNews($_GET['id']);
                    }
                }
                #
                
                if ($data['channel_id']!=$oneItem['channel_id']) {
                    $this->load->model('Channel_model');
                    $this->Channel_model->deleteArrKey('CHANNEL'.$data['channel_id']);
                    $this->Channel_model->deleteArrKey('CHANNEL'.$oneItem['channel_id']);
                }
                #
                $arr_cat = array();
                
                if ($data['category_id']!=$oneItem['category_id']) {
                    if ($data['category_id']>0) {
                        $arr_cat[$data['category_id']] = $data['category_id'];
                    }
                    if ($oneItem['category_id']>0) {
                        $arr_cat[$oneItem['category_id']] = $oneItem['category_id'];
                        $clsNews->changeBox($_GET['id'], $oneItem['category_id'], $data['category_id']);
                    }
                }
                if ($data['category_path']!=$oneItem['category_path']) {
                    $arr = pathToArray($data['category_path']);
                    if ($arr) {
                        foreach ($arr as $id) {
                            $arr_cat[$id] = $id;
                        }
                    }
                    $arr = pathToArray($oneItem['category_path']);
                    if ($arr) {
                        foreach ($arr as $id) {
                            $arr_cat[$id] = $id;
                        }
                    }
                }
                
                if ($arr_cat) {
                    foreach ($arr_cat as $id=> $value) {
                        $clsNews->deleteArrKey('CATEGORY'.$id);
                        $parent_id = $clsCategory->getParentID($id);
                        if ($data['status']==4) {           //tin duoc public
                        //$this->News_model->addNews($value, $_GET['id']);
                        }
                        if ($parent_id) {
                            $clsNews->deleteArrKey('CATEGORY'.$parent_id);
                        }
                    }
                }
                #
                if (isset($_GET['autosave'])) {
                    die('1');
                }
                message_flash('Update thông tin thành công', 'success');
                if ($data['status']==$oneItem['status']) redirect('/news/edit?id='.$_GET['id']);
                elseif($data['status'] == 4 AND $oneItem['status'] == 3) redirect('/news?status=4');      //trạng thái xuất bản từ chờ xuất bản
                //elseif($data['status'] == 3 AND $oneItem['status'] == 1) redirect('/news?status=1');      //trạng thái duyệt tin từ chờ biên tập
                elseif ($data['status'] != $oneItem['status']) redirect(getLinkDefault());
                else redirect('/news?status='.$data['status']);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module Tin tức: '.json_encode($_POST), false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        $editing = $this->User_model->getEditing($_GET['id']);
        $assign_list["editing"] = $editing;
        $assign_list['allUser'] = $this->User_model->getAll('is_trash=0 and level>0 order by level, user_id', true, 'CMS');
        
        $assign_list['status'] = $oneItem['status'];

        #
        $this->load->model('Channel_model');
        $this->load->model('Event_model');
        $this->load->model('Source_model');
        $this->load->model('Signature_model');
        
        $assign_list['clsChannel'] = new Channel_model();
        $assign_list['clsEvent'] = new Event_model();
        $assign_list['clsSource'] = new Source_model();
        $assign_list['clsSignature'] = new Signature_model();
        #
        $category_path = $me['category_path'];
        if (!$category_path || $category_path=='|0|' || $category_path=='||') {
            $category_path = $clsCategory->getChild(0);
        } else {
            $category_path = explode('|', trim($category_path, '|'));
        }
        $html_category_id = '';
        $html_category_path = '';
        $_category_path = array();
        if ($oneItem['category_path']) {
            $_category_path = explode('|', trim($oneItem['category_path'], '|'));
        }
        $is_null_cat_path = 1;
        if ($category_path) {
            foreach ($category_path as $category_id) {
                $title = $clsCategory->getTitle($category_id);
                $selected = '';
                if ($oneItem['category_id']==$category_id) {
                    $selected = 'selected="selected"';
                }
                $checked = '';
                if (in_array($category_id, $_category_path)) {
                    $checked = 'checked="checked"';
                    $is_null_cat_path = 0;
                }
                $html_category_id .= '<option '.$selected.' value="'.$category_id.'" />'.$title.'</option>';
                $html_category_path .= '<label><input '.$checked.' type="checkbox" name="category_path[]" value="'.$category_id.'" /> '.$title.'</label>';
                $allChild = $clsCategory->getChild($category_id);
                if ($allChild) {
                    foreach ($allChild as $child_id) {
                        $title = $clsCategory->getTitle($child_id);
                        $selected = '';
                        if ($oneItem['category_id']==$child_id) {
                            $selected = 'selected="selected"';
                        }
                        $checked = '';
                        if (in_array($child_id, $_category_path)) {
                            $checked = 'checked="checked"';
                            $is_null_cat_path = 0;
                        }
                        $html_category_id .= '<option '.$selected.' value="'.$child_id.'" />&nbsp;&nbsp;&#8866;&#150;&nbsp'.$title.'</option>';
                        $html_category_path .= '<label class="lv2"><input '.$checked.' type="checkbox" name="category_path[]" value="'.$child_id.'" /> '.$title.'</label>';
                    }
                }
                $html_category_id .= '</optgroup>';
                $html_category_path .= '';
            }
        }

        $assign_list["html_category_id"] = $html_category_id;
        $assign_list["html_category_path"] = $html_category_path;
        $assign_list["is_null_cat_path"] = $is_null_cat_path;
        $assign_list['mod'] = 'News';
        #
        $assign_list["allStatus"] = $clsNews->getListStatus($oneItem['status'], $me['level'], $me['is_push'], $me['is_unpush']);
        #
        
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Sửa bài viết - Admin Control Panel';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function live()
    {
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $this->News_model->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $this->User_model->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        $editing = $this->User_model->getEditing($_GET['id']);
        
        $assign_list["editing"] = $editing;
        #
        if (!$this->News_model->getPermissionEdit($oneItem, $me)) {
            die('Stopped ...');
        }
        #
        $tableName = $this->News_model->tbl;
        $pkeyTable = $this->News_model->pkey;
        #
        if ($this->input->post()) {
            if ($oneItem['content'] && !stripos($oneItem['content'], 'tkp_live')) {
                $oneItem['content'] = '<div id="tkp_live_'.strtotime($oneItem['reg_date']).'" class="tkp_live">'.$oneItem['content'].'</div>';
            }
            if (!isset($_POST['push_hour'])) {
                $_POST['push_hour'] = date('h:i A');
            }
            if (!isset($_POST['push_date'])) {
                $_POST['push_date'] = date('d/m/Y');
            }
            $reg_date = datepicker2db($_POST['push_date'].' '.$_POST['push_hour']);
            unset($_POST['push_date']);
            unset($_POST['push_hour']);
            $reg_date = strtotime($reg_date);
            $_POST['content'] = '<div id="tkp_live_'.time().'" class="tkp_live"><p><b>'.date('H', $reg_date).' giờ '.date('i', $reg_date).' phút, ngày '.date('d/m', $reg_date).'</b></p>'.$_POST['content'].'</div>';
            if (isset($_POST['insert_top']) && $_POST['insert_top']==1) {
                $_POST['content'] = $_POST['content'].$oneItem['content'];
            } else {
                $_POST['content'] = $oneItem['content'].$_POST['content'];
            }
            unset($_POST['insert_top']);
            $_POST['last_edit'] = time();
            $_POST['last_edit_user'] = $me['user_id'];
            #
            $this->load->model('History_model');
            $clsHistory = new History_model();
            $data = $_POST;
            $data['news_id'] = $_GET['id'];
            $clsHistory->add($data, 'ADD LIVE', $me['user_id']);
            #
            if ($this->News_model->updateOne($_GET['id'], $_POST)) {
                message_flash('Update thông tin thành công', 'success');
                redirect('/news/live?id='.$_GET['id']);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài live trong module Tin tức: '.json_encode($_POST), false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
            unset($_POST);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Tường thuật trực tiếp -  Admin Control Panel';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function live_sort()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $this->User_model->getMe();
        if (!$me) {
            die('need login ...');
        }
        $news_id = $_GET['id'];
        if (!$news_id) {
            die('not found ...');
        }
        $this->load->model('News_model');
        $clsNews = new News_model();
        $oneNews = $clsNews->getOne($news_id);
        if (!$oneNews) {
            die('not found ...');
        }
        $content = $oneNews['content'];
        $this->load->helper('simple_html_dom');
        $html = str_get_html($content);
        $data = array();
        if ($html) {
            foreach ($html->find('div.tkp_live') as $e) {
                $id = $e->id;
                $id = intval(ltrim($id, 'tkp_live_'));
                $data[$id] = $e->outertext;
            }
        }
        if (isset($_GET['type']) && $_GET['type']=='desc') {
            krsort($data);
        } else {
            ksort($data);
        }
        $content = '';
        if ($data) {
            foreach ($data as $one) {
                $content .= $one;
            }
        }
        $POST = array();
        $POST['content'] = $content;
        $POST['last_edit'] = time();
        $POST['last_edit_user'] = $me['user_id'];
        $clsNews->updateOne($news_id, $POST);
        #
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $POST['news_id'] = $news_id;
        $clsHistory->add($POST, 'SORT LIVE', $me['user_id']);
        #
        message_flash('Update thông tin thành công', 'success');
        redirect('/news/live?id='.$news_id);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $this->User_model->getMe();
        $oneNews = $this->News_model->getOne($id);
        if (!$this->News_model->getPermissionEdit($oneNews, $me)) {
            die('Permission');
        }
        if ($oneNews['status']==4 && $me['is_unpush']==0) {
            die('Permission');
        }
        #
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $clsHistory->add(array('is_trash'=>'1', 'news_id'=>$id), 'TRASH', $me['user_id'], false);
        #
        if ($this->News_model->updateOne($id, array('is_trash'=>'1'))) {
            $this->load->model('Box_model');
            $clsBox = new Box_model();
            $clsBox->removeNews($id);
            $this->News_model->deleteArrKey();
            $this->News_model->deleteArrKey('ADMIN');
            $this->News_model->deleteArrKey('CMS');
            $this->News_model->deleteArrKey('BOX');
            if (isset($_GET['res'])) {
                die('1');
            }
            redirect('/news?is_trash=1&user_id='.$me['user_id']);
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa tạm trong module '.$classTable);
        }
    }
    public function restore()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $this->User_model->getMe();
        $oneNews = $this->News_model->getOne($id);
        if (!$this->News_model->getPermissionEdit($oneNews, $me)) {
            die('Permission');
        }
        #
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $clsHistory->add(array('is_trash'=>'0', 'news_id'=>$id), 'RESTORE', $me['user_id'], false);
        #
        if ($this->News_model->updateOne($id, array('is_trash'=>'0'))) {
            $this->News_model->deleteArrKey();
            $this->News_model->deleteArrKey('ADMIN');
            $this->News_model->deleteArrKey('CMS');
            $this->News_model->deleteArrKey('BOX');
            redirect('/news/edit?id='.$id);
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi khôi phục trong module '.$classTable);
        }
    }
    public function delete()
    {
        die('ok');
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        #
        //$allImage = $this->News_model->getAllImage($id);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $this->User_model->getMe();
        $oneNews = $this->News_model->getOne($id);
        if (!$this->News_model->getPermissionEdit($oneNews, $me)) {
            die('Permission');
        }
        if ($oneNews['status']==4 && $me['is_unpush']==0) {
            die('Permission');
        }
        #
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $clsHistory->add(array('news_id'=>$id), 'DELETE', $me['user_id'], false);
        #
        if ($this->News_model->deleteOne($id)) {
            //if($allImage) foreach($allImage as $one) ftpDelete($one['src']);
            //ftpDelete($oneNews['image']);
            $this->News_model->deleteArrKey('ADMIN');
            $this->News_model->deleteArrKey();
            $this->News_model->deleteArrKey('CMS');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }

    public function store()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $this->User_model->getMe();
        $assign_list['me'] = $me;
        $this->load->model('Store_model');
        $clsStore = new Store_model();
        $assign_list['clsStore'] = $clsStore;
        #
        $cons = "user_path like '%|".$me['user_id']."|%'";
        $listItem = $clsStore->getListPage($cons." order by store_id desc", 50, 'CMS');
        $paging = $clsStore->getNavPage($cons, 50, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Kho tin tổng hợp | Module News  Manager";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
    }
    public function deleteStore()
    {
        #
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $classTable = 'Store';
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        if ($this->News_model->deleteOne($id)) {
            $this->News_model->deleteArrKey();
            $this->News_model->deleteArrKey('CMS');
            die('1');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable, false);
            die('0');
        }
    }
}
