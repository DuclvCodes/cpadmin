<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class History extends Admin
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
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list['clsNews'] = $clsNews;
        
        $this->load->model('History_model');
        $clsHistory = new History_model();
        $assign_list["clsHistory"] = $clsHistory;
        $pkeyTable = $clsHistory->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1";
        if (isset($_GET['user_id']) && $_GET['user_id']) {
            $cons .= " and user_id=".intval($_GET['user_id']);
        }
        if (isset($_GET['news_id']) && $_GET['news_id']) {
            $cons .= " and news_id=".intval($_GET['news_id']);
        }
        if (isset($_GET['txt_start']) && $_GET['txt_start']) {
            $cons .= " and reg_date>='".$_GET['txt_start']." 00:00:00'";
        }
        if (isset($_GET['txt_end']) && $_GET['txt_end']) {
            $cons .= " and reg_date<='".$_GET['txt_end']." 23:59:59'";
        }
        #
        $listItem = $clsHistory->getListPage($cons." order by history_id desc", 50, 'CMS');
        $paging = $clsHistory->getNavPage($cons, 50, 'CMS');
        $totalPost = $clsHistory->getCount($cons, true, 'CMS');
        
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Quản lý lịch sử bài viết";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
}
