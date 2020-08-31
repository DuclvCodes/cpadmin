<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once APPPATH . '/libraries/GoogleAuthenticator.php';
class Xacthuc2buoc_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey  = "user_id";
        $this->tbl   = DB_PREFIX."system_user";
    }
    /* User Login */
    public function userLogin($user_name, $user_pass, $secret)
    {
        $user_name = addslashes($user_name);
        $user_pass = md5(addslashes($user_pass));
        $all       = $this->getAll("is_trash=0 and username='" . $user_name . "' and password='" . $user_pass . "' order by user_id desc limit 1", true, 'login_' . $user_name);
        $all_2       = $this->getAll("is_trash=0 and email='" . $user_name . "' and password='" . $user_pass . "' order by user_id desc limit 1", true, 'login_' . $user_name);

        if ($all or $all_2) {
            if ($all) {
                $user_login = $all[0];
            } else {
                $user_login = $all2[0];
            }
            $data = $this->getOne($user_login);
            if (!$data['google_auth_code']) {
                //$this->load->libraries('Google/GoogleAuthenticator');
                $ga = new GoogleAuthenticator();
                $secret = $ga->createSecret();
                $user_update_auth['auth_code'] = $secret;
                $this->updateOne($data['user_id'], $user_update_auth);
            }
            $_SESSION['auth_uid']=$data['user_id'];
            $_SESSION['auth_code']=$user_update_auth['auth_code'];
            return $data['user_id'];
        } else {
            return false;
        }
    }

    /* User Details */
    public function userDetails($uid)
    {
        try {
            $data = $this->getOne($uid);
            return $data;
        } catch (PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}
