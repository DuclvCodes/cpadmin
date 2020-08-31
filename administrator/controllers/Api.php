<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Api extends Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $clsUser = new User_model();
        if (!$clsUser->getUserID()) {
            die('Not found.');
        }
    }
    public function index()
    {
        print_r('<pre>');
        print_r('cms');
        print_r('</pre>');
        die();
    }
    public function getJSNews()
    {
        $slug = toSlug($_GET['keyword']);
        $clsNews = new News_model();
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $allNews = $clsNews->getAll($clsNews->getCons()." and slug like '%".$slug."%' order by news_id desc limit 8", true, 'CMS');
        $res = array();
        if ($allNews) {
            foreach ($allNews as $id) {
                $one = $clsNews->getOne($id);
                $res[] = array('news_id'=>$id, 'title'=>$one['title'], 'push_date'=>db2datepicker($one['push_date']), 'category'=>$clsCategory->getTitle($one['category_id']));
            }
        }
        die(json_encode($res));
    }
    public function validateUsername()
    {
        $username = strtolower($_POST['username']);
        if (!$username || strlen($username)<5) {
            die('0');
        }
        $this->load->model('User_model');
        $clsUser = new User_model();
        if ($clsUser->is_exits_user($username)) {
            die('0');
        } else {
            die('1');
        }
    }
    public function loadRelationNews()
    {
        $q = trim($_GET['q']);
        $limit = $_GET['limit'];
        $offset = $_GET['offset'];
        $this->load->model('News_model');
        $clsNews = new News_model();
        $all = $clsNews->getAll($clsNews->getCons()." and title like '%".$q."%' order by push_date desc limit ".$offset.",".$limit);
        //$all = $clsNews->getSphinx($q, (($offset/$limit)+1), $limit);
        //$all = $all['res'];
        if ($all) {
            foreach ($all as $one) {
                $one = $clsNews->getOne($one);
                echo '<li><a href="#" onclick="javascript:setNews('.$one['news_id'].'); return false;">'.$one['title'].'</a><li/>';
            }
        }
        die();
    }
    public function pluginSearch()
    {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $oneNews = $clsNews->getOne(intval($_GET['id']));
        $link = $clsNews->getLink($oneNews['news_id']);
        $link = str_replace(ADMIN_DOMAIN, DOMAIN, $link);
        echo '<div class="_related_1404022217_item" >                
            <a href="'.$link.'" class="_related_1404022217_photo" title="'.$oneNews['title'].'"><img src="'.$clsNews->getImage($oneNews['news_id'], 174, 104).'" width="174" height="104" /></a>
            <a href="'.$link.'" class="_related_1404022217_title" title="'.$oneNews['title'].'">'.$oneNews['title'].'</a>
        </div>';
        die();
    }
    public function addLog()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $this->load->model('Log_model');
        $clsLog = new Log_model();
        $data = array();
        $data['news_id'] = intval($_POST['news_id']);
        if (!$data['news_id']) {
            die('Lỗi thiếu ID');
        }
        $data['user_id'] = $clsUser->getUserID();
        if (!$data['user_id']) {
            die('Lỗi chưa đăng nhập');
        }
        $data['title'] = $_POST['title'];
        if (!$data['title']) {
            die('Lỗi chưa có nội dung');
        }
        $data['reg_date'] = date('Y-m-d H:i:s');
        $res = $clsLog->insertOne($data, true, 'news_'.$data['news_id']);
        if ($res) {
            die('1');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $clsMail->reportError('Lỗi add log', false);
            die('Oops!!! Có lỗi xảy ra. Hệ thống sẽ tự động gửi lỗi này đến nhóm IT để sớm khắc phục.');
        }
    }
    public function addPaperLog()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $this->load->model('PaperLog_model');
        $clsLog = new PaperLog_model();
        $data = array();
        $data['news_id'] = intval($_POST['news_id']);
        if (!$data['news_id']) {
            die('Lỗi thiếu ID');
        }
        $data['user_id'] = $clsUser->getUserID();
        if (!$data['user_id']) {
            die('Lỗi chưa đăng nhập');
        }
        $data['title'] = $_POST['title'];
        if (!$data['title']) {
            die('Lỗi chưa có nội dung');
        }
        $data['reg_date'] = date('Y-m-d H:i:s');
        $res = $clsLog->insertOne($data, true, 'news_'.$data['news_id']);
        if ($res) {
            die('1');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $clsMail->reportError('Lỗi add log', false);
            die('Oops!!! Có lỗi xảy ra. Hệ thống sẽ tự động gửi lỗi này đến nhóm IT để sớm khắc phục.');
        }
    }

    public function markRead()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $this->load->model('Room_model');
        $clsRoom = new Room_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('0');
        }

        $room_id = $clsRoom->getID(addslashes($_GET['room']));
        $chat_read = json_decode($me['chat_read']);
        if (is_object($chat_read)) {
            $chat_read = get_object_vars($chat_read);
        }
        unset($chat_read[$room_id]);
        $clsUser->updateOne($me['user_id'], array('chat_read'=>json_encode($chat_read)));
        die('1');
    }
    public function getChat()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $clsRoom = new Room_model();
        $clsChat = new Chat_model();
        $me_id = $clsUser->getUserID();
        if (!$me_id) {
            die('0');
        }
        $room_id = $clsRoom->getID(addslashes($_GET['room']));
        if (!$room_id) {
            die('0');
        }

        $cons = 'room_id="'.$room_id.'"';
        if (isset($_GET['mid']) && $_GET['mid']>0) {
            $cons .= ' and chat_id<'.intval($_GET['mid']);
        }

        $all = $clsChat->getAll($cons.' order by chat_id desc limit 10', true, 'CMS');
        $res = array();
        if ($all) {
            foreach ($all as $chat_id) {
                $res[] = $clsChat->getOne($chat_id);
            }
        }
        die(json_encode($res));
    }

    public function getImages()
    {
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        $page = isset($_GET['page'])?$_GET['page']:1;
        $rpp = 20;
        if ($_GET['all_user']==1) {
            $cons = '1=1';
        } else {
            $cons = 'user_id='.$me['user_id'];
        }
        if ($_GET['year']) {
            $cons .= ' and year(reg_date)='.intval($_GET['year']);
        }
        if ($_GET['month']) {
            $cons .= ' and month(reg_date)='.intval($_GET['month']);
        }
        if ($_GET['day']) {
            $cons .= ' and day(reg_date)='.intval($_GET['day']);
        }
        if ($_GET['keyword']) {
            $cons .= ' and file like "%'.toSlug(addslashes($_GET['keyword'])).'%"';
        }

        $all = $clsImage->getAll($cons.' order by image_id desc limit '.($page-1)*$rpp.', '.$rpp, true, 'USER_'.$me['user_id']);
        $res = array();
        if ($all) {
            foreach ($all as $id) {
                $one = $clsImage->getOne($id);
                $res[] = array('id'=>$one['image_id'], 'file'=>$clsImage->getImage($id, 150, 105, 'file'), 'name'=>$one['title']);
            }
        }
        die(json_encode($res));
    }
    public function upload()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                die('Do not support this extension');
            }
            $titlez = substr($_FILES['upl']['name'], 0, -4);
            $title = toSlug($titlez).'-'.date('Hi');
            $image = ftpUpload('upl', $me['username'], $title, time(), MAX_WIDTH_POST, 0);
            if ($image) {
                $this->load->model('Image_model');
                $clsImage = new Image_model();
                $clsImage->insertOne(array('title'=>$titlez, 'user_id'=>$me['user_id'], 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$image), true, 'USER_'.$me['user_id']);
                die(MEDIA_DOMAIN.$image.'||'.$titlez);
            }
        }
        die('Not found');
    }
    public function uploadfull()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                die('Do not support this extension');
            }
            $titlez = substr($_FILES['upl']['name'], 0, -4);
            $title = toSlug($titlez).'-'.date('Hi');
            $image = ftpUpload('upl', $me['username'], $title, time(), 5000, 0);
            if ($image) {
                $this->load->model('Image_model');
                $clsImage = new Image_model();
                $clsImage->insertOne(array('title'=>$titlez, 'user_id'=>$me['user_id'], 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$image), true, 'USER_'.$me['user_id']);
                die(MEDIA_DOMAIN.$image.'||'.$titlez);
            }
        }
        die('Not found');
    }
    public function getVideo()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        $page = isset($_GET['page'])?$_GET['page']:1;
        $rpp = 20;
        if ($_GET['all_user']==1) {
            $cons = '1=1';
        } else {
            $cons = 'user_id='.$me['user_id'];
        }
        if ($_GET['year']) {
            $cons .= ' and year(reg_date)='.intval($_GET['year']);
        }
        if ($_GET['month']) {
            $cons .= ' and month(reg_date)='.intval($_GET['month']);
        }
        if ($_GET['day']) {
            $cons .= ' and day(reg_date)='.intval($_GET['day']);
        }
        if ($_GET['keyword']) {
            $cons .= ' and file like "%'.toSlug(addslashes($_GET['keyword'])).'%"';
        }

        $all = $clsVideo->getAll($cons.' order by video_id desc limit '.($page-1)*$rpp.', '.$rpp, true, 'USER_'.$me['user_id']);
        $res = array();
        if ($all) {
            foreach ($all as $id) {
                $one = $clsVideo->getOne($id);
                $title = $one['title']?$one['title']:rtrim(basename($one['file']), '.mp4');
                $res[] = array('id'=>$one['video_id'], 'file'=>$clsVideo->getImage($id, 150, 105, 'image'), 'name'=>$title, 'duration'=>date('i:s', $one['duration']), 'iframe'=>'http://'.DOMAIN.'/watch/'.$one['video_id']);
            }
        }
        die(json_encode($res));
    }
    public function uploadVideo()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('mp4');
            $extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed)) {
                die('Do not support this extension');
            }
            $title = substr($_FILES['upl']['name'], 0, -4);
            $title = toSlug($title).'-'.date('Hi');
            $video = date('ymdHis').'-'.$title.'.'.$extension;
            if (move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$video)) {
                chmod($video, 0755);
                $url = LOCAL_UPLOAD_PATH.$video;
                $this->load->model('Video_model');
                $clsVideo = new Video_model();
                $video_attributes = $clsVideo->getAttr($url);
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
                for ($i=1; $i<4; $i++) {
                    $shell_command = 'ffmpeg -itsoffset -'.$i*$rpp.' -i '.$url.' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' '.$root.'VIDEO-'.$time.'-'.$i.'.jpg';
                    $shell_return = shell_exec($shell_command." 2>&1");
                    $all_image[] = '/uploads/VIDEO-'.$time.'-'.$i.'.jpg';
                }
                #
                $this->load->model('Image_model');
                $clsImage = new Image_model();

                $video = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$video, 'video', $title, time());
                //$video = $clsImage->moveToMedia2($video, 'video', $title, time());
                $data['user_id'] = $me['user_id'];
                $data['all_image'] = implode('|', $all_image);
                $data['reg_date'] = date('Y-m-d H:i:s');
                $data['file'] = $video;
                $data['duration'] = $total_sec;
                $clsVideo->insertOne($data, true, 'CMS');
                $maxId = $clsVideo->getMaxID('CMS');
                die(json_encode(array('id'=>$maxId, 'list'=>$all_image)));
            }
        }
        die('Not found');
    }


    public function resizeVideo()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        $filepost = $_POST['filename'];
        if (!$filepost) {
            die(json_encode(array('status'=>'error','msg'=>'Lỗi tên file không có')));
        }
        $filename = $filepost.'.mp4';
        $file_location = LOCAL_UPLOAD_PATH;
        //check file exits
        if (!file_exists($file_location.$filename)) {
            die(json_encode(array('status'=>'error','msg'=>'Không tìm thấy file')));
        }
        //if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
        $allowed = array('mp4');
        $extension = strtolower(pathinfo($file_location.$filename, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed)) {
            die(json_encode(array('status'=>'error','msg'=>'File không đúng định dạng mp4')));
        }
        //$title = substr($_FILES['upl']['name'],0,-4);
        $title = $filepost;
        //$title = toSlug($title).'-'.date('Hi');
        //$video = 'uploads/'.date('ymdHis').'-'.$title.'.'.$extension;
        $video = 'uploads_tmp/'.$filename;
        //if(move_uploaded_file($_FILES['upl']['tmp_name'], $video)) {
        //chmod($video, 0755);
        $url = $video;
        $clsVideo = new Video();
        $video_attributes = $clsVideo->getAttr($url);
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
        for ($i=1; $i<4; $i++) {
            $shell_command = 'ffmpeg -itsoffset -'.$i*$rpp.' -i '.$url.' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' '.$root.'VIDEO-'.$time.'-'.$i.'.jpg';
            $shell_return = shell_exec($shell_command." 2>&1");
            $all_image[] = '/uploads/VIDEO-'.$time.'-'.$i.'.jpg';
        }
        #
        $clsImage = new Image();

        $video = $clsImage->moveToMedia($video, 'video', $title, time());
        //$video = $clsImage->moveToMedia2($video, 'video', $title, time());
        $data['user_id'] = $me['user_id'];
        $data['all_image'] = implode('|', $all_image);
        $data['reg_date'] = date('Y-m-d H:i:s');
        $data['file'] = $video;
        $data['duration'] = $total_sec;
        $clsVideo->insertOne($data, true, 'CMS');
        $maxId = $clsVideo->getMaxID('CMS');
        die(json_encode(array('id'=>$maxId, 'list'=>$all_image)));

        //}
        //}
        die(json_encode(array('status'=>'error','msg'=>'Lỗi gì đó không biết được')));
    }

    public function setVideo()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        $id = intval($_GET['id']);
        if (!$id) {
            die('Error');
        }
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $one = $clsVideo->getOne($id);
        $image = addslashes(rawurldecode($_GET['image']));
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        $image = $clsImage->moveToMedia(ltrim($image, '/'), 'video', $id, strtotime($one['reg_date']));
        $clsVideo->updateOne($id, array('image'=>$image, 'all_image'=>''));
        $allImage = explode('|', $one['all_image']);
        if ($allImage) {
            foreach ($allImage as $i) {
                unlink(ltrim($i, '/'));
            }
        }
        die('<p style="text-align: center;"><iframe src="http://'.DOMAIN.'/watch/'.$id.'" frameborder="0" width="100%" style="max-width:560px;" height="315" allowfullscreen="true"></iframe></p><p>&nbsp;</p>');
    }
    public function uploadAudio()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('mp3', 'wav');
            $extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed)) {
                die('Do not support this extension');
            }
            $title = substr($_FILES['upl']['name'], 0, -4);
            $titlez = $title;
            $title = toSlug($title).'-'.date('Hi');
            $audio = 'uploads/'.date('ymdHis').'-'.$title.'.'.$extension;
            if (move_uploaded_file($_FILES['upl']['tmp_name'], $audio)) {
                $url = $audio;
                $clsAudio = new Audio();
                $clsImage = new Image();
                $audio = $clsImage->moveToMedia($audio, 'audio', $title, time());
                $data = array();
                $data['user_id'] = $me['user_id'];
                $data['reg_date'] = date('Y-m-d H:i:s');
                $data['file'] = $audio;
                $data['title'] = $titlez;
                $clsAudio->insertOne($data, true, 'CMS');
                $maxId = $clsAudio->getMaxID('CMS');
                die('<p style="text-align: center;"><iframe src="http://'.DOMAIN.'/audio/'.$maxId.'" frameborder="0" width="100%" style="max-width:560px;" height="117" allowfullscreen="true"></iframe></p><p>&nbsp;</p>');
            }
        }
        die('Not found');
    }
    public function uploadFile()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('rar', 'zip', 'txt', 'png', 'jpg', 'doc', 'docx', 'pdf');
            $extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed)) {
                die('Do not support this extension');
            }
            $title = substr($_FILES['upl']['name'], 0, -4);
            $title = toSlug($title).'-'.date('Hi');
            $file = 'uploads/'.date('ymdHis').'-'.$title.'.'.$extension;
            if (move_uploaded_file($_FILES['upl']['tmp_name'], $file)) {
                $url = $file;
                $this->load->model('File_model');
                $clsFile = new File_model();
                $this->load->model('Image_model');
                $clsImage = new Image_model();
                $file = $clsImage->moveToMedia($file, 'attach', $title, time());
                $data = array();
                $data['user_id'] = $me['user_id'];
                $data['reg_date'] = date('Y-m-d H:i:s');
                $data['file'] = $file;
                $data['title'] = $_FILES['upl']['name'];
                $clsFile->insertOne($data, true, 'CMS');
                $maxId = $clsFile->getMaxID('CMS');
                die('<div class="tkp_attach"><h2><a href="'.MEDIA_DOMAIN.$file.'" target="_blank" rel="nofollow">'.$_FILES['upl']['name'].'</a></h2><p>'.toBytes($_FILES['upl']['size']).'</p></div><p>&nbsp;</p>');
            }
        }
        die('Not found');
    }
    
    
    public function getVote()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('0');
        }
        $this->load->model('Vote_model');
        $clsVote = new Vote_model();
        $id = isset($_GET['id'])?intval($_GET['id']):0;
        if (!$id) {
            die('0');
        }
        $one = $clsVote->getOne($id);
        die(json_encode($one));
    }
    public function vote()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        $this->load->model('Vote_model');
        $clsVote = new Vote_model();
        if ($this->input->post()) {
            $class = 'tkp_area_vote';
            if ($_POST['vote_id']) {
                $vote_id = $_POST['vote_id'];
            } else {
                $vote_id = 0;
            }
            unset($_POST['vote_id']);
            $_POST['answers'] = json_encode($_POST['answers']);
            if ($this->input->post('youtube')) {
                $_POST['youtube'] = json_encode($_POST['youtube']);
                $class = 'tkp_area_votemusic';
            }
            $_POST['edit_by'] = $me['user_id'];
            $_POST['last_edit'] = time();
            if ($vote_id == 0) {
                $_POST['reg_date'] = date('Y-m-d H:i:s');
                $res = $clsVote->insertOne($_POST, true, 'CMS');
                if ($res) {
                    $vote_id = $clsVote->getMaxID('CMS');
                }
            } else {
                $res = $clsVote->updateOne($vote_id, $_POST);
            }

            if ($vote_id != 0) {
                echo '<div class="'.$class.'"><span class="vote_id" style="display:none">'.$vote_id.'</span><strong>Thăm dò ý kiến:</strong> '.$_POST['title'].'</div><p></p>';
            }
        }
        die();
    }
    public function uploadVote()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        #
        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $allowed = array('mp3', 'wav');
            $extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed)) {
                die('Do not support this extension');
            }
            $title = substr($_FILES['upl']['name'], 0, -4);
            $title = toSlug($title).'-'.date('Hi');
            $path = 'uploads/'.date('ymdHis').'-'.$title.'.'.$extension;
            if (move_uploaded_file($_FILES['upl']['tmp_name'], $path)) {
                $clsImage = new Image_model();
                $audio = $clsImage->moveToMedia($path, 'vote', $title, time());
                die(DOMAIN.$audio);
            }
        }
        die('Not found');
    }
    
    public function clearCategory() {
        $this->load->model('Category_model');
        $cons = "is_trash = 0";
        $categories = $this->Category_model->getAll($cons);
        foreach($categories as $key => $category) {
            $this->Category_model->deleteArrKey('CATEGORY'.$category['category_id']);
        }
        die('ok');
    }
    
    
}
