<?php

/**
*| --------------------------------------------------------------------------
*| Comment Model
*| --------------------------------------------------------------------------
*| For comment model
*|
*/

class Comment_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    
        $this->pkey = 'comment_id';
        $this->tbl = DB_PREFIX.'comment';
    }
    public function syncChild($id)
    {
        $one = $this->getOne($id);
        $all = $this->getAll('push_by>0 and parent_id='.$id.' order by push_date desc', true, 'URL_'.$one['url_id']);
        if ($all) {
            $this->updateOne($id, array('child_path'=>implode('|', $all)));
        } else {
            return false;
        }
    }
    public function countComment($url)
    {
        return 0;
        $clsUrl = new Url_model();
        $url_id = $clsUrl->getID($url, false);
        if ($url_id) {
            return $this->getCount('url_id='.$url_id, true, 'URL_'.$url_id);
        } else {
            return 0;
        }
    }
}
