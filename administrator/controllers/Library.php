<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Library extends Admin
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
        
        $clsClassTable = new Library_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "is_trash=0";
        #
        if (isset($_GET['is_trash']) && $_GET['is_trash']==1) {
            $cons = "is_trash=1";
        }
        if ($_GET['keyword']) {
            $cons .= " and slug like '%".toSlug($_GET['keyword'])."%'";
        }
        if (isset($_GET['category_id']) && $_GET['category_id']>0) {
            $cons .= " and category_id=".$_GET['category_id'];
        }

        if (isset($_GET['txt_start']) && $_GET['txt_start']) {
            $cons .= " and reg_date>='".$_GET['txt_start'].' 00:00:00'."'";
        }
        if (isset($_GET['txt_end']) && $_GET['txt_end']) {
            $cons .= " and reg_date<='".$_GET['txt_end'].' 23:59:59'."'";
        }
        #
        $order = 'reg_date desc, library_id desc';
        #
        $listItem = $clsClassTable->getListPage($cons." order by  ".$order, 50, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, 50, 'CMS');
        $totalPost = $clsClassTable->getCount($cons, true, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Thư viện - CMS ';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/library/library', $assign_list);
    }
    public function add()
    {
        $clsClassTable = new Library_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($_POST) {
            $_POST['slug'] = toSlug($_POST['title']);
            $_POST['reg_date'] = date('Y-m-d');
            $_POST['user_id'] = $me['user_id'];
            #
            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $clsClassTable->deleteArrKey('BOX');
                $maxId = $clsClassTable->getMaxID('CMS');
                redirect('/library/edit?id='.$maxId);
                die();
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi thêm bài trong module Tin tức: '.json_encode($_POST), false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Thư viện';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/library/add', $assign_list);
    }
    public function edit()
    {
        $clsClassTable = new Library_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        } else {
            die('not found');
        }
        $NUM_PAPER = $oneItem['num_page'];
        $assign_list['NUM_PAPER'] = $NUM_PAPER;
        if ($oneItem['images']) {
            $images = json_decode($oneItem['images']);
        } else {
            $images = array();
        }
        $assign_list['images'] = $images;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        $clsImage = new Image_model();
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post()) {
            #
            if (isset($_POST['action']) && $_POST['action']=='insert') {
                if ($_FILES['file']['name']) {
                    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), $allowed)) {
                        die('Do not support this extension');
                    }
                    if ($_FILES['file']['type']=='image/jpeg') {
                        $file = ftpUpload('file', $mod, 'so-'.$oneItem['num'].'-insert-'.time(), time(), 900, 0);
                    } elseif ($_FILES['file']['type']=='application/pdf') {
                        $filename = $_FILES['file']['name'];
                        $name = toSlug(basename($filename));
                        $pdf_file = 'uploads/'.$name.'.'.$clsImage->getFileType($filename);
                        $img_file = substr($pdf_file, 0, -3).'jpg';
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $pdf_file)) {
                            exec("convert -density 600 \"{$pdf_file}[0]\" -colorspace RGB -resample 100 $img_file");
                            unlink($pdf_file);
                            $file = $clsImage->moveToMedia($img_file, $mod, $oneItem['slug'].'-trang-i1', time()).'?v='.date('His');
                        }
                    }
                }
                if (!$file) {
                    die('ERR');
                }
                if ($_POST['type']=='begin') {
                    array_unshift($images, $file);
                    $_POST['image'] = $file;
                } else {
                    $images[] = $file;
                }
                $_POST['images'] = json_encode($images);
                $_POST['num_page'] = sizeof($images);
                unset($_POST['action']);
                unset($_POST['type']);
            } else {
                $_POST['slug'] = toSlug($_POST['title']);
                $_POST['reg_date'] = datepicker2db($_POST['reg_date'], false);
                if ($_POST['reg_date'] != $oneItem['reg_date']) {
                    $clsClassTable->deleteArrKey('CMS');
                }
            }
            #
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $clsClassTable->deleteArrKey('BOX');
                redirect('/library/edit?id='.$_GET['id']);
                die();
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
        $assign_list['title_page'] = 'Thư viện';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/library/edit', $assign_list);
    }
    public function updateImage()
    {
        $clsClassTable = new Library_model();
        $oneItem = $clsClassTable->getOne($_GET['id']);
        $images = json_decode($oneItem['images']);
        $NUM_PAPER = $oneItem['num_page'];
        $imagesz = array();
        $data = array();
        $clsImage = new Image_model();
        $res = 'ERR';
        for ($i=1; $i<=$NUM_PAPER; $i++) {
            if ($_FILES['image_'.$i]['name']) {
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($_FILES['file_'.$i]['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $filename = $_FILES['image_'.$i]['name'];
                $name = toSlug(basename($filename));
                $pdf_file = 'uploads/'.$name.'.'.$clsImage->getFileType($filename);
                $img_file = substr($pdf_file, 0, -3).'jpg';
                if (move_uploaded_file($_FILES['image_'.$i]['tmp_name'], $pdf_file)) {
                    exec("convert -density 600 \"{$pdf_file}[0]\" -colorspace RGB -resample 100 $img_file");
                    unlink($pdf_file);
                    $res = $clsImage->moveToMedia($img_file, $mod, $oneItem['slug'].'-trang-'.$i, time()).'?v='.date('His');
                    $imagesz[] = $res;
                }
            } else {
                $imagesz[] = $images[$i-1];
            }
        }
        if ($imagesz) {
            $data['image'] = $imagesz[0];
        }
        $data['images'] = json_encode($imagesz);
        if ($clsClassTable->updateOne($_GET['id'], $data)) {
            $clsClassTable->deleteArrKey('CMS');
            die(MEDIA_DOMAIN.'/resize_170x106'.$res);
        }
        die();
    }
    public function upload()
    {
        $clsClassTable = new Library_model();
        $id = isset($_GET['id'])?$_GET['id']:0;
        if (!$id) {
            die();
        }
        $oneItem = $clsClassTable->getOne($id);

        if (isset($_FILES['pdf']) && $_FILES['pdf']['type']=='application/pdf') {
            $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                die('Do not support this extension');
            }
            $pdf_file = 'uploads/bao-giay.pdf';
            if (move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_file)) {
                $dir = '/home/'.DOMAIN.'/uploads/';
                shell_exec('cd '.$dir.'; pdftk bao-giay.pdf burst; rm -rf '.$dir.'bao-giay.pdf; rm -rf '.$dir.'doc_data.txt;');
                $files = glob('uploads/pg*.{pdf}', GLOB_BRACE);
                $data = array();
                $imagesz = array();
                if ($files) {
                    foreach ($files as $pdf_file) {
                        $imagesz[] = $pdf_file;
                    }
                }
                $data['num_page'] = sizeof($imagesz);
                $clsClassTable->updateOne($id, $data);
                die(json_encode($imagesz));
            }
        }
        die('0');
    }
    public function pdf2jpg()
    {
        $clsImage = new Image_model();
        $pdf_file = isset($_POST['pdf'])?$_POST['pdf']:'';
        if (!$pdf_file) {
            die('0');
        }
        $slug = isset($_POST['slug'])?$_POST['slug']:'';
        $page = isset($_POST['page'])?$_POST['page']:'1';
        $img_file = substr($pdf_file, 0, -3).'jpg';
        exec("convert -density 600 \"{$pdf_file}[0]\" -colorspace RGB -resample 100 $img_file");
        unlink($pdf_file);
        $res = $clsImage->moveToMedia($img_file, $mod, $slug.'-trang-'.$page, time()).'?v='.date('His');
        die($res);
    }
    public function update_images()
    {
        $clsClassTable = new Library_model();
        $id = isset($_POST['id'])?$_POST['id']:'';
        if (!$id) {
            die('0');
        }
        $images = isset($_POST['images'])?$_POST['images']:'';
        $images = pathToArray($images);
        $data = array('image'=>$images[0]);
        $data['images'] = json_encode($images);
        $clsClassTable->updateOne($id, $data);
        die('1');
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $clsClassTable = new Library_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die();
        }
        #
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect('/library?is_trash=1');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa tạm trong module '.$classTable);
        }
    }
    public function restore()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new Library_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die();
        }
        #
        if ($clsClassTable->updateOne($id, array('is_trash'=>'0'))) {
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect('/library');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi khôi phục trong module '.$classTable);
        }
    }
    public function delete()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new Library_model();
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die();
        }
        #
        if ($clsClassTable->deleteOne($id)) {
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect('/library');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }
    public function del_cover()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new Library_model();
        $one = $clsClassTable->getOne($id);
        if ($one['images']) {
            $images = json_decode($one['images']);
            $image = array_shift($images);
            $image = $images[0];
            $clsClassTable->updateOne($id, array('image'=>$image, 'images'=>json_encode($images)));
        }
        redirect('/library/edit?id='.$id);
        die();
    }
}
