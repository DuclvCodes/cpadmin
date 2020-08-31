<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Source Model
*| --------------------------------------------------------------------------
*|
*|
*/
class Source_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "source_id";
        $this->tbl = DB_PREFIX."source";
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return DOMAIN_NAME;
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getLink($source_id, $type=0)
    {
        if (!$source_id) {
            return '#';
        }
        $res = $this->getOne($source_id);
        return PCMS_URL.'/'.$res['slug']."-source".$source_id."/";
    }
    public function getByDomain($domain) {
        $res = parent::getParam('domain', $domain);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public function getSelect($name, $value, $class, $is_multiple=false, $title_default=' --- Chọn --- ')
    {
        $all = $this->getAll('is_trash=0 order by title limit 2000', true, 'CMS');
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
                $html .= '<option value="'.$one[$this->pkey].'" '.$selected.'>'.$one['title'].'</option>';
            }
        }
        return $html.'</select>';
    }
}
