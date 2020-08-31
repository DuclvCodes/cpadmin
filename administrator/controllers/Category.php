<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Category Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Category extends Admin
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
        $classTable = 'Category';
        $assign_list["classTable"] = $classTable;
        $clsClassTable = new Category_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if ($this->input->post()) {
            if ($_POST['order_no']) {
                foreach ($_POST['order_no'] as $key=>$val) {
                    $clsClassTable->updateOne($key, array('order_no'=>$val));
                }
            }
            $clsClassTable->deleteArrKey('CMS');
            header('Location: '.getAddress());
        }
        #
        $cons = "parent_id=0";
        if (!isset($_GET['is_trash'])) {
            $_GET['is_trash'] = '0';
        }
        #
        if (isset($_GET['is_trash'])) {
            $cons .= " and is_trash=".$_GET['is_trash'];
            if ($_GET['is_trash']==1) {
                $cons = "is_trash=".$_GET['is_trash'];
            }
        }
        #
        if (isset($_GET['category_id'])) {
            $cons.=" and (category_id = ".$_GET['category_id']." OR category_id in (".implode(',', $clsCategory->getChild($_GET['category_id']))."))";
        }
        if (isset($_GET['keyword'])) {
            $cons .= " and slug like '%".toSlug($_GET['keyword'])."%'";
        }
        #
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = 'order_no';
        }
        #
        $listItem = $clsClassTable->getAll($cons." order by ".$order." limit 100", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "List ".$classTable." | Module ".$classTable." Manager";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        $classTable = ucfirst(strtolower('category'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Category_model');
        $clsClassTable = new Category_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $this->input->post('title')) {
            $_POST['slug'] = toSlug($_POST['title']);
            if ($clsClassTable->insertOne($_POST, false)) {
                $clsClassTable->deleteArrKey('CMS');
                $clsClassTable->deleteArrKey('BOX');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                #
                $this->load->model('Box_model');
                $clsBox = new Box_model();
                $clsBox->insertOne(array('title'=>'Box '.$_POST['title'], 'title_show'=>$_POST['title'], 'category_id'=>$maxId, 'slug'=> 'box_'. toSlug($_POST['title']), 'is_lock'=>'0'));
                #
                redirect('category/edit?id='.$maxId.'&mes=insertSuccess');
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
        $assign_list['title_page'] = "Add ".$classTable.'';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $classTable = ucfirst(strtolower('category'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Category_model');
        $clsClassTable = new Category_model();
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
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if (isset($_POST['action']) && $_POST['action']=='permission') {
            $data = $_POST['per'];
            $allUser = $clsUser->getAll('is_trash=0 order by level desc, user_id limit 1000', true, 'CMS');
            if ($allUser) {
                foreach ($allUser as $user_id) {
                    if ($data[$user_id]==1) {
                        $res = $clsUser->setPermissCat($user_id, $oneItem['category_id']);
                    } else {
                        $res = $clsUser->unsetPermissCat($user_id, $oneItem['category_id']);
                    }
                    if (!$res) {
                        die('ERR');
                    }
                }
            }
            message_flash('Update thông tin thành công', 'success');
            redirect('/category/edit?id='.$_GET['id']);
            die();
        }
        if ($this->input->post() && $this->input->post('title')) {
            #
            if ($_POST['parent_id']==$_GET['id']) {
                $msg = 'Không được đặt danh mục cha trùng với danh mục hiện tại';
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            } else {
                if ($_POST['title']!=$oneItem['title']) {
                    $this->load->model('Box_model');
                    $clsBox = new Box_model();
                    $box_id = $clsBox->getBoxByCategoryID($_GET['id']);
                    if ($box_id) {
                        $clsBox->updateOne($box_id['box_id'], array('title'=>'Box  '.$_POST['title'], 'title_show'=>$_POST['title']));
                    } else {
                        $this->load->model('Mail_model');
                        $clsMail = new Mail_model();
                        $clsMail->reportError('Lỗi không tìm thấy BOX  '.$oneItem['title'].' (CAT ID: '.$_GET['id'].')');
                    }
                }
                if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                    $clsClassTable->deleteArrKey();
                    $clsClassTable->deleteArrKey('CMS');
                    $clsClassTable->deleteArrKey('BOX');
                    message_flash('Update thông tin thành công', 'success');
                    redirect('/category/edit?id='.$_GET['id']);
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
        }
        #
        $allUser = $clsUser->getAll('is_trash=0 order by level desc, user_id limit 500', true, 'CMS');
        $assign_list["allUser"] = $allUser;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Edit Category";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $this->load->model('Category_model');
        $clsClassTable = new Category_model();
        #
        $this->load->model('Box_model');
        $clsBox = new Box_model();
        $box_id = $clsBox->slugToID('box_nb_'.$id);
        $title = $clsClassTable->getTitle($id);
        if ($box_id) {
            $oneBox = $clsBox->getOne($box_id);
            if ($oneBox['is_lock']) {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                echo '<h2>Danh mục đang khóa vì đang sử dụng ngoài trang chủ</h2><br />';
                $clsMail->reportError('Lỗi không cho xóa BOX Nổi Bật (lí do đang xóa) '.$title.' (CAT ID: '.$id.')', false);
            } else {
                $clsBox->deleteOne($box_id, true, 'CMS');
            }
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $clsMail->reportError('Lỗi không tìm thấy BOX Nổi Bật '.$title.' (CAT ID: '.$id.')', false);
        }
        #
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            $clsClassTable->deleteArrKey('BOX');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa tạm trong module '.$classTable, false);
        }
    }
    public function restore()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $this->load->model('Category_model');
        $clsClassTable = new Category_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'0'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            $clsClassTable->deleteArrKey('BOX');

            $title = $clsClassTable->getTitle($id);
            $this->load->model('Box_model');
            $clsBox = new Box_model();
            $clsBox->insertOne(array('title'=>'Box '.$title, 'title_show'=>$title, 'category_id'=>$id, 'slug'=> 'box_nb_'.$id, 'is_lock'=>'0'));

            redirect(getLinkDefault());
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
        $this->load->model('Category_model');
        $clsClassTable = new Category_model();
        if ($clsClassTable->deleteOne($id)) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }
}
