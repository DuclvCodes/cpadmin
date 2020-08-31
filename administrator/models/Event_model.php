<?php
class Event_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "event_id";
        $this->tbl = DB_PREFIX."event";
        $this->files = array('image', 'cover');
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getLink($_id, $type=0)
    {
        if (!$_id) {
            return '#';
        }
        $res = $this->getOne($_id);
        return PCMS_URL.'/'.$res['slug']."-event".$_id."/";
    }
    public function getSelect($name, $value, $class, $is_multiple=false, $title_default=' --- Select --- ')
    {
        $all = $this->getAll('is_trash=0 order by event_id desc limit 100', true, 'CMS');
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
    public function getEventImage($_id, $w, $h)
    {
        $res = $this->getOne($_id);
        $image = trim($res['image']);
        if (!$image) {
            $image=PCMS_URL.'/upload/nophoto.jpg';
        }
        if (substr($image, 0, 4)=='http') {
            return $image;
        } elseif (substr($image, 0, 1)=='/') {
            $image = PCMS_URL.$image;
        } else {
            $image = PCMS_URL.'/upload/'.$image;
        }
        return '/photos/'.$w.'x'.$h.''.$image;
    }
}
