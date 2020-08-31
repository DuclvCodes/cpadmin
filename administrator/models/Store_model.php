<?php

/**
*| --------------------------------------------------------------------------
*| Store Model
*| --------------------------------------------------------------------------
*| For store model
*|
*/

class Store_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "store_id";
        $this->tbl = DB_PREFIX."store";
        $this->apiUser = "http://cms.phapluatplus.vn";
        $this->apiPass = "dBPhAwqK8TNn";
    }
    public function getAllDomain()
    {
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            return false;
        }
        $data = $this->getCurl('http://www.phapluatplus.vn/api', array('user_id'=>$user_id, 'apiUser'=>$this->apiUser, 'apiPass'=>$this->apiPass));
        if ($data=='Not found ...') {
            die($data);
        }
        $data = json_decode($data);
        return $data;
    }
    public function setDomain($category_path)
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $user_id = $clsUser->getUserID();
        if (!$user_id) {
            return false;
        }
        $data = $this->getCurl('http://www.phapluatplus.vn/api', array('user_id'=>$user_id, 'apiUser'=>$this->apiUser, 'apiPass'=>$this->apiPass, 'category_path'=>$category_path));
        if ($data=='1') {
            return true;
        } else {
            return $data;
        }
    }
    
    public function getCurl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return $server_output;
    }
}
