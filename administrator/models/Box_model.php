<?php

class Box_model extends MY_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->pkey = "box_id";
        $this->tbl = DB_PREFIX."box";
    }
    
    public function getBoxBySlug($slug)
    {
        $res = parent::getParam('slug', $slug);
        if (!$res) {
            return false;
        }
        return $res;
    }
    
    public function getBoxByID($id)
    {
        $res = parent::getOne($id);
        if (!$res) {
            return false;
        }
        return $res;
    }
    
    public function getBoxByCategoryID($catID)
    {
        $res = parent::getParam('category_id', $catID);
        if (!$res) {
            return false;
        }
        return $res;
    }
    
    public function getTitle($_id)
    {
        if (!$_id) {
            return 'error1';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function checkTimer($box_id)
    {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $time = time();
        $one = $this->getOne($box_id);
        if (!$one) {
            return false;
        }
        $allNews = pathToArray($one['news_path']);
        $news_path_timer = array();
        if ($allNews) {
            foreach ($allNews as $key=>$news_id) {
                $oneNews = $clsNews->getOne($news_id);
                $push_date = strtotime($oneNews['push_date']);
                if ($push_date>$time) {
                    $news_path_timer[] = $news_id.':'.$push_date;
                    unset($allNews[$key]);
                }
            }
        }
        if ($news_path_timer) {
            krsort($news_path_timer);
            $this->deleteArrKey('BOX');
            return $this->updateOne($box_id, array('news_path_timer'=> arrayToPath($news_path_timer), 'news_path_show'=> arrayToPath($allNews)));
        } else {
            return false;
        }
    }
    public function checkTimerFromNews($news_id)
    {
        $all = $this->getAll("news_path like '%|".$news_id."|%'", true, 'GET_NEWS');
        if ($all) {
            foreach ($all as $box_id) {
                $this->checkTimer($box_id);
            }
        }
        return true;
    }
    public function getIDFromCat($cat_id)
    {
        $all = $this->getAll('is_trash=0 and category_id='.$cat_id.' order by box_id desc limit 1', true, 'CMS');
        if ($all) {
            return $all[0];
        } else {
            return false;
        }
    }
    public function getListBoxByNewsId($news_id)
    {
        $all = $this->getAll("news_path like '%|".$news_id."|%'", true, 'GET_NEWS');
        return $all;
    }
    public function hasNews($box_id, $news_id)
    {
        $oneBox = $this->getOne($box_id);
        if (!$oneBox) {
            return false;
        }
        $allNews = pathToArray($oneBox['news_path']);
        return in_array($news_id, $allNews);
    }
    public function removeNews($news_id, $box_array = null)
    {
        if (!$box_array) {
            $box_array = $this->getAll("news_path like '%|".$news_id."|%'", true, 'GET_NEWS');
        }
        if ($box_array) {
            foreach ($box_array as $box_id) {
                $oneBox = $this->getOne($box_id);
                $news_path = $oneBox['news_path'];
                $news_path = str_replace('|'.$news_id.'|', '|', $news_path);
                $news_path_show = $oneBox['news_path_show'];
                $news_path_show = str_replace('|'.$news_id.'|', '|', $news_path_show);
                $this->updateOne($box_id, array('news_path'=>$news_path, 'news_path_show'=>$news_path_show));
                //delete key param BOX
                $this->deleteArrKey('BOX');
                $this->updateParam('slug', $oneBox['slug']);
            }
        }
        return true;
    }
    public function addNews($box_id, $news_id)
    {
        if (!$box_id) {
            return false;
        }
        $oneBox = $this->getOne($box_id);
        if (!$oneBox) {
            return false;
        }
        $news_path = $oneBox['news_path'];
        $news_path = str_replace('|'.$news_id.'|', '|', $news_path);
        if (!$news_path) {
            $news_path = '|';
        }
        $news_path = '|'.$news_id.$news_path;
        
        $allNews = pathToArray($news_path);
        if ($allNews) {
            $allNews = array_splice($allNews, 0, (max($oneBox['count_item'], $oneBox['count_item_2'])+MAX_TIMERNEWS));
        }
        $news_path = arrayToPath($allNews);
        unset($allNews);
        
        $this->updateOne($box_id, array('news_path'=>$news_path, 'news_path_show'=>$news_path));
        unset($news_path);
        $this->deleteArrKey('BOX');
        //delete key param BOX
        $this->updateParam('slug', $oneBox['slug']);
        $this->checkTimer($box_id);
        return true;
    }
}
