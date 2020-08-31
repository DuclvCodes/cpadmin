<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "log_id";
        $this->tbl = DB_PREFIX."system_log";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    //get last log by news_id
    public function getLastLogNews($news_id)
    {
        if (!$news_id) {
            return '';
        }
        $allLog = $this->getAll("news_id='".$news_id."' order by log_id", false, 'list_news_'.$news_id);
        if (!$allLog) {
            return '';
        }
        return $this->getTitle(end($allLog));
    }
}
