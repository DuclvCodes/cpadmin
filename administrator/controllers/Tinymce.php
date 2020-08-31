<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tinymce Controller
*| --------------------------------------------------------------------------
*| For tinymce controller
*|
*/
class Tinymce extends Admin
{
    private $me = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $this->me = $me;
        if (!$clsUser->getUserID()) {
            die('Not found.');
        }
    }
    
    public function index()
    {
        die('ok');
    }
    
    public function image()
    {
        $news_id = $_GET['news_id'];
        $assign_list['me'] = $this->me;
        $assign_list['news_id'] = $news_id;
        $this->load->model('News_model');
        $clsNews = new News_model();
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        if ($this->input->post()) {
            //add title
            if ($this->input->post('name') == 'updateTitle' and $this->input->post('pk')) {
                $clsImage->updateOne($this->input->post('pk'), array('title'=> $this->input->post('value')));
            }
            //delete image
            if ($this->input->post('name') == 'delete' and $this->input->post('id')) {
                $oneItem = $clsImage->getOne($this->input->post('id'));
                if ($me['user_id'] != $oneItem['user_id']) {
                    die('0');
                }
                $delete = ftpDelete($oneItem['file']);
                $clsImage->deleteOne($this->input->post('id'));
                die('1');
            }
            
            //crop image
            if ($this->input->post('action') == 'crop') {
                $filename = basename($this->input->post('image'));
                $file_encode = urldecode($filename);
                $ext = pathinfo($file_encode, PATHINFO_EXTENSION); // To get extension
                $name2 =pathinfo($file_encode, PATHINFO_FILENAME); // File name without extension
                $filename = toSlug($name2).'.'.$ext;
                //download this image
                if (is_url_exist($this->input->post('image'))) {
                    //start download
                    $path_new_image = LOCAL_UPLOAD_PATH.$filename;
                    $fp = fopen($path_new_image, 'w');
                    $ch = curl_init($this->input->post('image'));
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies');
                    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies');
                    $data = curl_exec($ch);
                    
                    if (fwrite($fp, $data)) {
                        fclose($fp);
                        $newImage =  $path_new_image;
                        chmod($path_new_image, 0755);  //changed to add the zero
                    }
                    $image_crop_file_name = time().'_'.$name2;
                    $crop_image = LOCAL_UPLOAD_PATH.$image_crop_file_name.'.'.$ext;
                    
                    $imgConfigCrop = array();
                    $imgConfigCrop['maintain_ratio'] = false;
                    $imgConfigCrop['image_library']= 'gd2';
                    $imgConfigCrop['source_image'] = $newImage;
                    $imgConfigCrop['new_image'] = $crop_image;
                    $imgConfigCrop['quality'] = '100%';
                    $imgConfigCrop['height'] = $this->input->post('h');
                    $imgConfigCrop['width']  = $this->input->post('w');
                    $imgConfigCrop['x_axis'] = $this->input->post('x');
                    $imgConfigCrop['y_axis'] = $this->input->post('y');

                    $this->load->library('image_lib', $imgConfigCrop);

                    $this->image_lib->initialize($imgConfigCrop);

                    if (! $this->image_lib->crop()) {
                        die($this->image_lib->display_errors());
                    }
                    
                    $image = $clsImage->moveToMedia($crop_image, $me['username'], $image_crop_file_name);
                    if ($image) {
                        $clsImage->insertOne(array('title'=>$image_crop_file_name, 'user_id'=>$me['user_id'], 'news_id'=> $this->input->post('news_id'), 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$image), true, 'USER_'.$me['user_id']);
                    }
                    //Delete file from local server
                    @unlink($newImage);
                    @unlink($path_new_image);
                    //let's clear the setting because we will need the library again
                    $this->image_lib->clear();
                    echo MEDIA_DOMAIN.$image;
                    die();
                } else {
                    $newImage = $this->input->post('image');
                    echo $newImage;
                    die();
                }
            }
            //upload file and add watermark
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $titlez = substr($_FILES['file']['name'], 0, -4);
                $title = toSlug($titlez).'-'.date('Hi');
                $image = localUpload('file', $me['username'], $title, time(), MAX_WIDTH_POST, 0);
                
                if (($_POST['wm'] == 1) or ($_POST['wm2'] == 1) or ($_POST['wm3'] == 1) or ($_POST['wm4'] == 1)) {
                    $imgConfig = array();
                    $imgConfig['image_library'] = 'GD2';
                    $imgConfig['source_image']  = $image;
                    $imgConfig['wm_type']       = 'overlay';
                    $imgConfig['wm_opacity'] = 35;
                    
                    if ($_POST['wm'] == 1) {
                        $imgConfig['wm_vrt_alignment'] = 'bottom';
                        $imgConfig['wm_hor_alignment'] = 'right';
                        $imgConfig['wm_overlay_path'] = FCPATH.'html_admin/watermark/mark2.png';
                    } elseif ($_POST['wm2'] == 1) {
                        //$imgConfig['wm_vrt_alignment'] = 'bottom';
                        $imgConfig['wm_overlay_path'] = FCPATH.'html_admin/watermark/mark2.png';
                    } elseif ($_POST['wm3'] == 1) {
                        $imgConfig['wm_vrt_alignment'] = 'bottom';
                        $imgConfig['wm_hor_alignment'] = 'right';
                        $imgConfig['wm_overlay_path'] = FCPATH.'html_admin/watermark/mark3.jpg';
                    } elseif ($_POST['wm4'] == 1) {
                        //$imgConfig['wm_vrt_alignment'] = 'bottom';
                        $imgConfig['wm_overlay_path'] = FCPATH.'html_admin/watermark/mark3.jpg';
                    }
                    

                    $this->load->library('image_lib', $imgConfig);

                    $this->image_lib->initialize($imgConfig);

                    $this->image_lib->watermark();
                    if (!$this->image_lib->watermark()) {
                        die($this->image_lib->display_errors());
                    }
                }
                
                if ($image) {
                    $this->load->model('Image_model');
                    $clsImage = new Image_model();
                    $resImage = $clsImage->moveToMedia($image, $me['username'], $title);
                    $clsImage->insertOne(array('title'=>$titlez, 'user_id'=>$me['user_id'], 'news_id'=> $_GET['news_id'], 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$resImage), true, 'USER_'.$me['user_id']);
                    
                    echo '<figure class="tkpNoEdit"><img src="'.substr(MEDIA_DOMAIN, 0, -1).$resImage.'" alt="'.$titlez.'" width="719" height="480" /></figure>';
                    die();
                }
            }
            echo '';
            die();
        }
        #
        $page = isset($_GET['page'])?$_GET['page']:1;
        $rpp = 20;
        $order = $clsImage->pkey.' desc';
        //get all image
        //if($_GET['all_user']==1) $cons = '1=1';
        //else $cons = 'user_id='.$me['user_id'];
        $cons_all = 'user_id='.$me['user_id'];
        //if($_GET['news_id']) $cons .=' and news_id ='.$_GET['news_id'];
        if ($_GET['year']) {
            $cons_all .= ' and year(reg_date)='.intval($_GET['year']);
        }
        if ($_GET['month']) {
            $cons_all .= ' and month(reg_date)='.intval($_GET['month']);
        }
        if ($_GET['day']) {
            $cons_all .= ' and day(reg_date)='.intval($_GET['day']);
        }
        if ($_GET['q']) {
            $cons_all .= ' and title like "%'.toSlug(addslashes($_GET['q'])).'%"';
        }

        //$all = $clsImage->getAll($cons.' order by image_id desc limit '.($page-1)*$rpp.', '.$rpp, true, 'USER_'.$me['user_id']);
        $listItemAll = $clsImage->getListPage($cons_all." order by ".$order, RECORD_PER_PAGE, $keyopen);
        $pagingAll = $clsImage->getNavPage($cons_all, RECORD_PER_PAGE, $keyopen);
        
        $res = array();
        if ($listItemAll) {
            foreach ($listItemAll as $id) {
                $one = $clsImage->getOne($id);
                $res[] = array('id'=>$one['image_id'], 'file'=>$one['file'], 'thumb'=>$clsImage->getImage($id, 150, 105, 'file'), 'name'=>$one['title']);
            }
        }
        
        
        //get list current image
        $cons_current = '1=1';
        if ($_GET['news_id']) {
            $cons_current .=' and news_id ='.$_GET['news_id'];
        }

        $allCurrent = $clsImage->getAll($cons_current.' order by image_id ', true, 'USER_CURRENT_'.$me['user_id']);
        if ($allCurrent) {
            foreach ($allCurrent as $eid) {
                $one = $clsImage->getOne($eid);
                $resC[] = array('id'=>$one['image_id'], 'file'=>$one['file'], 'thumb'=>$clsImage->getImage($eid, 150, 105, 'file'), 'name'=>$one['title']);
            }
        }
        
        $assign_list['listImage'] = $res;
        $assign_list["pagingAll"] = $pagingAll;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list['listImageCurrent'] = $resC;
        
        if ($_GET['tab']) {
            $assign_list['tab'] = $_GET['tab'];
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function editimage()
    {
        if ($_GET['tab']) {
            $assign_list['tab'] = $_GET['tab'];
        }
        if ($_GET['news_id']) {
            $assign_list['news_id'] = $_GET['news_id'];
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function media()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        $order = $clsVideo->pkey.' desc';
        //list video
        $page = isset($_GET['page'])?$_GET['page']:1;
        $rpp = 20;
        //if($_GET['all_user']==1) $cons = '1=1';
        //else $cons = 'user_id='.$me['user_id'];
        $cons_all = '1=1';
        if ($_GET['year']) {
            $cons_all .= ' and year(reg_date)='.intval($_GET['year']);
        }
        if ($_GET['month']) {
            $cons_all .= ' and month(reg_date)='.intval($_GET['month']);
        }
        if ($_GET['day']) {
            $cons_all .= ' and day(reg_date)='.intval($_GET['day']);
        }
        if ($_GET['q']) {
            $cons_all .= ' and file like "%'.toSlug(addslashes($_GET['q'])).'%"';
        }

        $listItemAll = $clsVideo->getListPage($cons_all." order by ".$order, RECORD_PER_PAGE, $keyopen);
        $pagingAll = $clsVideo->getNavPage($cons_all, RECORD_PER_PAGE, $keyopen);
        
        $res = array();
        if ($listItemAll) {
            foreach ($listItemAll as $id) {
                $one = $clsVideo->getOne($id);
                $title = $one['title']?$one['title']:rtrim(basename($one['file']), '.mp4');
                $res[] = array('id'=>$one['video_id'],'user_id'=>$one['user_id'], 'file'=>$one['file'], 'reg_date'=>$one['reg_date'] ,'thumb'=>$clsVideo->getImage($id, 150, 105, 'image'), 'name'=>$title, 'duration'=>date('i:s', $one['duration']), 'iframe'=>'https://'.DOMAIN.'/watch/'.$one['video_id']);
            }
        }
    
        //get list current video
        $cons2 = '1=1';
        if ($_GET['news_id']) {
            $cons2 .=' and news_id ='.$_GET['news_id'];
        }
        $allCurrent = $clsVideo->getAll($cons2.' order by video_id ', true, 'USER_CURRENT_'.$me['user_id']);
        if ($allCurrent) {
            foreach ($allCurrent as $eid) {
                $one = $clsVideo->getOne($eid);
                $resC[] = array('id'=>$one['video_id'], 'file'=>$one['file'], 'reg_date'=>$one['reg_date'] ,'thumb'=>$clsVideo->getImage($id, 150, 105, 'image'), 'name'=>$title, 'duration'=>date('i:s', $one['duration']), 'iframe'=>'https://'.DOMAIN.'/watch/'.$one['video_id']);
            }
        }
        $assign_list['listVideo'] = $res;
        $assign_list["pagingAll"] = $pagingAll;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list['listVideoCurrent'] = $resC;
        
        if ($this->input->post()) {
            //add title
            if ($this->input->post('name') == 'updateTitle' and $this->input->post('pk')) {
                $clsImage->updateOne($this->input->post('pk'), array('title'=> $this->input->post('value')));
            }
            //set cover
            if ($this->input->post('action') == 'setcover' and $this->input->post('id')) {
                $clsVideo->updateOne($this->input->post('id'), array('image'=> $this->input->post('image')));
                die($clsVideo->getEmbed($this->input->post('id')));
            }
            //delete video
            if ($this->input->post('action') == 'delete' and $this->input->post('id')) {
                $oneItem = $clsVideo->getOne($this->input->post('id'));
                if ($me['user_id'] != 1 and $me['user_id'] != $oneItem['user_id']) {
                    die('0');
                }
                $clsVideo->deleteOne($oneItem['video_id']);
                $allImage = pathToArray($oneItem['all_image']);
                foreach($allImage as $thumb_img)  {
                    ftpDelete($thumb_img);
                }
                $delete = ftpDelete($oneItem['file']);
                if($oneItem['file_360']) ftpDelete($oneItem['file_240']);
                if($oneItem['file_360']) ftpDelete($oneItem['file_360']);
                if($oneItem['file_360']) ftpDelete($oneItem['file_480']);
                if($oneItem['file_360']) ftpDelete($oneItem['file_720']);
                $delImage = ftpDelete($oneItem['image']);
                die('ok');
            }
            //upload file and add watermark
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $allowed = array('mp4');
                $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $allowed)) {
                    die('Do not support this extension');
                }
                $title = substr($_FILES['file']['name'], 0, -4);
                $title = toSlug($title).'-'.date('Hi');
                $video = date('ymdHis').'-'.$title.'.'.$extension;
                if (move_uploaded_file($_FILES['file']['tmp_name'], LOCAL_UPLOAD_PATH.$video)) {
                    chmod($video, 0755);
                    $url = LOCAL_UPLOAD_PATH.$video;
                    $this->load->model('Video_model');
                    
                    //add water mark
                    if ($this->input->post('wm')) {
                        $new_video = LOCAL_UPLOAD_PATH.time().'_'.$title.'.mp4';
                        $shell_command = 'ffmpeg -i '.$url.' -i '.FCPATH.'html_admin/watermark/mark3.png -filter_complex "overlay=10:10" '.$new_video;
                        $shell_return = shell_exec($shell_command." 2>&1");
                        unlink($url);
                    } else {
                        $new_video = $url;
                    }
                    
                    $clsVideo = new Video_model();
                    
                    $video_attributes = $clsVideo->getAttr($new_video);
                    $width = $video_attributes['width'];
                    $height = $video_attributes['height'];
                    $hours = $video_attributes['hours'];
                    $mins = $video_attributes['mins'];
                    $secs = $video_attributes['secs'];
                    $total_sec = ($hours*60+$mins)*60+$secs;
                    $rpp = intval($total_sec/11);
                    $time = time();
                    $root = LOCAL_UPLOAD_PATH;
                    $data = array();
                    $data['width'] = $width;
                    $data['height'] = $height;
                    if ($width>MAX_WIDTH_POST) {
                        $height = intval($height/($width/MAX_WIDTH_POST));
                        $width = MAX_WIDTH_POST;
                    }
                    #
                    $all_image = array();
                    $new_list_image = array();
                    for ($i=1; $i<5; $i++) {
                        $shell_command = 'ffmpeg -itsoffset -'.$i*$rpp.' -i '.$new_video.' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' '.$root.$title.'-'.$time.'-'.$i.'.jpg';
                        $shell_return = shell_exec($shell_command." 2>&1");
                        $all_image[$i] = $root.$title.'-'.$time.'-'.$i.'.jpg';
                        //sleep(3);
                        $new_list_image[$i] = $clsImage->moveToMedia($all_image[$i], 'video_cover', $title.'-'.$time.'-'.$i, time());
                    }
                    
                    #
                    $this->load->model('Image_model');
                    $clsImage = new Image_model();
                    $video = $clsImage->moveToMedia($new_video, 'video', $title, time());
                    $data['user_id'] = $me['user_id'];
                    $data['all_image'] = implode('|', $new_list_image);
                    $data['reg_date'] = date('Y-m-d H:i:s');
                    $data['file'] = $video;
                    $data['duration'] = $total_sec;
                    $clsVideo->insertOne($data, true, 'CMS');
                    $maxId = $clsVideo->getMaxID('CMS');
                    echo '<div class="row-fluid">';
                    for ($i=1;$i<5;$i++) {
                        echo '<div class="span3">';
                        echo '<a href="#" data-image="'.$new_list_image[$i].'" data-id="'.$maxId.'" class="btn_setcover">';
                        echo '<img src="'.MEDIA_DOMAIN.$new_list_image[$i].'" />';
                        echo '</a></div>';
                    }
                    echo '</div>';
                    die();
                }
            }
        }
        
        if ($_GET['tab']) {
            $assign_list['tab'] = $_GET['tab'];
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function quote()
    {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function info()
    {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function chart()
    {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function related()
    {
        $news_id = $_GET['news_id'];
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function vote()
    {
        if ($_GET['k']) {
            $search = " and title like '%".$_GET['k']."%'" ;
        } else {
            $search = '';
        }
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $this->load->model('Vote_model');
        $clsVote = new Vote_model();
        $assign_list["clsVoter"] = $clsVote;
        $pkeyTable = $clsVote->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1 ";
        $listItem = $clsVote->getListPage($cons.$search." order by vote_id desc", RECORD_PER_PAGE, 'CMS');
        $paging = $clsVote->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function attach()
    {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function link()
    {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getNews() {
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
}
