<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Ajax extends Admin
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('User_model');
            //$clsUser = new User_model();
            //if(!$clsUser->getUserID()) die('Not found.');
    }
    public function index()
    {
        print_r('<pre>');
        print_r('1');
        print_r('</pre>');
        die();
    }
    
    public function getListBox()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        if (!$clsUser->getUserID()) {
            die('Need login ...');
        }
        $news_id = $_GET['news_id'];
        $assign_list['news_id'] = $news_id;
        #
        $this->load->model('News_model');
        $clsNews = new News_model();
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $oneNews = $clsNews->getOne($news_id);
        $cat_id = $oneNews['category_id'];
        $cons = 'is_trash=0';
        if ($cat_id) {
            $root_cat = $clsCategory->getParentID($cat_id);
            $cat_arr = array();
            $cat_arr[0] = 0;
            if ($cat_id) {
                $cat_arr[$cat_id] = $cat_id;
            }
            if ($root_cat) {
                $cat_arr[$root_cat] = $root_cat;
            }
            $cons .= ' and category_id in ('.implode(',', $cat_arr).')';
        } else {
            $cons .= ' and category_id in (0,'.implode(',', $clsCategory->getChild(0)).')';
        }

        $this->load->model('Box_model');
        $clsBox = new Box_model();
        $assign_list['clsBox'] = $clsBox;
        $allBox = $clsBox->getAll($cons.' order by category_id, box_id', true, 'CMS');
        $assign_list['allBox'] = $allBox;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getListRoyalty()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        if (!$clsUser->getUserID()) {
            die('Need login ...');
        }
        $news_id = $_GET['news_id'];
        if (!$news_id) {
            die('0');
        }
        $assign_list['news_id'] = $news_id;
        #
        $this->load->model('News_model');
        $clsNews = new News_model();
        $oneNews = $clsNews->getOne($news_id);
        $assign_list['oneNews'] = $oneNews;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getOneBox()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        if (!$clsUser->getUserID()) {
            die('Need login ...');
        }
        $id = $this->input->post('id');
        if (!$id) {
            die('0');
        }
        #
        $news_id = $this->input->post('news_id');
        $assign_list['news_id'] = $news_id;
        #
        $this->load->model('Box_model');
        $clsBox = new Box_model();
        $assign_list['clsBox'] = $clsBox;
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list['clsNews'] = $clsNews;
        $oneBox = $clsBox->getOne($id);
        $assign_list['oneBox'] = $oneBox;
        $assign_list['allNews'] = pathToArray($oneBox['news_path']);
        #
        if ($news_id) {
            $oneNews = $clsNews->getOne($news_id);
        } else {
            $oneNews = '';
        }
        $assign_list['oneNews'] = $oneNews;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function updateOneBox()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        if (!$clsUser->getUserID()) {
            die('Need login ...');
        }
        $id = $_POST['id'];
        if (!$id) {
            die('0');
        }
        $news_path = $_POST['news_path'];
        if (!$news_path) {
            die('0');
        }
        #
        $this->load->model('Box_model');
        $clsBox = new Box_model();
        $this->load->model('News_model');
        $oneBox = $clsBox->getOne($id);
        $res = $clsBox->updateOne($id, array('news_path'=>$news_path, 'news_path_show'=>$news_path));
        $clsBox->deleteArrKey('GET_NEWS');
        $clsBox->deleteArrKey('BOX');
        $clsBox->deleteArrKey('SYS');
        //delete key param BOX
        $clsBox->updateParam('slug', $oneBox['slug']);
        $clsBox->checkTimer($id);
        if ($res) {
            die('<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>');
        } else {
            die('<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><strong>Error!</strong> Có lỗi xảy ra</div>');
        }
    }

    public function FieldPathInit()
    {
        $this->load->model('News_model');
        $assign_list['listItem'] = explode('|', trim(addslashes($_POST['value']), '|'));
        
        $clsClassTable = new News_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getFieldPath()
    {
        $keyword = trim(addslashes($_POST['keyword']));
        $class = trim(addslashes($_POST['iClass']));
        $classTable = ucfirst(strtolower($class));
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        if ($class=='news') {
            if ($class=='news') {
                $allItem = $clsClassTable->getAll($clsClassTable->getCons()." and title like '%".$keyword."%' order by push_date desc limit 30", true, 'CMS');
            }
            //$allItem = $clsClassTable->getSphinx($keyword, 1, 30);
            //$allItem = $allItem['res'];
        } else {
            $allItem = $clsClassTable->getAll("slug like '%".$keyword."%' limit 30", true, 'CMS');
        }
        $assign_list['allItem'] = $allItem;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getNewsSuggest()
    {
        $keyword = trim(addslashes($_POST['keyword']));
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        $allItem = $clsClassTable->getAll($clsClassTable->getCons()." and title like '%".$keyword."%' order by push_date desc limit 30", true, 'CMS');
        $assign_list['allItem'] = $allItem;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }

    public function server_CPU()
    {
        $clsSystem = new System_model(addslashes($_GET['svr']));
        $cpu = $clsSystem->getCPU();
        print(json_encode(array('value'=>($cpu))));
        die();
    }
    public function server_RAM()
    {
        $clsSystem = new System_model(addslashes($_GET['svr']));
        $free = $clsSystem->getRAM();
        print(json_encode(array('value'=>floatval($free))));
        die();
    }
    public function server_BW()
    {
        $clsSystem = new System_model(addslashes($_GET['svr']));
        $bw = $clsSystem->getBandwidth();
        $value = round($bw/$clsSystem->limit_bw*100, 2);
        print(json_encode(array('value'=>$value, 'bw'=>$bw)));
        die();
    }
    public function server_MEM()
    {
        $statuss = $this->cache->stats();
        //$status = $statuss['localhost:11211'];
        //$MBRead= (real)$status["bytes_read"]/(1024*1024);
        //$data = array('value'=>($status['bytes']/$status['limit_maxbytes']*100));
        //$percCacheHit=((real)$status ["get_hits"]/ (real)$status ["cmd_get"] *100);
        //$percCacheHit=round($percCacheHit, 1);
        
        //$data['totalsize'] = $status['limit_maxbytes']/(1024*1024);
        //$data['usedsize'] = round($status['bytes']/(1024*1024), 2);
        //$data['used'] = round($data['usedsize']/$data['totalsize']*100, 1);
        
        $data['keyspace_hits'] = number_format($statuss['keyspace_hits']);
        $data['keyspace_misses'] = number_format($statuss['keyspace_misses']);
        $data['hit_percent'] = sprintf('%.1f' , $statuss['keyspace_hits'] / ($statuss['keyspace_hits'] + $statuss['keyspace_misses']) * 100);
        $data['used_memory_human'] = $statuss['used_memory_human'];
        $data['used_memory_peak_human'] = $statuss['used_memory_peak_human'];
        $data['mem_used_percent'] = sprintf('%.1f' , $statuss['used_memory_human'] / ($statuss['used_memory_human'] + $statuss['used_memory_peak_human']) * 100);
        print(json_encode($data));
        die();
    }
    public function serverFlush()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me_id = $clsUser->getUserID();
        if($me_id) {
            $res = $this->cache->flush();
            if ($res) {
                print(json_encode(array('red'=>'1')));
            } else {
                print(json_encode(array('red'=>'0')));
            }
        }
        file_put_contents(APPPATH.'logs/flush.txt', date('d/m H:i').": ".$clsUser->getFullName($me_id)."\n", FILE_APPEND);
        die();
    }

    public function getSettingStore()
    {
        $this->load->model('Store_mode');
        $clsStore = new Store_model();
        $assign_list['data'] = $clsStore->getAllDomain();
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function default_setSettingStore()
    {
        $clsStore = new Store_model();
        if ($_POST) {
            $category_path = arrayToPath($_POST['category_path']);
            $res = $clsStore->setDomain($category_path);
            if ($res=='1') {
                die('<div class="alert alert-success"><button class="close" data-dismiss="alert"></button><strong>Success!</strong> Cập nhật thành công</div>');
            } else {
                die('<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><strong>Error!</strong> Có lỗi xảy ra - '.$res.'</div>');
            }
        } else {
            die('Not found ...');
        }
    }
    public function getStoreDetail()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('Not found ...');
        }
        #
        $this->load->model('Store_model');
        $clsStore = new Store_model();
        $store_id = intval($_GET['store_id']);
        $oneStore = $clsStore->getOne($store_id);
        $assign_list['oneStore'] = $oneStore;
        #
        $is_change = false;
        $user_viewed = $oneStore['user_viewed'];
        if (!$user_viewed) {
            $user_viewed = '|'.$user_id.'|';
            $is_change = true;
        } else {
            $arr = pathToArray($user_viewed);
            if (!in_array($user_id, $arr)) {
                $arr[] = $user_id;
                $user_viewed = arrayToPath($arr);
                unset($arr);
                $is_change = true;
            }
        }
        if ($is_change) {
            $res = $clsStore->updateOne($store_id, array('user_viewed'=>$user_viewed));
            if ($res) {
                $clsStore->deleteArrKey('CMS');
                $clsStore->deleteArrKey('user_'.$user_id);
            }
        }
    }

    public function saveStore()
    {
        print_r('<pre>');
        print_r('saveStore');
        print_r('</pre>');
        die();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if ($user_id) {
            $oneUser = $clsUser->getOne($user_id);
            $news_id = intval($_GET['id']);
            $html = @file_get_contents('http://www.phapluatplus.vn/?mod=iframe&act=detailNews&id='.$news_id.'&type=json');
            $html = json_decode($html);
            if ($html) {
                $data = array();
                $data['title'] = $html->title;
                $data['intro'] = $html->intro;
                $data['content'] = $html->content;
                $data['image'] = $html->image;
                $data['category_id'] = CRON_NEWS_CATEGORY;
                $data['slug'] = toSlug($data['title']);
                //$data['push_date'] = date('Y-m-d H:i:s');
                $data['reg_date'] = date('Y-m-d H:i:s');
                $data['last_change_status'] = time();
                $data['user_id'] = $user_id;
                #
                if ($data['image']) {
                    $data['image'] = ftpUrlUpload($data['image'], $oneUser['username'], $data['slug'], time());
                }
                $doc = new DOMDocument();
                $doc->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$data['content']);
                $imageTags = $doc->getElementsByTagName('img');
                $k=1;
                foreach ($imageTags as $key=>$tag) {
                    $src = $tag->getAttribute('src');
                    $src_2 = MEDIA_DOMAIN.ftpUrlUpload($src, $oneUser['username'], $data['slug'].'-'.$k, time());
                    $data['content'] = str_replace($src, $src_2, $data['content']);
                    $k++;
                }
                #
                $clsNews = new News();
                $res = $clsNews->insertOne($data);
                if ($res) {
                    $clsNews->deleteArrKey('CMS');
                    $maxId = $clsNews->getMaxID('CMS');
                    $this->load->model('Store_model');
                    $clsStore = new Store_model();
                    $clsStore->deleteOne(intval($_GET['store_id']));
                    $clsStore->deleteArrKey('CMS');
                    $clsStore->deleteArrKey('user_'.$user_id);
                    redirect('/news/edit?id='.$maxId);
                    die();
                } else {
                    die('ERROR');
                }
            }
        }
        die();
    }
    public function mom_preview()
    {
        $clsMom = new Mom_model();
        $id = $_GET['id'];
        $one = $clsMom->getOne($id);
        $assign_list['one'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function history_detail()
    {
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $id = $_GET['id'];
        $one = $clsHistory->getOne($id);
        $assign_list['one'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function paperhistory_detail()
    {
        $this->load->model('PaperHistory_model');
        $clsHistory = new PaperHistory_model();
        $id = $_GET['id'];
        $one = $clsHistory->getOne($id);
        $assign_list['one'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }

    public function editComment()
    {
        $id = intval($_GET['id']);
        $this->load->model('Comment_model');
        $clsComment = new Comment_model();
        $one = $clsComment->getOne($id);
        $assign_list['one'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function updateComment()
    {
        $id = intval($_GET['id']);
        $this->load->model('Comment_model');
        $clsComment = new Comment_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        if (isset($_POST['push'])) {
            if ($_POST['push']==1) {
                $_POST['push_by'] = $user_id;
                $_POST['push_date'] = date('Y-m-d H:i:s');
            } else {
                $_POST['push_by'] = 0;
                $_POST['push_date'] = '0000-00-00 00:00:00';
            }
            unset($_POST['push']);
            $one = $clsComment->getOne($id);
            $clsComment->updateOne($id, $_POST);
            $clsComment->deleteArrKey('CMS');
            $clsComment->deleteArrKey('NEWS_'.$one['news_id']);
            if ($one['parent_id']) {
                $clsComment->syncChild($one['parent_id']);
            }
        } else {
            $clsComment->updateOne($id, $_POST);
        }
        die('1');
    }
    public function delComment()
    {
        $id = intval($_GET['id']);
        $this->load->model('Comment_model');
        $clsComment = new Comment_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $one = $clsComment->getOne($id);
        $clsComment->deleteOne($id, true, 'CMS');
        $clsComment->deleteArrKey('NEWS_'.$one['news_id']);
        if ($one['parent_id']) {
            $clsComment->syncChild($one['parent_id']);
        }
        die('1');
    }

    public function gltt_question()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if (!$gltt_id) {
            die('not found');
        }
        $oneGltt = $clsGltt->getOne($gltt_id);
        if (!$oneGltt['is_done']) {
            $guest = json_decode($oneGltt['guest']);
            if (is_object($guest)) {
                $guest = get_object_vars($guest);
            }
            $html_select = '';
            if ($guest) {
                foreach ($guest as $key=>$val) {
                    $html_select .= '<option value="'.$key.'">'.$val.'</option>';
                }
            }
            $html_select = '<select name="guest_id" class="guest"><option value="">--- Khách mời ---</option>'.$html_select.'</select>';
            $assign_list['html_select'] = $html_select;
        } else {
            die('not found');
        }
        #
        $clsQuestion = new Question_model();
        $all = $clsQuestion->getQuestion();
        $assign_list['clsQuestion'] = $clsQuestion;
        $assign_list['all'] = $all;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function delQuestion()
    {
        $id = intval($_GET['id']);
        $clsQuestion = new Question_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $one = $clsQuestion->getOne($id);
        $clsQuestion->deleteOne($id, true, 'CMS');
        $clsQuestion->deleteArrKey('GLTT_'.$one['gltt_id']);
        die('1');
    }
    public function setQuestion()
    {
        $id = intval($_GET['id']);
        $data = array();
        if (isset($_GET['done'])) {
            $clsGltt = new Gltt_model();
            $gltt_id = $clsGltt->getMaxID('CMS');
            if ($gltt_id) {
                $oneGltt = $clsGltt->getOne($gltt_id);
                if (!$oneGltt['is_done']) {
                    $this->load->model('News_model');
                    $clsNews = new News_model();
                    $news_id = $oneGltt['news_id'];
                    $oneNews = $clsNews->getOne($news_id);
                    $clsNews->updateOne($news_id, array('content'=>$oneNews['content'].$_POST['answer']));
                    $clsQuestion = new Question();
                    $one = $clsQuestion->getOne($id);
                    $clsQuestion->deleteOne($id, true, 'CMS');
                    $clsQuestion->deleteArrKey('GLTT_'.$one['gltt_id']);
                    die('1');
                } else {
                    die('0');
                }
            } else {
                die('0');
            }
        }
        if (isset($_GET['answer'])) {
            $data['answer_id'] = intval($_GET['answer']);
        } else {
            $data = $_POST;
        }
        if (isset($_GET['send'])) {
            $data['is_send'] = 1;
        }
        $clsQuestion = new Question_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $clsQuestion->updateOne($id, $data);
        $one = $clsQuestion->getOne($id);
        $clsQuestion->deleteArrKey('GLTT_'.$one['gltt_id']);
        die('1');
    }
    
    public function gltt_check_mc()
    {
        $clsQuestion = new Question_model();
        $count = $clsQuestion->checkCountQuestion(addslashes($_GET['ids']));
        die(''.$count);
    }
    
    public function gltt_answer()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if (!$gltt_id) {
            die('not found');
        }
        #
        $clsQuestion = new Question_model();
        $all = $clsQuestion->getQuestion($user_id);
        $assign_list['clsQuestion'] = $clsQuestion;
        $assign_list['all'] = $all;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function gltt_check()
    {
        $clsQuestion = new Question_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $count = $clsQuestion->checkCountQuestion(addslashes($_GET['ids']), $user_id);
        die(''.$count);
    }
    public function gltt_edit()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me_id = $clsUser->getUserID();
        if (!$me_id) {
            die('0');
        }
        #
        $id = intval($_GET['id']);
        $clsQuestion = new Question_model();
        $one = $clsQuestion->getOne($id);
        $assign_list['one'] = $one;
        if (!$one['answer']) {
            $clsGltt = new Gltt_model();
            $gltt_id = $clsGltt->getMaxID('CMS');
            $oneGltt = $clsGltt->getOne($gltt_id);
            $guest = json_decode($oneGltt['guest']);
            if (is_object($guest)) {
                $guest = get_object_vars($guest);
            }
            $assign_list['guest_name'] = $guest[$me_id];
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function gltt_co()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if (!$gltt_id) {
            die('not found');
        }
        #
        $clsQuestion = new Question_model();
        $all = $clsQuestion->getQuestion(-1);
        $assign_list['clsQuestion'] = $clsQuestion;
        $assign_list['all'] = $all;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function gltt_check_co()
    {
        $clsQuestion = new Question_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            die('0');
        }
        $count = $clsQuestion->checkCountQuestion(addslashes($_GET['ids']), -1);
        die(''.$count);
    }
    public function gltt_edit_co()
    {
        $id = intval($_GET['id']);
        $clsQuestion = new Question_model();
        $one = $clsQuestion->getOne($id);
        $assign_list['one'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getDetailVote()
    {
        $id = intval($_GET['id']);
        $assign_list['id'] = $id;
        $this->load->model('Vote_model');
        $clsVote = new Vote_model();
        $one = $clsVote->getOne($id);
        $assign_list['one'] = $one;
        $assign_list['answers'] = json_decode($one['answers']);
        $assign_list['result'] = json_decode($one['result']);
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }

    public function getLastLogin()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $id = intval($_GET['uid']);
        $one = $clsUser->getOne($id);
        $last_login = pathToArray($one['login_path']);
        krsort($last_login);
        $assign_list['last_login'] = $last_login;
        $assign_list['oneUser'] = $one;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getListQc()
    {
        $this->load->model('Code_model');
        $clsCode = new Code_model();
        $assign_list['clsCode'] = $clsCode;
        $all = $clsCode->getAll('1=1 order by code_id desc limit 1000', true, 'CMS');
        $assign_list['all'] = $all;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function getQcPreview()
    {
        $this->load->model('Ads_model');
        $name = addslashes($_GET['name']);
        if (isset($_GET['ads_id'])) {
            $clsAds = new Ads_model();
            $ads_id = intval($_GET['ads_id']);
            $html = $clsAds->getCode($ads_id, $name);
        } elseif (isset($_GET['area_id'])) {
            $clsArea = new Area_model();
            $area_id = intval($_GET['area_id']);
            $html = $clsArea->getCode($area_id, $name);
        } else {
            die('Not found');
        }
        $assign_list['html'] = $html;
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function addVideo()
    {
        $this->load->model('Video_model');
        $clsClassTable = new Video_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        if ($this->input->post() && $this->input->post('title')) {
            if ($_FILES['file']) {
                $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $title = $this->input->post('title');
                $slug = toSlug($title);
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $file = $slug.'-'.date('His').'.'.$extension;
                if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$file)) {
                    chmod($file, 0755);
                    $url = LOCAL_UPLOAD_PATH.$file;
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
                    $shell_command = 'ffmpeg -itsoffset -'.$rpp.' -i '.$url.' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' '.$root.'VIDEO-'.$time.'-1.jpg';
                    $shell_return = shell_exec($shell_command." 2>&1");
                    
                    $thumb_image = 'VIDEO-'.$time.'-1.jpg';
                    
                    #
                    $this->load->model('Image_model');
                    $clsImage = new Image_model();
                    //move video
                    
                    $video = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$file, 'video', $title, time());
                    $image = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$thumb_image, 'video', $title, time());
                    
                    $data['user_id'] = $me['user_id'];
                    $data['reg_date'] = date('Y-m-d H:i:s');
                    $data['file'] = $video;
                    $data['image'] = $image;
                    $data['duration'] = $total_sec;
                    if ($clsClassTable->insertOne($data, true, 'CMS')) {
                        $clsClassTable->deleteArrKey('CMS');
                        $maxId = $clsClassTable->getMaxID('CMS');
                        redirect('/video?mes=insertSuccess');
                    } else {
                        foreach ($_POST as $key => $val) {
                            $assign_list[$key] = $val;
                        }
                        $this->load->model('Mail_model');
                        $clsMail = new Mail_model();
                        $msg = $clsMail->reportError('Lỗi thêm bài trong module '.$classTable, false);
                        $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
                    }
                    $clsVideo->insertOne($data, true, 'CMS');
                }
            }
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function addFile()
    {
        $this->load->model('File_model');
        $clsClassTable = new File_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        if ($this->input->post() && $this->input->post('title')) {
            if ($_FILES['file']) {
                $allowed = array('rar', 'zip', 'txt', 'png', 'jpg', 'doc', 'docx', 'pdf');
                $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                
                if (!in_array($extension, $allowed)) {
                    die('Do not support this extension');
                }
                $title = substr($_FILES['file']['name'], 0, -4);
                $title = toSlug($title).'-'.date('Hi');
                $file = 'uploads/'.date('ymdHis').'-'.$title.'.'.$extension;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
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
                    $data['title'] = $_FILES['file']['name'];
                    $data['file_size'] = toBytes($_FILES['file']['size']);
                    $data['file_type'] = $extension;
                    $clsFile->insertOne($data, true, 'CMS');
                    $maxId = $clsFile->getMaxID('CMS');
                    redirect('/files?mes=insertSuccess');
                    die('<div class="tkp_attach"><h2><a href="'.MEDIA_DOMAIN.$file.'" target="_blank" rel="nofollow">'.$_FILES['file']['name'].'</a></h2><p>'.toBytes($_FILES['upl']['size']).'</p></div><p>&nbsp;</p>');
                }
            }
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function fileDetail()
    {
        $this->load->model('File_model');
        $assign_list['oneItem']=$this->File_model->getOne($file_id);
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    
    public function rssparse()
    {
        $this->load->library('rssparser');							// load library
        $this->rssparser->set_feed_url('https://vnexpress.net/rss/tin-moi-nhat.rss'); 	// get feed
        $this->rssparser->set_cache_life(30); 						// Set cache life time in minutes
        $rss = $this->rssparser->getFeed(6);
        echo $rss;
        die();
    }
    
    public function searchNews()
    {
        $category = $_POST['category'] ? intval($_POST['category']) : 0;
        $keyword = trim(addslashes($_POST['keyword']));
        $this->load->model('News_model');
        $clsNews = new News_model();
        $allItem = $clsNews->getAll($clsNews->getCons()." and title like '%".$keyword."%' order by push_date desc limit 30", true, 'CMS');
        $html = '<table class="table table-condensed table-hover ajax_searchNews"><tbody>';
        foreach ($allItem as $key=>$news_id) {
            $oneItem = $clsNews->getOne($news_id);
            $html .= '<tr>
                        <td><div class="title"><a class="btn_insert" href="'.str_replace(ADMIN_DOMAIN, DOMAIN, $clsNews->getLink($news_id, $oneItem)).'" title="'.htmlspecialchars($oneItem['title'], ENT_QUOTES, 'UTF-8').'" data-id="'.$news_id.'" data-image="'.$clsNews->getImage($news_id, 640, 420).'" >'.$oneItem['title'].'</a></div></td>
                        <td><span class="label label-success">'.time_ago(strtotime($oneItem['push_date'])).'</span></td>
                    </tr>';
        }
        $html .= '</tbody></table>';
        echo $html;
        die();
    }
    public function crawlerNews() {
        $this->load->model('User_model');
        $me = $this->User_model->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if ($this->input->post()) {
            $this->load->model('File_model');
            $this->load->model('Source_model');
            $this->load->model('Image_model');
            $clsImage = new Image_model();
            $clsFile = new File_model();
            $this->load->helper('simple_html_dom');
            $url = $this->input->post('link');
            $news_id = $this->input->post('news_id');
            if(!$news_id) die('error');
            
            //check domain
            $domain = parse_url($url, PHP_URL_HOST);
            $crawler_config = $this->Source_model->getByDomain($domain);
            if(!$crawler_config) die('Website này chưa được cấu hình lấy tin');
            
            $html = file_get_html($url);
            if(!$html) die('error');
            //remove node
            foreach ($html->find('div[type=RelatedOneNews]') as $node) {
                $node->outertext = '';
            }
            $html->save();
            // get title
            $ret['title'] = $html->find($crawler_config['tag_title'], 0)->innertext;
            $ret['sapo'] = $html->find($crawler_config['tag_sapo'], 0)->innertext;
            $content = $html->find($crawler_config['tag_content'], 0);
            foreach ($content->find('table.figure') as $e) {
                $caption = $e->find('tr.figcaption td', 0)->plaintext;
                if (!$caption || $caption==' ') {
                    $e->find('tr.figcaption td', 0)->innertext = '';
                    $caption=$data['title'];
                }
                $e->find('img', 0)->alt=$caption;
            }
            
            //to fetch all images from a webpage
            $images = array();
            $image = $content->find('img');
            //$current_content = $content->innertext;
            foreach ($image as $key=> $link_image) {
                $host_image = parse_url($link_image->src);
                $host_media_server = parse_url(MEDIA_DOMAIN);
                if ($host_image['host'] != $host_media_server['host']) {
                    $image_url = strtok($image[$key]->src, '?');
                    $new_image       = $clsFile->downloadMedia($image_url, 'image', '', $me['username']);
                    //$new_content = str_replace($link_image->src,MEDIA_DOMAIN.$new_image,$current_content);
                    $link_image->src = MEDIA_DOMAIN.$new_image;
                    $clsImage->insertOne(array('title'=>$me['username'].'_'.time(), 'user_id'=>$me['user_id'], 'news_id'=> $news_id, 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$new_image), true, 'USER_'.$me['user_id']);
                    //Delete file from local server
                    @unlink($new_image);
                    sleep(1);
                }
            }
            //$content->save();
            $ret['content'] = $content->innertext;
            $ret['mess'] = 'success';
            
            if($ret['content']) {
                die(json_encode($ret));
            }else die('error');
        }else die('error');
    }
    
    public function filterContent() {
        $content = $_POST['new_content'];
        $title = $_POST['title'];
        $news_id = $_POST['news_id'];
        if(!$content or !$news_id) die('error');
        #
        $this->load->model('User_model');
        $me = $this->User_model->getMe();
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        #
        $this->load->helper('simple_html_dom');
        $this->load->model('File_model');
        $clsFile = new File_model();
        $html = str_get_html($content);
        $image = $html->find('img');
        foreach ($image as $key=> $link_image) {
            $host_image = parse_url($link_image->src);
            $host_media_server = parse_url(MEDIA_DOMAIN);
            if ($host_image['host'] != $host_media_server['host']) {
                $image_url = strtok($image[$key]->src, '?');
                $new_image       = $clsFile->downloadMedia($image_url, 'image', '', $me['username']);
                $link_image->src = MEDIA_DOMAIN.$new_image;
                $clsImage->insertOne(array('title'=>'paste_image'.time(), 'user_id'=>$me['user_id'], 'news_id'=> $news_id, 'reg_date'=>date('Y-m-d H:i:s'), 'file'=>$new_image), true, 'USER_'.$me['user_id']);
            }
        }
        $new_content = $html->save();
        $html->clear();
        if($new_content) echo json_encode($new_content);
        else echo 'error';
        die();
        
    }
}
