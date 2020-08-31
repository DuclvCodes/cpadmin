<?php

/**
*| --------------------------------------------------------------------------
*| Group Model
*| --------------------------------------------------------------------------
*| For group model
*|
*/

class Group_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "group_id";
        $this->tbl = DB_PREFIX."system_group";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return 'Administrator';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getSelect($name, $value, $class, $is_multiple=false, $title_default=' --- Select --- ')
    {
        $all = $this->getAll('is_trash=0 order by title limit 100', true, 'CMS');
        $html = '<select name="'.$name.'" class="'.$class.'">';
        if ($title_default) {
            if ($value) {
                $html .= '<option value="0">'.$title_default.'</option>';
            } else {
                $html .= '<option value="0" selected="selected">'.$title_default.'</option>';
            }
        }
        if ($all) {
            foreach ($all as $one) {
                $one=$this->getOne($one);
                $selected = '';
                if ($one[$this->pkey]==$value) {
                    $selected = 'selected="selected"';
                }
                $html .= '<option data-level="'.$one['level'].'" data-permission=\''.$one['permission'].'\' value="'.$one[$this->pkey].'" '.$selected.'>'.$one['title'].'</option>';
            }
        }
        return $html.'</select>';
    }
    public function getLevel($_id)
    {
        if (!$_id) {
            return 4;
        }
        $res = $this->getOne($_id);
        return $res['level'];
    }
}
