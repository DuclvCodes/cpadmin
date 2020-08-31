<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Vote extends Admin
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
        $this->load->model('Vote_model');
        $clsClassTable = new Vote_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1 ";
        $listItem = $clsClassTable->getListPage($cons." order by vote_id desc", RECORD_PER_PAGE, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thăm dò ý kiến";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function voter()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Vote_model');
        $clsClassTable = new Vote_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        $assign_list['oneItem'] = $oneItem;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $assign_list["answers"] = json_decode($oneItem['answers']);
        #
        $this->load->model('Voter_model');
        $clsVoter = new Voter_model();
        $assign_list['clsVoter'] = $clsVoter;
        $cons = "vote_id=".$oneItem['vote_id'];
        $order = 'voter_id desc';
        if (isset($_GET['answers']) && $_GET['answers']!='') {
            $cons .= ' and answers='.intval($_GET['answers']);
        }
        if (isset($_GET['order_nr'])) {
            $order = 'answers_right';
        }
        $listItem = $clsVoter->getListPage($cons." order by ".$order, RECORD_PER_PAGE, 'CMS');
        $paging = $clsVoter->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Thăm dò ý kiến';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    
    public function edit()
    {
        $vote_id = $_GET['id'];
        if (!$vote_id) {
            die('error');
        }
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        $this->load->model('Vote_model');
        $clsVote = new Vote_model();
        $oneItem = $clsVote->getOne($vote_id);
        $assign_list['one'] = $oneItem;
        $assign_list['answers'] = json_decode($oneItem['answers']);
        $assign_list['result'] = json_decode($oneItem['result']);
        $assign_list['is_predict'] = json_decode($oneItem['is_predict']);
        $assign_list['title'] = $oneItem['title'];
        if ($this->input->post()) {
            $class = 'tkp_area_vote';
            if ($_POST['vote_id']) {
                $vote_id = $_POST['vote_id'];
            } else {
                $vote_id = 0;
            }
            unset($_POST['vote_id']);
            $_POST['answers'] = json_encode($_POST['answers']);
            if ($this->input->post('youtube')) {
                $_POST['youtube'] = json_encode($_POST['youtube']);
                $class = 'tkp_area_votemusic';
            }
            $_POST['edit_by'] = $me['user_id'];
            $_POST['last_edit'] = time();
            if ($vote_id == 0) {
                $_POST['reg_date'] = date('Y-m-d H:i:s');
                $res = $clsVote->insertOne($_POST, true, 'CMS');
                if ($res) {
                    $vote_id = $clsVote->getMaxID('CMS');
                }
                redirect('/vote/edit?id='.$vote_id.'&mes=insertSuccess');
            } else {
                $res = $clsVote->updateOne($vote_id, $_POST);
                redirect('/vote/edit?id='.$vote_id.'&mes=insertSuccess');
            }

            if ($vote_id != 0) {
                echo '<div class="'.$class.'"><span class="vote_id" style="display:none">'.$vote_id.'</span><strong>Thăm dò ý kiến:</strong> '.$_POST['title'].'</div><p></p>';
            }
        }
        $this->render(current_method()['view'], $assign_list);
    }
    public function delete()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        //$classTable = ucfirst(strtolower($mod));
        $this->load->model('Vote_model');
        $clsClassTable = new Vote_model;
        if ($clsClassTable->deleteOne($id)) {
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
        redirect('/vote');
    }
}
