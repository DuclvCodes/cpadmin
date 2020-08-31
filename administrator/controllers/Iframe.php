<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Iframe extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('/');
    }
    
    public function login()
    {
        $clsUser = $this->load->model('User_model');
        $data['msg'] = '';
        $remember = false;
        if ($this->input->post('user_name') && $this->input->post('user_pass')) {
            //$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
     
            $userIp=$this->input->ip_address();
         
            // $secret = $this->config->item('google_secret');
       
            // $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
     
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // $output = curl_exec($ch);
            // curl_close($ch);
             
            // $status= json_decode($output, true);
            //if ($status['success']) {
                if($this->input->post('remember')) $remember = true;
                if ($this->User_model->login(strtolower($this->input->post('user_name')), $this->input->post('user_pass'),$remember)) {
                    $user_id = $this->User_model->getUserID();
                    $oneUser = $this->User_model->getOne($user_id);
                    if ($oneUser['is_token']) {
                        $code = substr(strtoupper(md5('EX'.rand(0, time()).'PLUS')), 0, 12);
                        $this->User_model->updateOne($user_id, array('code_login'=>$code));
                        /*set_cookie("CODE_LOGIN", '', time()-3600);
                        if($oneUser['email']) {
                            $this->load->model('Mail_model'); $clsMail = new Mail_model();
                            $html = '<p>Mã đăng nhập của bạn: <span style="color: #c32c2c; font-size: 23px">'.$code.'</span></p>';
                            $clsMail->sendMail($oneUser['email'], 'Mã đăng nhập', $html);
                        }*/
                    }
                        
                    if (isset($_GET['u'])) {
                        redirect($_GET['u']);
                    } else {
                        redirect($_GET['u']);
                    }
                    die();
                }else {
                    $data['msg'] = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><span>Đăng nhập không thành công</span></div>';
                    $this->session->set_flashdata('f_message', 'Sai thông tin tài khoản ');
                    $this->session->set_flashdata('f_type', 'warning');
                }
            // } else {
            //     $data['msg'] = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><span>Đăng nhập không thành công</span></div>';
            //     $this->session->set_flashdata('f_message', 'Đăng nhập không thành công <br/> Google Captcha từ chối đăng nhập');
            //     $this->session->set_flashdata('f_type', 'warning');
            // }
        }
        $this->template->build('backend/standart/login', $data);
    }
    
    public function lock_screen()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $all = $clsUser->getAll("username='".$_COOKIE['USER']."' order by user_id desc limit 1");
        if ($all) {
            $user_id = $all[0];
        } else {
            die('Stoped ...');
        }
        $assign_list['oneUser'] = $clsUser->getOne($user_id);
        if ($this->input->post('user_name') && $this->input->post('user_pass')) {
            if ($clsUser->login($_POST['user_name'], $_POST['user_pass'])) {
                $user_id = $clsUser->getUserID();
                $oneUser = $clsUser->getOne($user_id);
                //if ($oneUser['is_token']) {
//                    $code = substr(strtoupper(md5('EX'.rand(0, time()).'PLUS')), 0, 12);
//                    $clsUser->updateOne($user_id, array('code_login'=>$code));
//                    set_cookie("CODE_LOGIN", '', time()-3600);
//                    if ($oneUser['email']) {
//                        $this->load->model('Mail_model');
//                        $clsMail = new Mail_model();
//                        $html = '<p>Mã đăng nhập của bạn: <span style="color: #c32c2c; font-size: 23px">'.$code.'</span></p>';
//                        $clsMail->sendMail($oneUser['email'], 'Mã đăng nhập', $html);
//                    }
//                }

                redirect($_GET['u']);
                die();
            } else {
                $assign_list['msg'] = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><span>Đăng nhập không thành công</span></div>';
            }
        }
        $this->template->build(current_method()['view'], $assign_list);
    }
    
    public function confirm()
    {
        $this->load->model('User_model');
        $this->load->model('User_model');
        $clsUser = new User_model();
        $data['clsUser'] = $clsUser;
        $user_id = $this->User_model->getUserID();
        if (!$user_id) {
            die('Stoped ...');
        }
        $oneUser = $this->User_model->getOne($user_id);
        $data['oneUser'] = $oneUser;
        $data['msg'] = '';
        if ($this->input->post('code_login')) {
            $code=$this->input->post('code_login');
            $secret=$oneUser['google_auth_code'];
            $this->load->library('GoogleAuthenticator');
            $ga = new GoogleAuthenticator();
            $checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance
            // var_dump($oneUser['username']);
            if ($checkResult) {
                //$_SESSION['googleCode']=$code;
                set_cookie("CODE_LOGIN", '', time()-3600);
                $this->User_model->updateOne($user_id, array('code_login'=>''));
                if ($_GET['u']) {
                    redirect($_GET['u']);
                } else {
                    redirect('home');
                }
            } else {
                $data['msg'] = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button><span>Mã đăng nhập không đúng. Vui lòng thử lại</span></div>';
            }
            /*if($_POST['code_login']==$oneUser['code_login']) {
                $clsUser->updateOne($user_id, array('code_login'=>''));
                if($_GET['u']) header('location: '.$_GET['u']);
                else redirect('/home');
                die();
            }*/
        }
        $this->template->build(current_method()['view'], $data);
    }
    
    public function logout()
    {
        $_SESSION['USER_ID'] = '';
        set_cookie("USER", "", time() - 3600);
        set_cookie("CODE_LOGIN", "", time() - 3600);
        set_cookie("PASS", "", time() - 3600);
        set_cookie("EDITOR", '0', time()+31536000, '/', DOMAIN);
        redirect('/');
        die();
    }
    public function default_comming_soon()
    {
        global $assign_list, $clsSetting;
        $assign_list['comming_date'] = $clsSetting->getCommingDate();
        $assign_list['comming_date'] = '2015-06-19 16:00:00';
    }
    public function addChat()
    {
        if (isset($_GET['token']) && $_GET['token']=='rA7Y2vugZLefWeSkSfv8' && isset($_GET['data'])) {
            $clsChat = new Chat_model();
            $clsRoom = new Room_model();
            $_data = json_decode($_GET['data']);
            if (is_object($_data)) {
                $_data = get_object_vars($_data);
            }

            $room_id = $clsRoom->getID($_data['room'], $_data['from']);
            $clsRoom->updateOne($room_id, array('last_update'=>date('Y-m-d H:i:s'), 'last_message'=>strip_tags($_data['message'])));
            $clsRoom->markUnRead($room_id, explode('_', trim(str_replace('_'.$_data['from'].'_', '_', $_data['room']), '_')));

            $data = array();
            $data['user_id']    = $_data['from'];
            $data['room_id']    = $room_id;
            $data['message']    = $_data['message'];
            $data['reg_date']   = date('Y-m-d H:i:s');

            if (!$data['user_id'] || !$data['room_id'] || !$data['message']) {
                die('0');
            }

            $res = $clsChat->insertOne($data, true, 'CMS');
            if ($res) {
                $clsChat->deleteArrKey('ROOM_'.$data['room_id']);
                $clsChat->deleteArrKey('ROOM_'.$data['room_id'].'_USER_'.$data['user_id']);
                die('1');
            } else {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $clsMail->reportError('Lỗi add chat', false);
                die('0');
            }
        }
        #
        die('0');
    }
    public function setStore()
    {
        $clsStore = new Store_model();
        if ($_POST) {
            if ($_POST['apiUser']==$clsStore->apiUser && $_POST['apiPass']==$clsStore->apiPass) {
                $data['title'] = $_POST['title'];
                $data['reg_date'] = date('Y-m-d H:i:s');
                $data['category_name'] = $_POST['category_name'];
                $data['user_path'] = $_POST['user_path'];
                $data['domain_name'] = $_POST['domain_name'];
                $data['news_id'] = $_POST['news_id'];
                $res = $clsStore->insertOne($data, true, 'CMS');
                if ($res) {
                    die('1');
                } else {
                    die('0');
                }
            } else {
                die('Not found ...');
            }
        } else {
            die('Not found ...');
        }
    }
}
