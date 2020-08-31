<?php

/**
*| --------------------------------------------------------------------------
*| Pack Model
*| --------------------------------------------------------------------------
*| For pack model
*|
*/

class Pack_model extends MY_Model
{
    public function __construct($pack=2)
    {
        parent::__construct();
        $this->pkey = 'news_id';
        $this->tbl = 'news_pack_'.$pack;
    }
    public function getLink($news_id, $oneNews=null)
    {
        $clsCategory = new Category_model();
        if (!$oneNews) {
            $oneNews = $this->getOne($news_id);
        }
        $slug = $oneNews['slug'];
        $link = PCMS_URL.'/'.$slug."-d".$news_id.".html";
        if (in_array($oneNews['category_id'], $clsCategory->getAllCatFromRoot(ATGT))) {
            $link = RCMS_URL.'/'.$slug."-d".$news_id.".html";
        }
        if ($oneNews['is_photo'] || $oneNews['is_video']) {
            $link = PCMS_URL.'/'.$slug."-av".$news_id.".html";
        }
        return $link;
    }
}
