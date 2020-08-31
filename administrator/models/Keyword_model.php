<?php

/**
*| --------------------------------------------------------------------------
*| Keyword Model
*| --------------------------------------------------------------------------
*| For keyword model
*|
*/

class Keyword_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "keyword_id";
        $this->tbl = DB_PREFIX."keyword";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getLink($_id, $type=0)
    {
        if (!$_id) {
            return '#';
        }
        $res = $this->getOne($_id);
        return PCMS_URL.'/'.$res['title'].'-tag/';
    }
}
