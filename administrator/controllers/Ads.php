<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Ads Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Ads extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }

        $this->load->model('Ads_model');
        $clsClassTable = new Ads_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        $assign_list['mod'] = 'ads';
        #
        $listItem = $clsClassTable->getAll("1=1 order by title", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $this->load->model('News_model');
        $clsNews = new News_model();
        $allCat = $clsCategory->getAll('is_trash=0 order by category_id limit 1', true, 'KQT');
        if ($allCat) {
            $assign_list['link_cat'] = $clsCategory->getLink($allCat[0]);
        }
        $allNews = $clsNews->getAll($clsNews->getCons().' order by news_id desc limit 1', true, 'KQT');
        if ($allNews) {
            $assign_list['link_news'] = $clsNews->getLink($allNews[0]);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Danh sách Quảng cáo ";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        $this->load->model('Ads_model');
        $clsClassTable = new Ads_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($_POST && $_POST['title']) {
            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/ads/edit?id='.$maxId.'&mes=insertSuccess');
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi thêm bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Tạo mới Quảng cáo';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $this->load->model('Ads_model');
        $clsClassTable = new Ads_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('Code_model');
        $clsCode = new Code_model();
        $assign_list["clsCode"] = $clsCode;
        $this->load->model('Area_model');
        $clsArea = new Area_Model();
        $assign_list["clsArea"] = $clsArea;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        $allArea = $clsArea->getAll('ads_id='.$oneItem['ads_id'].' order by area_id desc limit 1000', true, 'ads_'.$oneItem['ads_id']);
        $assign_list["allArea"] = $allArea;
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        $assign_list['code_path'] = pathToArray($oneItem['code_path']);
        $assign_list['code_path_2'] = pathToArray($oneItem['code_path_2']);
        $assign_list['code_path_3'] = pathToArray($oneItem['code_path_3']);
        #
        if ($this->input->post() && $_POST['title']) {
            #
            $width = 0;
            $height = 0;
            if ($_POST['is_horizontal']) {
                if ($_POST['code_path']) {
                    foreach ($_POST['code_path'] as $key=>$code_id) {
                        $oneCode = $clsCode->getOne($code_id);
                        $width += $oneCode['width'];
                        if ($key) {
                            $width += $_POST['light_height'];
                        }
                        if ($height<$oneCode['height']) {
                            $height=$oneCode['height'];
                        }
                    }
                }
            } else {
                if ($_POST['code_path']) {
                    foreach ($_POST['code_path'] as $key=>$code_id) {
                        $oneCode = $clsCode->getOne($code_id);
                        $height += $oneCode['height'];
                        if ($key) {
                            $height += $_POST['light_height'];
                        }
                        if ($width<$oneCode['width']) {
                            $width=$oneCode['width'];
                        }
                    }
                }
            }
            $_POST['width'] = $width;
            $_POST['height'] = $height;
            #
            $_POST['share_ad'] = 1;
            if ($_POST['code_path_2']) {
                $_POST['share_ad'] = 2;
            }
            if ($_POST['code_path_3']) {
                $_POST['share_ad'] = 3;
            }
            $_POST['code_path'] = arrayToPath($_POST['code_path']);
            $_POST['code_path_2'] = arrayToPath($_POST['code_path_2']);
            $_POST['code_path_3'] = arrayToPath($_POST['code_path_3']);
            $_POST['user_edit'] = $me['user_id'];
            $_POST['last_edit'] = time();

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                message_flash('Update thông tin thành công', 'success');
                redirect('/ads/edit?id='.$_GET['id']);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
            unset($_POST);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Chỉnh sửa Quảng cáo';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function addcat()
    {
        $this->load->model('Ads_model');
        $clsAds = new Ads_model();
        $this->load->model('Area_model');
        $clsArea = new Area_model();
        $ads_id = intval($_GET['id']);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Not found');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        $all = $clsArea->getAll('ads_id="'.$ads_id.'" and user_edit=0 order by area_id desc limit 1', false);
        if ($all) {
            redirect('/ads/editcat?id='.$all[0]);
        } else {
            if ($clsArea->insertOne(array('ads_id'=>$ads_id, 'is_show'=>1, 'user_edit'=>0))) {
                $clsArea->deleteArrKey('CMS');
                $clsArea->deleteArrKey('ads_'.$ads_id);
                $maxId = $clsArea->getMaxID('CMS');
                redirect('/ads/editcat?id='.$maxId);
            }
        }
    }
    public function delcat()
    {
        $this->load->model('Area_model');
        $clsArea = new Area_model();
        $area_id = intval($_GET['id']);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Not found');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        $oneArea = $clsArea->getOne($area_id);
        $clsArea->deleteOne($area_id, true, 'CMS');
        $clsArea->deleteArrKey('ads_'.$oneArea['ads_id']);
        redirect('/ads/edit?id='.$oneArea['ads_id']);
        die();
    }
    public function editcat()
    {
        $this->load->model('Ads_model');
        $clsAds = new Ads_model();
        $assign_list['clsAds'] = $clsAds;
        $this->load->model('Area_model');
        $clsArea = new Area_model();
        $assign_list['clsArea'] = $clsArea;
        $this->load->model('Code_model');
        $clsCode = new Code_model();
        $assign_list['clsCode'] = $clsCode;
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $allCat = $clsCategory->getChild(0);
        $assign_list['allCat'] = $allCat;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        $oneItem = $clsArea->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        $assign_list['code_path']   = pathToArray($oneItem['code_path']);
        $assign_list['code_path_2'] = pathToArray($oneItem['code_path_2']);
        $assign_list['code_path_3'] = pathToArray($oneItem['code_path_3']);
        $assign_list['cat_path']    = pathToArray($oneItem['cat_path']);
        #
        $oneAds = $clsAds->getOne($oneItem['ads_id']);
        $assign_list['oneAds'] = $oneAds;
        #
        if ($this->input->post()) {
            #
            $width = 0;
            $height = 0;
            if ($oneAds['is_horizontal']) {
                if ($_POST['code_path']) {
                    foreach ($_POST['code_path'] as $key=>$code_id) {
                        $oneCode = $clsCode->getOne($code_id);
                        $width += $oneCode['width'];
                        if ($key) {
                            $width += $_POST['light_height'];
                        }
                        if ($height<$oneCode['height']) {
                            $height=$oneCode['height'];
                        }
                    }
                }
            } else {
                if ($_POST['code_path']) {
                    foreach ($_POST['code_path'] as $key=>$code_id) {
                        $oneCode = $clsCode->getOne($code_id);
                        $height += $oneCode['height'];
                        if ($key) {
                            $height += $_POST['light_height'];
                        }
                        if ($width<$oneCode['width']) {
                            $width=$oneCode['width'];
                        }
                    }
                }
            }
            $_POST['width'] = $width;
            $_POST['height'] = $height;
            #
            $_POST['share_ad'] = 1;
            if ($_POST['code_path_2']) {
                $_POST['share_ad'] = 2;
            }
            if ($_POST['code_path_3']) {
                $_POST['share_ad'] = 3;
            }
            $_POST['code_path']     = arrayToPath($_POST['code_path']);
            $_POST['code_path_2']   = arrayToPath($_POST['code_path_2']);
            $_POST['code_path_3']   = arrayToPath($_POST['code_path_3']);
            $_POST['user_edit'] = $me['user_id'];
            $_POST['last_edit'] = time();

            $title = '';
            if ($_POST['cat_path']) {
                foreach ($_POST['cat_path'] as $id) {
                    $title .= $clsCategory->getTitle($id).', ';
                }
            } else {
                die('Bạn chưa chọn chuyên mục');
            }
            $_POST['title'] = rtrim($title, ', ');
            $_POST['cat_path'] = arrayToPath($_POST['cat_path']);

            if ($clsArea->updateOne($_GET['id'], $_POST)) {
                message_flash('Update thông tin thành công', 'success');
                redirect('/ads/editcat?id='.$_GET['id']);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Chỉnh sửa Quảng cáo';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
}
