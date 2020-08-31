<?php

class Chat_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "chat_id";
        $this->tbl = DB_PREFIX."system_chat";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function countNoti($me_id, $user_id)
    {
        return $this->getCount("from_user_id='".$user_id."' and to_user_id='".$me_id."' and is_viewed=0", true, 'COUNT_'.$me_id.'_'.$user_id);
    }
    public function sendMessenger($user_id, $messenger)
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $data = array();
        $data['title'] = $messenger;
        $data['reg_date'] = date('Y-m-d H:i:s');
        $data['from_user_id'] = $clsUser->getUserID();
        $data['to_user_id'] = $user_id;
        $res = $this->insertOne($data, true, $data['from_user_id'].'_'.$data['to_user_id']);
        if ($res) {
            $this->deleteArrKey($data['to_user_id'].'_'.$data['from_user_id']);
            $this->deleteArrKey('COUNT_'.$data['to_user_id'].'_'.$data['from_user_id']);
            $this->deleteArrKey('CMS');
        }
        return $res;
    }
}
