<?php

/**
*| --------------------------------------------------------------------------
*| Area Model
*| --------------------------------------------------------------------------
*| For area model
*|
*/

class Lichphat_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'lichphat_id';
        $this->tbl = DB_PREFIX.'custom_lichphat';
    }
    public function getTitle($id, $default_title = 'Không tồn tại')
    {
        if ($id==0) {
            return $default_title;
        }
        $res = $this->getOne($id);
        return $res['title'];
    }
    public function getTitlePTime($id)
    {
        if ($id==8) {
            return 'CN';
        } elseif ($id>1) {
            return 'Thứ '.$id;
        } else {
            return 'tuần';
        }
    }
}
