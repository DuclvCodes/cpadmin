<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Video extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $this->load->model('Video_model');
        $clsClassTable = new Video_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1 ";
        $listItem = $clsClassTable->getListPage($cons." order by video_id desc", 100, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, 100, 'CMS');
        $assign_list['mod'] = 'video';
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thư viện Video";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function detail()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $id = intval($_GET['id']);
        $code = '<iframe src="https://'.DOMAIN.'/watch/'.$id.'" frameborder="0" style="max-width: 560px;" width="100%" height="315" allowfullscreen="true"></iframe>';
        echo $code;
        echo '<p class="video_code">'.htmlentities($code).'</p>';
        die();
    }
    
    public function delete()
    {
        $video_id = $_GET['id'];
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $oneItem = $clsVideo->getOne($video_id);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        if ($me['user_id'] != $oneItem['user_id']) {
            die('0');
        }
        $delete = ftpDelete($oneItem['file']);
        $delImage = ftpDelete($oneItem['image']);
        $clsVideo->deleteOne($video_id);
        die(1);
    }
    
    public function api_list_box() {
        $this->load->model('News_model');
        //save to cache
        $key_cache = MEMCACHE_NAME."_VIDEO_LIST";
        $res = $this->News_model->getCache($key_cache);
        
        if($res) echo json_encode($res);
        else {
            $clsBox = $this->load->model('Box_model');
            
            $oneBox = $this->Box_model->getBoxBySlug('box_nb_18');
            $data['letter'] = $oneBox['title_show'];
            $allNews = pathToArray($oneBox['news_path']);
            foreach($allNews as $key => $new_id) {
                $oneNew = $this->News_model->getOne($new_id);
                preg_match_all('/<iframe[^>]+src="([^"]+)"/', $oneNew['content'], $match);
                if(isset($match[1])) {
                    $urls = $match[1][0];
                    $data['video'][$key] = $urls;
                    $data['allNews'][$key] = $oneNew;
                    unset($match);
                }
                unset($urls);
                unset($oneNew);
            }
            $this->News_model->setCache($key_cache,$data, 86400);
            echo 'lksdjflkdfjlkd';
            echo json_encode($data);
        }
        
        die();
    }
}
