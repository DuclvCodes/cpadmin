<?php

class Tienich_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "tienich_id";
        $this->tbl = DB_PREFIX."tienich";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    
    public function getBySlug($slug) {
        $res = parent::getParam('slug', $slug);
        if (!$res) {
            return false;
        }
        return $res;
    }
}
