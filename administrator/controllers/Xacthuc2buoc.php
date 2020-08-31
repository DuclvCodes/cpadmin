<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/

require_once APPPATH . '/libraries/GoogleAuthenticator.php';
class Xacthuc2buoc extends Admin
{
    public $session_uid = '';
    public $session_googleCode = '';
    public function __construct()
    {
        parent::__construct();
        if (!empty($_SESSION['auth_uid']) && !empty($_SESSION['googleCode'])) {
            $this->session_uid=$_SESSION['auth_uid'];
            $this->session_googleCode=$_SESSION['auth_code'];
        }

        if (empty($this->session_uid) && empty($this->session_googleCode)) {
            //redirect('/xacthuc2buoc/login');
        }
    }
    public function index()
    {
        if (!empty($_SESSION['auth_uid'])) {
            redirect("/xacthuc2buoc/login/");
        }
        
        $this->load->view('/backend/standart/xacthuc2buoc/index', $data);
    }
    
    public function login()
    {
        $this->load->model('Xacthuc2buoc_model');
        $userClass = new Xacthuc2buoc_model();
        
        //$this->load->libraries('Google/GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        
        $data['errorMsgReg']='';
        $data['errorMsgLogin']='';
        if (!empty($_POST['loginSubmit'])) {
            $usernameEmail=$_POST['usernameEmail'];
            $password=$_POST['password'];
            if (strlen(trim($usernameEmail))>1 && strlen(trim($password))>1) {
                $uid=$userClass->userLogin($usernameEmail, $password, $secret);
                if ($uid) {
                    redirect("/xacthuc2buoc/confirm");
                } else {
                    $data['errorMsgLogin']="Please check login details.";
                }
            }
        }
        $this->load->view('/backend/standart/xacthuc2buoc/index', $data);
    }
    
    public function confirm()
    {
        if (empty($_SESSION['auth_uid'])) {
            redirect("/xacthuc2buoc/");
        }
        
        $this->load->model('Xacthuc2buoc_model');
        $userClass = new Xacthuc2buoc_model();
        $userDetails=$userClass->userDetails($_SESSION['auth_uid']);
        $secret=$userDetails['google_auth_code'];
        $email=$userDetails['email'];
        //$this->load->libraries('Google/GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        if ($_POST['code']) {
            $code=$_POST['code'];
            $secret=$userDetails['google_auth_code'];
            $checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance
            
            if ($checkResult) {
                $_SESSION['googleCode']=$code;
                redirect('/xacthuc2buoc/thanhcong');
            } else {
                echo 'FAILED';
            }
        }
        $data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($email, $secret, DOMAIN_NAME);
        $this->load->view('/backend/standart/xacthuc2buoc/confirm', $data);
    }
    
    public function thanhcong()
    {
        $this->load->model('Xacthuc2buoc_model');
        $userClass = new Xacthuc2buoc_model();
        $userDetails=$userClass->userDetails($_SESSION['auth_uid']);
        if ($userDetails) {
            $data['userDetails']=$userDetails;
        } else {
            redirect('/xacthuc2buoc/login');
        }
        $this->load->view('/backend/standart/xacthuc2buoc/thanhcong', $data);
    }
    
    public function logout()
    {
        $this->session_uid='';
        $this->session_googleCode='';
        $_SESSION['auth_uid']='';
        $_SESSION['auth_code']='';
        if (empty($this->session_uid) && empty($_SESSION['auth_uid'])) {
            redirect('/xacthuc2buoc/');
        }
    }
}
