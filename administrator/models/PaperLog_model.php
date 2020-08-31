<?php

/**
*| --------------------------------------------------------------------------
*| PaperLog Model
*| --------------------------------------------------------------------------
*| For paperLog model
*|
*/

class PaperLog_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "log_id";
        $this->tbl = "paper_log";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
}
