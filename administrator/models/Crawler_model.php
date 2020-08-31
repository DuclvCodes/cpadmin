<?php

class Crawler_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "crawler_id";
        $this->tbl = DB_PREFIX."crawler_config";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    
    public function getByDomain($domain) {
        $res = parent::getParam('domain', $domain);
        if (!$res) {
            return false;
        }
        return $res;
    }
}
