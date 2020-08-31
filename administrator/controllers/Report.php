<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Report extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list['clsNews'] = $clsNews;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $allCategory = $clsCategory->getChild(0);
        $assign_list['allCategory'] = $allCategory;
        if (isset($_GET['txt_start']) || isset($_GET['txt_end'])) {
            $start = $_GET['txt_start'];
            $end = $_GET['txt_end'];
        } else {
            $start = date('Y-m', time()).'-1';
            $end = date('Y-m-d');
        }
        $assign_list['start'] = $start;
        $assign_list['end'] = $end;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Báo cáo | Module Manager";
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function user()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list['clsNews'] = $clsNews;
        $allUser = $clsUser->getAll('is_trash=0 and level>0 order by fullname limit 1000');
        $assign_list['allUser'] = $allUser;
        if (isset($_GET['txt_start']) || isset($_GET['txt_end'])) {
            $start = $_GET['txt_start'];
            $end = $_GET['txt_end'];
        } else {
            $start = date('Y-m', time()).'-1';
            $end = date('Y-m-d');
        }
        $assign_list['start'] = $start;
        $assign_list['end'] = $end;
        $assign_list['allType'] = $allType = $clsNews->getAllType();

        $total_pageview = 0;
        $view_by_other = 0;
        $views = 0;
        foreach ($allUser as $key_user=>$id) {
            $assign_list['userList'][$key_user]['oneUser'] = $clsUser->getOne($id);
            $cons = 'is_trash=0 and status=4 and user_id='.$id.' and push_date > "'.date('Y-m-d', strtotime($start)).' 00:00:00" and push_date < "'.date('Y-m-d', strtotime($end)).' 23:59:59"';
            $views = $clsNews->getSum('views', $cons, 'CMS');
            $assign_list['userList'][$key_user]['page_views'] = $views;
            $assign_list['total_page_views'] = $total_pageview += $views; 
            
            //get view of type
            $view_by_type = 0;
            $view_by_type_t = 0;
            if ($allType) {
                foreach ($allType as $key=>$one) {
                    $view_by_type = $clsNews->getCount($cons.' and type_post='.$key, true, 'CMS');
                    $assign_list['userList'][$key_user][$one] =$view_by_type;
                    $view_by_type_t +=$view_by_type;
                }
            }
            $view_by_other = $clsNews->getCount($cons.' and type_post=0', true, 'CMS');
            $assign_list['userList'][$key_user]['Khác'] = $view_by_other;
            $assign_list['total_views'] += $view_by_type_t +=$view_by_other;
            $assign_list['userList'][$key_user]['total_views'] +=$view_by_type_t;
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Báo cáo | Module Manager";
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
}
