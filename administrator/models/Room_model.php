<?php

/**
*| --------------------------------------------------------------------------
*| Room Model
*| --------------------------------------------------------------------------
*| For room model
*|
*/

class Room_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "room_id";
        $this->tbl = DB_PREFIX."chat_room";
    }
    public function getID($title, $create_by=null)
    {
        $all = $this->getAll("title='".$title."' limit 1", true, 'CMS');
        if ($all) {
            return $all[0];
        } elseif ($create_by) {
            $data = array('title'=>$title, 'user_path'=>$title, 'user_id'=>$create_by);
            $allUser = explode('_', trim($title, '_'));
            if (count($allUser)>2) {
                $data['is_multi'] = 1;
            }
            $this->insertOne($data, true, 'CMS');
            if ($allUser) {
                foreach ($allUser as $user_id) {
                    $this->deleteArrKey('USER_'.$user_id);
                }
            }
            $maxId = $this->getMaxID('CMS');
            return $maxId;
        } else {
            return false;
        }
    }
    public function getRoomName($room_id)
    {
        $clsUser = new User_model();
        $me_id = $clsUser->getUserID();
        $one = $this->getOne($room_id);
        $all_user = explode('_', trim(str_replace('_'.$me_id.'_', '_', $one['user_path']), '_'));
        $res = '';
        if ($all_user) {
            foreach ($all_user as $key=>$user_id) {
                $res .= ', '.$clsUser->getLashName($user_id);
                unset($all_user[$key]);
                if ($key==1) {
                    $count = count($all_user);
                    if ($count>0) {
                        $res .= ', +'.$count;
                    }
                    break;
                }
            }
        }
        return ltrim($res, ', ');
    }
    public function markUnRead($room_id, $allUser)
    {
        $clsUser = new User_model();
        if ($allUser) {
            foreach ($allUser as $user_id) {
                $one = $clsUser->getOne($user_id);
                $chat_read = json_decode($one['chat_read']);
                if (is_object($chat_read)) {
                    $chat_read = get_object_vars($chat_read);
                }
                $chat_read[$room_id]++;
                $clsUser->updateOne($user_id, array('chat_read'=>json_encode($chat_read)));
            }
        }
    }
}
