<?php

/**
*| --------------------------------------------------------------------------
*| Video Model
*| --------------------------------------------------------------------------
*| For video model
*|
*/

class Video_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "video_id";
        $this->tbl = DB_PREFIX."video";
        $this->files = array('image', 'file', 'file_240', 'file_360', 'file_480', 'file_720');
    }
    public function getAttr($video, $ffmpeg='ffmpeg')
    {
        $command = $ffmpeg . ' -i ' . $video . ' -vstats 2>&1';
        $output = shell_exec($command);
        if (preg_match("/Video: (.*) ([0-9]{1,4})x([0-9]{1,4})/", $output, $regs)) {
            $width = $regs [2] ? $regs [2] : null;
            $height = $regs [3] ? $regs [3] : null;
        }
        if (preg_match("/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $output, $regs)) {
            $hours = $regs [1] ? $regs [1] : null;
            $mins = $regs [2] ? $regs [2] : null;
            $secs = $regs [3] ? $regs [3] : null;
        }
        return array('width' => $width, 'height' => $height, 'hours' => $hours, 'mins' => $mins, 'secs' => $secs);
    }
    public function getID($news_id)
    {
        $all = $this->getAll('news_id='.$news_id.' order by video_id desc limit 1', true, 'CMS');
        if ($all) {
            return $all[0];
        } else {
            return false;
        }
    }
    public function getLinkPlayer($path)
    {
        $secret = 'tkp_1480';
        $expire = time()+86400;
        $md5 = str_replace('=', '', strtr(base64_encode(md5($secret.$path.$expire, true)), '+/', '-_'));
        return MEDIA_DOMAIN.$path.'?st='.$md5.'&e='.$expire;
    }
    public function getEmbed($id) {
        return '<iframe class="tkp_video" src="https://'.DOMAIN.'/watch/'.$id.'" frameborder="" width="100%" height="450" allowfullscreen="true"></iframe>';
    }
    public function is_optimizing($id, $one)
    {
        if (!$one) {
            $one = $this->getOne($id);
        }
        if ($one['width']>=426 && $one['height']>=240) {
            if ($one['file_240'] || $one['file_360'] || $one['file_480'] || $one['file_720']) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
