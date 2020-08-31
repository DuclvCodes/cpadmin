<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Pack extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $clsClassTable = new Pack_model();
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
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        $editing = $clsUser->getEditing($_GET['id']);
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            if ($_POST['slug']) {
                $_POST['slug'] = toSlug($_POST['slug']);
            } else {
                $_POST['slug'] = toSlug($_POST['title']);
            }
            if (isset($_POST['content'])) {
                $_POST['content'] = str_replace('<p> </p>', '', $_POST['content']);
            }
            #
            $_POST['news_path'] = arrayToPath($_POST['news_path']);
            if (isset($_POST['image'])) {
                $_POST['image'] = str_replace(MEDIA_DOMAIN, '', $_POST['image']);
            } elseif ($_FILES['image']['name']) {
                $_POST['image'] = ftpUpload('image', $mod, $_POST['slug'], time(), MAX_WIDTH, MAX_HEIGHT).'?v='.time();
            }
            #
            $_POST['last_edit'] = time();
            $_POST['last_edit_user'] = $me['user_id'];
            #
            $clsHistory = new History();
            $data = $_POST;
            $data['news_id'] = $_GET['id'];
            $clsHistory->add($data, 'EDIT', $me['user_id']);
            #
            if ($_POST['slide']) {
                require('lib/simple_html_dom.php');
                $html = str_get_html($_POST['slide']);
                $_POST['slide']='';
                if ($html) {
                    foreach ($html->find('table.figure') as $key=>$e) {
                        if ($key) {
                            $_POST['slide'] .= "[n]";
                        }
                        $_POST['slide'] .= $e->find('img', 0)->src.'[v]'.trim($e->find('tr.figcaption', 0)->plaintext);
                    }
                }
            }
            #
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $clsClassTable->deleteArrKey('BOX');
                $clsNews = new News();
                $keycache = $clsNews->getKey($_GET['id']);
                $clsNews->deleteCache($keycache);
                redirect('/news?mes=updateSuccess');
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module Tin tức: '.json_encode($_POST), false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
            unset($_POST);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Edit Pack";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }

    public function delete()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new Pack_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('0');
        }
        #
        $clsHistory = new History_model();
        $clsHistory->add(array('news_id'=>$id), 'DELETE', $me['user_id'], false);
        #
        if ($clsClassTable->deleteOne($id)) {
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            $clsNews = new News();
            $keycache = $clsNews->getKey($id);
            $clsNews->deleteCache($keycache);
            redirect('/news?mes=updateSuccess');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }
}
