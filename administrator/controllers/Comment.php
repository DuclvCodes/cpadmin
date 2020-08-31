<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Comment Controller
*| --------------------------------------------------------------------------
*| For comment controller
*|
*/
class Comment extends Admin
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
        
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Comment_model');
        $clsClassTable = new Comment_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        $this->load->model('News_model');
        $assign_list["clsNews"] = new News_model();
        #
        $listItem = $clsClassTable->getListPage("1=1 order by comment_id desc", RECORD_PER_PAGE, 'CMS');
        $paging = $clsClassTable->getNavPage('1=1', RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Quản lý bình luận";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/comment/comment', $assign_list);
    }
}
