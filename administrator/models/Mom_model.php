<?php

/**
*| --------------------------------------------------------------------------
*| Mom Model
*| --------------------------------------------------------------------------
*| For mom model
*|
*/

class Mom_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "mom_id";
        $this->tbl = DB_PREFIX."mom";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return false;
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
}
