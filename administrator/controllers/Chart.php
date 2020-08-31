<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Chart extends Admin
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
        $start = isset($_POST['txt_start'])?$_POST['txt_start']:date('Y-m-d', time()-60*60*24*30);
        $end = isset($_POST['txt_end'])?$_POST['txt_end']:date('Y-m-d');
        $field = isset($_POST['field'])?$_POST['field']:'visit';
        #
        require_once(APPPATH.'libraries/Google/autoload.php');
        //require_once(APPPATH.'libraries/Google/Service/Analytics.php');
        $service_account_email = GO_EMAIL;
        $key_file_location = APPPATH.'libraries/Google/client_secrets.p12';
        $client = new Google_Client();
        $client->setApplicationName(GA_NAME);
        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials($service_account_email, array(Google_Service_Analytics::ANALYTICS_READONLY), $key);
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $analytics = new Google_Service_Analytics($client);
        $ids='ga:'.GA_PROFILE_ID;
        $ga_filed = array('views'=>'pageviews', 'visit'=>'visits', 'exit_rate'=>'exitRate', 'time_on_page'=>'avgTimeOnPage');
        $results = $analytics->data_ga->get($ids, $start, $end, 'ga:'.$ga_filed[$field], array('dimensions' => 'ga:year, ga:month, ga:day'));
        $results = $results->rows;
        $res = array();
        if ($results) {
            foreach ($results as $one) {
                $year = $one[0];
                $month = $one[1];
                $day = $one[2];
                $res[$year][$month][$day] = $one[3];
            }
        }
        $assign_list['results'] = $res;
        #
        $assign_list['start'] = $start;
        $assign_list['end'] = $end;
        $assign_list['field'] = $field;
        $assign_list['field_unit'] = ($field=='exit_rate')?'%':(($field=='time_on_page')?'giây':$field);
        $assign_list['arr_field'] = array('views'=>'Lượt views', 'visit'=>'Visitor', 'exit_rate'=>'Tỷ lệ thoát', 'time_on_page'=>'Thời gian trên trang');
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thống kê | Module Manager";
        $this->render('backend/standart/administrator/chart/chart', $assign_list);
    }
    public function category()
    {
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $category_id = (isset($_POST['category_id']) && $_POST['category_id']>0)?$_POST['category_id']:0;
        if (!$category_id) {
            $all = $clsCategory->getChild(0, false);
            if ($all) {
                $category_id = $all[0];
            }
        }
        $assign_list['category_id'] = $category_id;
        #
        $start = isset($_POST['txt_start'])?$_POST['txt_start']:date('Y-m-d', time()-60*60*24*30);
        $end = isset($_POST['txt_end'])?$_POST['txt_end']:date('Y-m-d');
        $field = isset($_POST['field'])?$_POST['field']:'visit';
        #
        require_once(APPPATH.'libraries/Google/autoload.php');
        $service_account_email = GO_EMAIL;
        $key_file_location = APPPATH.'libraries/Google/client_secrets.p12';
        $client = new Google_Client();
        $client->setApplicationName(GA_NAME);
        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials($service_account_email, array(Google_Service_Analytics::ANALYTICS_READONLY), $key);
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $analytics = new Google_Service_Analytics($client);
        $ids='ga:'.GA_PROFILE_ID;
        $ga_filed = array('views'=>'pageviews', 'visit'=>'visits', 'exit_rate'=>'exitRate', 'time_on_page'=>'avgTimeOnPage');
        $results = $analytics->data_ga->get($ids, $start, $end, 'ga:'.$ga_filed[$field], array('dimensions' => 'ga:year, ga:month, ga:day', 'filters'=>'ga:eventCategory==category_'.$category_id));
        $results = $results->rows;
        $res = array();
        if ($results) {
            foreach ($results as $one) {
                $year = $one[0];
                $month = $one[1];
                $day = $one[2];
                $res[$year][$month][$day] = $one[3];
            }
        }
        $assign_list['results'] = $res;
        #
        $assign_list['start'] = $start;
        $assign_list['end'] = $end;
        $assign_list['field'] = $field;
        $assign_list['field_unit'] = ($field=='exit_rate')?'%':(($field=='time_on_page')?'giây':$field);
        $assign_list['arr_field'] = array('views'=>'Lượt views', 'visit'=>'Visitor', 'exit_rate'=>'Tỷ lệ thoát', 'time_on_page'=>'Thời gian trên trang');
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thống kê | Module Manager";
        $this->render('backend/standart/administrator/chart/category', $assign_list);
    }
    public function news()
    {
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $this->load->model('Source_model');
        $clsSource = new Source_model();
        $assign_list['clsSource'] = $clsSource;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $this->load->model('News_model');
        $clsClassTable = new News_model;
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = 'user_id='.$me['user_id'];
        if ($_GET['keyword']) {
            $cons .= ' and title like "%'.addslashes($_GET['keyword']).'%"';
        }
        if ($_GET['status']) {
            $cons .= ' and status='.intval($_GET['status']).'';
        }
        if (isset($_GET['txt_start']) && $_GET['txt_start']) {
            $cons .= " and last_change_status>=".strtotime($_GET['txt_start'].' 00:00:00');
        }
        if (isset($_GET['txt_end']) && $_GET['txt_end']) {
            $cons .= " and last_change_status<=".strtotime($_GET['txt_end'].' 23:59:59');
        }
        $listItem = $clsClassTable->getListPage($cons." order by reg_date desc", 50, 'ADMIN');
        $paging = $clsClassTable->getNavPage($cons, 50, 'ADMIN');
        $totalPost = $clsClassTable->getCount($cons, true, 'ADMIN');
        $totalViews = $clsClassTable->getSum('views', $cons, 'ADMIN');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        $assign_list["totalViews"] = $totalViews;
        $description_page = '';
        $keyword_page = '';
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thống kê bài viết | Module Manager";
        $this->render('backend/standart/administrator/chart/news', $assign_list);
    }
    public function tops()
    {
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $this->load->model('Source_model');
        $clsSource = new Source_model();
        $assign_list['clsSource'] = $clsSource;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $this->load->model('News_model');
        $classTable = new News_model();
        $assign_list["classTable"] = $classTable;
        $clsClassTable = new News_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if (isset($_GET['category_id'])) {
            $cons = $clsClassTable->getCons($_GET['category_id']);
        } else {
            $cons = $clsClassTable->getCons();
        }
        #
        if (isset($_GET['type_post']) && $_GET['type_post']) {
            $cons .= " and type_post=".$_GET['type_post'];
        }
        #
        if (isset($_GET['type_is']) and $_GET['type_is']>0) {
            if ($_GET['type_is']==1) {
                $cons .= " and is_photo=1";
            } elseif ($_GET['type_is']==2) {
                $cons .= " and is_video=1";
            } elseif ($_GET['type_is']==3) {
                $cons .= " and is_photo=0 and is_video=0";
            }
        }
        if (isset($_GET['user_id']) && $_GET['user_id']) {
            $cons .= " and user_id=".$_GET['user_id'];
        }
        if (isset($_GET['txt_start']) && $_GET['txt_start']) {
            $cons .= " and last_change_status>=".strtotime($_GET['txt_start'].' 00:00:00');
        }
        if (isset($_GET['txt_end']) && $_GET['txt_end']) {
            $cons .= " and last_change_status<=".strtotime($_GET['txt_end'].' 23:59:59');
        }
        if (isset($_GET['push_user']) && $_GET['push_user']) {
            $cons .= " and push_user=".$_GET['push_user'];
        }
        #
        $order = 'views desc';
        #
        $listItem = $clsClassTable->getListPage($cons." order by ".$order, 50, 'ADMIN');
        $paging = $clsClassTable->getNavPage($cons, 50, 'ADMIN');
        $totalPost = $clsClassTable->getCount($cons, true, 'ADMIN');
        $totalViews = $clsClassTable->getSum('views', $cons, 'ADMIN');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        $assign_list["totalViews"] = $totalViews;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = '';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/chart/tops', $assign_list);
    }
}
