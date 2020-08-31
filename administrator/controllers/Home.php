<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Home extends Admin
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
        $this->load->model('User_model');
        $clsUser = new User_model();
        $data['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $data['me'] = $me;
        
        #
        if ($clsUser->permission('home')) {
            $data['ga'] = $this->cache->get(MEMCACHE_NAME.'GOOGLE_ANALYTICS');
            $data['realtime'] = $this->cache->get(MEMCACHE_NAME.'RIGHT_NOW');
            $data['visits'] = $this->cache->get(MEMCACHE_NAME.'SITE_VISITS');
        }
//        if($me['group_id']==5) {
//            $this->load->model('System_model');
//            $clsSystem = new System_model();
//            $clsSystem_M = new System_model('MEDIA');
//            $clsSystem_D = new System_model('DATA');
//            $assign_list['sysinfo'] = $clsSystem->getInfoServer();
//            $assign_list['syshdd'] = $clsSystem->getHDD(0);
//            $assign_list['sysbw'] = $clsSystem->limit_bw;
//            $assign_list['M_sysinfo'] = $clsSystem_M->getInfo();
//            $assign_list['M_syshdd'] = $clsSystem_M->getHDD(0);
//            $assign_list['M_sysbw'] = $clsSystem_M->limit_bw;
//            $assign_list['D_sysinfo'] = $clsSystem_D->getInfo();
//            $assign_list['D_syshdd'] = $clsSystem_D->getHDD(0);
//            $assign_list['D_sysbw'] = $clsSystem_D->limit_bw;
//        }
        #
        /*=============Title & Description Page==================*/
        $data['title_page'] = "Bảng điều khiển";
        $data['mod'] = 'home';
        $this->render('backend/standart/administrator/home', $data);
    }
}
