<?php
class Category_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "category_id";
        $this->tbl = DB_PREFIX."category";

        parent::__construct();
    }
    
    public function getViews($category_id, $field='views_day')
    {
        $clsNews = new News_model();
        return $clsNews->getSum($field, $clsNews->getCons($category_id));
    }
    public function getTitle($id, $default_title = 'Danh mục gốc')
    {
        if ($id==0) {
            return $default_title;
        }
        $res = $this->getOne($id);
        return $res['title'];
    }
    public function getParentID($cat)
    {
        $res=$this->getOne($cat);
        return $res['parent_id'];
    }
    public function getSlugById($slug)
    {
        $res = $this->getParam('slug', $slug);
        if ($res) {
            return $res['id'];
        } else {
            return false;
        }
    }
    
    public function getLink($id)
    {
        $this->load->helper('url');
        $res = $this->getOne($id);
        $link = base_url($res['slug'].'.htm');
        return $link;
    }
    public function getSlug($id)
    {
        $res = $this->getOne($id);
        if ($this->getCategoryRoot($id) == 0) {
            return $res;
        } else {
            return $res;
        }
    }
    public function getLinkRSS($Id)
    {
        $this->load->helper('url');
        $res = $this->getOne($Id);
        $slug = $res['slug'];
        return base_url($slug).".rss";
    }
    public function countChild($id)
    {
        $res = $this->getCount('is_trash=0 and parent_id='.$id, true, 'CMS');
        return $res;
    }
    public function countNews($id)
    {
        $clsNews = new News_model();
        $res = $clsNews->getCount('(category_id in(SELECT category_id FROM default_category WHERE parent_id='.$id.') or category_id='.$id.')');
        return $res;
    }
    public function getSelect($name, $value, $class, $is_multiple=false, $title_default=' --- Select --- ', $only_root=false)
    {
        $all = $this->getChild(0);
        $html = '<select name="'.$name.'" class="'.$class.'">';
        if ($title_default) {
            $html .= '<option value="">'.$title_default.'</option>';
        }
        if ($all) {
            foreach ($all as $one) {
                $one=$this->getOne($one);
                $selected = '';
                if ($one['category_id']==$value) {
                    $selected = 'selected="selected"';
                }
                $html .= '<option value="'.$one['category_id'].'" '.$selected.'>'.$one['title'].'</option>';
                if (!$only_root) {
                    $all = $this->getChild($one['category_id']);
                    if ($all) {
                        foreach ($all as $one) {
                            $one=$this->getOne($one);
                            $selected = '';
                            if ($one['category_id']==$value) {
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option value="'.$one['category_id'].'" '.$selected.'>&#8866;&#150;&nbsp'.$one['title'].'</option>';
                        }
                    }
                }
            }
        }
        return $html.'</select>';
    }
    public function getSelectGroup($name, $value, $class, $is_multiple=false, $title_default=' --- Select --- ')
    {
        $all = $this->getChild(0);
        $html = '<select name="'.$name.'" class="'.$class.'">';
        if ($title_default) {
            $html .= '<option value="">'.$title_default.'</option>';
        }
        if ($all) {
            foreach ($all as $one) {
                $one=$this->getOne($one);
                $selected = '';
                if ($one['category_id']==$value) {
                    $selected = 'selected="selected"';
                }
                $all = $this->getChild($one['category_id']);
                if ($all) {
                    $html .= '<optgroup label="'.$one['title'].'">';
                    foreach ($all as $one) {
                        $one=$this->getOne($one);
                        $selected = '';
                        if ($one['category_id']==$value) {
                            $selected = 'selected="selected"';
                        }
                        $html .= '<option value="'.$one['category_id'].'" '.$selected.'>&#8866;&#150;&nbsp'.$one['title'].'</option>';
                    }
                    $html .= '</optgroup>';
                }
            }
        }
        return $html.'</select>';
    }
    public function getChild($category_id, $show_all = true)
    {
        $cons = "is_trash=0 and parent_id='".$category_id."'";
        if (!$show_all) {
            $cons .= " and order_no>0";
        }
        $res = $this->getAll($cons." order by order_no", true, 'CMS');
        return $res;
    }
    public function getCategoryRoot($category_id)
    {
        if ($category_id) {
            return $this->getParentID($category_id);
        } else {
            return false;
        }
    }
    
    public function getAllCatFromRoot($category_id)
    {
        $allCat = $this->getChild($category_id);
        $allCat[] = $category_id;
        return $allCat;
    }
}
