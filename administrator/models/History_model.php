<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| History Model
*| --------------------------------------------------------------------------
*|
*|
*/
class History_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "history_id";
        $this->tbl = DB_PREFIX."news_history";
    }
    public function add($data, $note, $user_id, $is_check=true)
    {
        $news_id = $data['news_id'];
        unset($data['news_id']);
        if ($data && $is_check) {
            unset($data['slug']);
            unset($data['last_edit']);
            $clsNews = new News_model();
            $oneNews = $clsNews->getOne($news_id);
            foreach ($data as $field=>$value) {
                if ($value==$oneNews[$field]) {
                    unset($data[$field]);
                }
            }
        }
        return $this->insertOne(array('news_id'=>$news_id, 'data'=>json_encode($data), 'reg_date'=>date('Y-m-d H:i:s'), 'user_id'=>$user_id, 'title'=>$note), true, 'CMS');
    }
}
