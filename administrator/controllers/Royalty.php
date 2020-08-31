<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Royalty extends Admin
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
        $this->load->model('Signature_model');
        $clsSignature=new Signature_model();
        $assign_list['clsSignature'] = $clsSignature;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $classTable = 'News';
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if (!$_GET['txt_start'] || $_GET['txt_start']=='') {
            $_GET['txt_start'] = date('Y-m-d', time()-60*60*24*30);
        }
        if (!$_GET['txt_end'] || $_GET['txt_end']=='') {
            $_GET['txt_end'] = date('Y-m-d');
        }
        $cons = "is_trash=0 and status=4";
        if ($_GET['txt_start']) {
            $cons .= " and push_date>='".date('Y-m-d', strtotime($_GET['txt_start']))."'";
            $assign_list["txt_start"] = $_GET['txt_start'];
        }
        if ($_GET['txt_end']) {
            $cons .= " and push_date<='".date('Y-m-d', strtotime($_GET['txt_end'])+24*60*60)."'";
            $assign_list["txt_end"] = $_GET['txt_end'];
        }
        if ($_GET['user_id']) {
            $cons.=" and user_id='".$_GET['user_id']."'";
            $assign_list["user_id"] = $_GET['user_id'];
        }
        if ($_GET['push_user']) {
            $cons.=" and push_user='".$_GET['push_user']."'";
            $assign_list["push_user"] = $_GET['push_user'];
        }
        if ($_GET['category_id']) {
            $cat_id = $_GET['category_id'];
            $allCat = $clsCategory->getChild($cat_id);
            $allCat[] = $cat_id;
            $cons .= ' and category_id in('.implode(',', $allCat).')';
        }
        if ($_GET['keyword']) {
            $cons .= " and title like '%".$_GET['keyword']."%'";
        }
        if ($_GET['is_royalty'] && $_GET['is_royalty']>0) {
            if ($_GET['is_royalty']==1) {
                $cons .= " and royalty > 0";
            } else {
                $cons .= " and royalty = 0";
            }
        }
        if ($_GET['type_post'] && $_GET['type_post'] > 0) {
            $cons .= " and type_post=".$_GET['type_post'];
        }
        $rpp = 15;
        $assign_list["rpp"] = $rpp;

        if (defined('USER_HIDDEN_INNB')) {
            $cons .= ' and user_id not in('.str_replace('|', ',', trim(USER_HIDDEN_INNB, '|')).')';
        }

        $listItem = $clsClassTable->getListPage($cons." order by user_id, push_date desc", $rpp);
        $paging = $clsClassTable->getNavPage($cons, $rpp);
        $total_royalty = $clsClassTable->getSum('royalty', $cons.' and royalty>1', 'CMS');
        
        $total_views = $clsClassTable->getSum('views', $cons, 'CMS');
        $totalPost = $clsClassTable->getCount($cons, true, 'CMS');

        $assign_list["total_royalty"] = $total_royalty;
        $assign_list["total_views"] = $total_views;
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        $assign_list["totalPost"] = $totalPost;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Nhuận bút";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/royalty/royalty', $assign_list);
    }
    public function excel()
    {
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $this->load->model('Signature_model');
        $clsSignature=new Signature_model();
        $assign_list['clsSignature'] = $clsSignature;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $classTable = 'News';
        $this->load->model('News_model');
        $clsClassTable = new News_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $filename = DOMAIN_SHORTNAME;
        $cons = "is_trash=0 and status=4";
        if ($_GET['user_id']) {
            $cons.=" and user_id='".$_GET['user_id']."'";
            $assign_list["user_id"] = $_GET['user_id'];
            $filename .= '-'.toSlug($clsUser->getFullname($_GET['user_id']));
        }
        if ($_GET['txt_start']) {
            $cons .= " and push_date>='".date('Y-m-d', strtotime($_GET['txt_start']))."'";
            $assign_list["txt_start"] = $_GET['txt_start'];
            $filename .= '-'.date('Y-m-d', strtotime($_GET['txt_start']));
        }
        if ($_GET['txt_end']) {
            $cons .= " and push_date<='".date('Y-m-d', strtotime($_GET['txt_end'])+24*60*60)."'";
            $assign_list["txt_end"] = $_GET['txt_end'];
            $filename .= '-'.date('Y-m-d', strtotime($_GET['txt_end']));
        }
        if ($_GET['push_user']) {
            $cons.=" and push_user='".$_GET['push_user']."'";
            $assign_list["push_user"] = $_GET['push_user'];
        }
        if ($_GET['category_id']) {
            $cat_id = $_GET['category_id'];
            $allCat = $clsCategory->getChild($cat_id);
            $allCat[] = $cat_id;
            $cons .= ' and category_id in('.implode(',', $allCat).')';
        }
        if ($_GET['keyword']) {
            $cons .= " and title like '%".$_GET['keyword']."%'";
        }
        if (isset($_GET['is_royalty']) && $_GET['is_royalty']>0) {
            if ($_GET['is_royalty']==1) {
                $cons .= " and royalty > 0";
            } else {
                $cons .= " and royalty = 0";
            }
        }
        if (isset($_GET['type_post']) && $_GET['type_post']) {
            $cons .= " and type_post=".$_GET['type_post'];
        }

        $listItem = $clsClassTable->getAll($cons." and royalty>1 order by user_id, push_date limit 10000", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["filename"] = $filename;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Downloading ... | Nhuận bút |  CMS";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/royalty/excel', $assign_list);
    }
    public function user()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        if (!$me) {
            die('Not found ...');
        }
        $this->load->model('News_model');
        $clsNews = new News_model();
        $assign_list['clsNews'] = $clsNews;

        $txt_start = isset($_GET['txt_start'])?$_GET['txt_start']:date('Y-m-d', strtotime('-1 month'));
        $txt_end = isset($_GET['txt_end'])?$_GET['txt_end']:date('Y-m-d');

        $cons = 'is_trash=0 and status=4 and royalty>1';
        if ($txt_start) {
            $cons .= " and push_date>='".date('Y-m-d', strtotime($txt_start))."'";
        }
        if ($txt_end) {
            $cons .= " and push_date<='".date('Y-m-d', strtotime($txt_end)+24*60*60)."'";
        }

        $res = array();
        $allUser = $clsUser->getAll('is_trash=0 order by user_id limit 1000', true, 'CMS');
        if ($allUser) {
            foreach ($allUser as $user_id) {
                $royalty = $clsNews->getSum('royalty', $cons.' and user_id='.$user_id, 'CMS');
                $res[$user_id] = $royalty;
            }
        }
        arsort($res);
        $assign_list['txt_start'] = $txt_start;
        $assign_list['txt_end'] = $txt_end;
        $assign_list['res'] = $res;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Nhuận bút |  CMS";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/royalty/user', $assign_list);
    }
    public function sendMail()
    {
        $user_id = intval($_GET['user_id']);
        $txt_start = isset($_GET['txt_start'])?$_GET['txt_start']:0;
        $txt_end = isset($_GET['txt_end'])?$_GET['txt_end']:0;
        if (!$user_id || !$txt_start || !$txt_end) {
            die('Not found');
        }
        $this->load->model('User_model');
        $clsUser = new User_model();
        $clsMail = new Mail_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Not found');
        }

        $oneUser = $clsUser->getOne($user_id);
        $fullname = $oneUser['fullname'];
        $title = 'Nhuận bút '.$fullname.' từ ngày '.date('d/m/Y', strtotime($txt_start)).' đến ngày '.date('d/m/Y', strtotime($txt_end));
        $content = '<p>Nhuận bút điện tử của '.$fullname.' từ ngày '.date('d/m/Y', strtotime($txt_start)).' đến ngày '.date('d/m/Y', strtotime($txt_end)).'</p>';
        $content .= '<p>Đề nghị kiểm tra lại. Nếu có thắc mắc thì thông báo ngay cho '.$me['fullname'].' qua địa chỉ '.$me['email'].'</p>';
        $content .= '<p>Attact file nhuận bút của '.$fullname.'</p>';
        $content .= '<p style="text-align: center;">'.$clsMail->genButton('http://cms.'.DOMAIN.'/royalty/excel?txt_start='.$txt_start.'&txt_end='.$txt_end.'&user_id='.$user_id.'', 'Download file đính kèm').'</p>';

        $res = $clsMail->sendMail($oneUser['email'], $title, $content, 'now', null, $fullname, $me['fullname'].' - '.DOMAIN_NAME, $me['email']);
        if ($res) {
            die('1');
        } else {
            die('0');
        }
    }
    public function ajax()
    {
        $id = intval($_POST['id']);
        if (!$id) {
            die('0');
        }

        $data['royalty_news'] = toNumber($_POST['royalty_news']);
        $data['royalty_photo'] = toNumber($_POST['royalty_photo']);
        $data['royalty_video'] = toNumber($_POST['royalty_video']);
        $data['royalty_other'] = toNumber($_POST['royalty_other']);
        $total = $data['royalty_news']+$data['royalty_photo']+$data['royalty_video']+$data['royalty_other'];
        $mark = false;
        if (!$total) {
            $total=1;
            $mark = true;
        }
        $data['royalty'] = $total;
        $data['royalty_reviews'] = $_POST['royalty_reviews'];
        $data['royalty_error'] = $_POST['royalty_error'];
        $this->load->model('News_model');
        $clsNews= new News_model();
        if ($clsNews->updateOne($id, $data)) {
            $clsNews->deleteArrKey('CMS');
            $clsNews->deleteArrKey('SUM');
            if ($mark) {
                $total = 0;
            }
            die(toString($total).' VNĐ');
        } else {
            die('0');
        }
    }
}
