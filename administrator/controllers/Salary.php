<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Mom extends Admin
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
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $classTable = 'News';
        $clsClassTable = new News_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "status>=3";
        if (isset($_GET['txt_start']) && $_GET['txt_start']) {
            $cons .= " and push_date>='".date('Y-m-d', strtotime($_GET['txt_start']))."'";
            $assign_list['txt_start'] = $_GET['txt_start'];
        }
        if (isset($_GET['txt_end']) && $_GET['txt_end']) {
            $cons .= " and push_date<='".date('Y-m-d', strtotime($_GET['txt_end'])+24*60*60)."'";
            $assign_list['txt_end'] = $_GET['txt_end'];
        }
        if (isset($_GET['user_id']) && $_GET['user_id']) {
            $cons.=" and user_id='".$_GET['user_id']."'";
            $assign_list['user_id'] = $_GET['user_id'];
        }

        if ($_GET['nolimit']) {
            $listItem = $clsClassTable->getAll($cons." order by push_date desc");
        } else {
            $listItem = $clsClassTable->getListPage($cons." order by push_date desc");
            $paging = $clsClassTable->getNavPage($cons);
        }
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        $total_royalty = $clsClassTable->getSum('royalty', $cons, 'CMS');
        $assign_list["total_royalty"] = $total_royalty;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Salary";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/salary/salary', $assign_list);
    }
}
