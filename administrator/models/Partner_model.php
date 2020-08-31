<?php

/**
*| --------------------------------------------------------------------------
*| Partner Model
*| --------------------------------------------------------------------------
*| For partner model
*|
*/

class Partner_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'partner_id';
        $this->tbl = DB_PREFIX.'partner';
    }
    public function getTitle($id, $default_title = 'Không tồn tại')
    {
        if ($id==0) {
            return $default_title;
        }
        $res = $this->getOne($id);
        return $res['title'];
    }
}
