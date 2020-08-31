<?php
class Signature_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "signature_id";
        $this->tbl = DB_PREFIX."signature";
    }
    public function getTitle($id)
    {
        $res = $this->getOne($id);
        return $res['title'];
    }
    public function getSelect($name, $value, $class, $user_id=0, $title_default=' --- Chọn --- ')
    {
        $cons = "is_trash=0";
        if (!$user_id) {
            $this->load->model('User_model');
            $clsUser = new User_model();
            $user_id = $clsUser->getUserID();
        }
        if ($user_id) {
            $cons .= " and user_id='".$user_id."'";
        }
        $all = $this->getAll($cons." order by signature_id desc limit 100", true, 'CMS');
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
