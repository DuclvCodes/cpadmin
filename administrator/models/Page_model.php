<?php

/**
*| --------------------------------------------------------------------------
*| Page Model
*| --------------------------------------------------------------------------
*| For page model
*|
*/

class Page_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'page_id';
        $this->tbl = DB_PREFIX.'page';
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getLink($_id)
    {
        $res = $this->getOne($_id);
        return PCMS_URL.'/'.$res['slug'].'-p'.$_id.'.html';
    }
}
