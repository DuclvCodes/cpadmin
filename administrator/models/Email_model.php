<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Email Model
*| --------------------------------------------------------------------------
*| For Email model
*|
*/
class Email_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'email_id';
        $this->tbl = DB_PREFIX.'email';
    }
    public function getTitle($id, $default_title = 'Không tồn tại')
    {
        if ($id==0) {
            return $default_title;
        }
        $res = $this->getOne($id);
        return $res['title'];
    }
    public function getChild($email_id)
    {
        $res = $this->getAll("parent_id='".$email_id."' order by title", true, 'CMS');
        return $res;
    }
    public function getSelect($name, $value, $class, $title_default=' --- Select --- ', $only_root=false)
    {
        $key = $this->pkey;
        $all = $this->getChild(0);
        $html = '<select name="'.$name.'" class="'.$class.'">';
        if ($title_default) {
            $html .= '<option value="">'.$title_default.'</option>';
        }
        if ($all) {
            foreach ($all as $one) {
                $one=$this->getOne($one);
                $selected = '';
                if ($one[$key]==$value) {
                    $selected = 'selected="selected"';
                }
                $html .= '<option value="'.$one[$key].'" '.$selected.'>'.$one['title'].'</option>';
                if (!$only_root) {
                    $all = $this->getChild($one[$key]);
                    if ($all) {
                        foreach ($all as $one) {
                            $one=$this->getOne($one);
                            $selected = '';
                            if ($one[$key]==$value) {
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option value="'.$one[$key].'" '.$selected.'>&#8866;&#150;&nbsp'.$one['title'].'</option>';
                        }
                    }
                }
            }
        }
        return $html.'</select>';
    }
}
