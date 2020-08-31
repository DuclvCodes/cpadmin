<?php
class Library_model extends MY_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->pkey = 'library_id';
        $this->tbl = DB_PREFIX.'library';
    }
    public function getAllCate()
    {
        $res = array();
        $res[] = 'Pháp luật Việt Nam';
        $res[] = 'Pháp luật & Thời đại';
        $res[] = 'Câu chuyện Pháp luật';
        $res[] = 'Xa lộ Pháp luật';
        $res[] = 'Doanh nhân & Pháp luật';
        $res[] = 'Pháp luật bốn phương';
        return $res;
    }
    public function getTitleCate($cate_id)
    {
        if (!$cate_id) {
            $cate_id = 0;
        }
        $all = $this->getAllCate();
        return $all[$cate_id];
    }
    public function getLink($id)
    {
        $res = $this->getOne($id);
        return $link = PCMS_URL.'/'.toSlug($this->getTitleCate($res['category_id'])).'-so-'.$res['slug'].'-i'.$id.'.html';
    }
    public function getTitle($id)
    {
        $res = $this->getOne($id);
        if (!$res) {
            return 'Bài viết không tồn tại hoặc đã xóa';
        }
        return $res['title'];
    }
    public function getLinkTitle($id, $one=null, $class=null, $tag='h2')
    {
        if (!$one) {
            $one = $this->getOne($id);
        }
        $link = $this->getLink($id, $one);
        $title = $this->getTitle($id, $one);
        return '<'.$tag.'><a href="'.$link.'" class="'.$class.'" title="'.str_replace('"', '\'', $title).'">'.$title.'</a></'.$tag.'>';
    }
    public function getLinkImage($id, $width, $height, $one=null, $class=null, $class_img=null)
    {
        if (!$one) {
            $one = $this->getOne($id);
        }
        $link = $this->getLink($id, $one);
        $title = $this->getTitle($id, $one);
        $img = $this->getImage($id, $width, $height, 'image', null, $one);
        return '<a href="'.$link.'" class="'.$class.'" title="'.str_replace('"', '\'', $title).'" ><img class="'.$class_img.'" src="'.$img.'" width="'.$width.'" height="'.$height.'" alt="'.str_replace('"', '\'', $title).'" /></a>';
    }
}
