<?php

/**
*| --------------------------------------------------------------------------
*| PaperHistory Model
*| --------------------------------------------------------------------------
*| For paperHistory model
*|
*/

class PaperHistory_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "history_id";
        $this->tbl = "paper_history";
    }
    public function add($data, $note, $user_id, $is_check=true)
    {
        $news_id = $data['paper_id'];
        unset($data['paper_id']);
        if ($data && $is_check) {
            unset($data['slug']);
            unset($data['last_edit']);
            $clsNews = new Paper();
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
