<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tag Model
*| --------------------------------------------------------------------------
*|
*|
*/
class Tag_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'tag_id';
        $this->tbl = DB_PREFIX.'tag';
    }
    public function getTitle($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getLink($_id, $one=null)
    {
        if (!$one) {
            $one = $this->getOne($_id);
        }
        $slug = $one['slug'];
        return PCMS_URL.'/'.$slug.'-tag'.$_id.'/';
    }
    public function stringToPathID($tags)
    {
        $tags = trim($tags);
        $tags = trim($tags, ',');
        if (!$tags) {
            return false;
        }
        $arr = explode(',', $tags);
        if (!$arr) {
            return false;
        }
        $res = array();
        if ($arr) {
            foreach ($arr as $title) {
                $title = trim($title);
                $slug = toSlug($title);
                $tag_id = $this->slugToID($slug);
                if (!$tag_id) {
                    $r = $this->insertOne(array('title'=>$title, 'slug'=>$slug));
                    if ($r) {
                        $this->deleteArrKey('CMS');
                        $tag_id = $this->getMaxID('CMS');
                    }
                }
                if (!$tag_id) {
                    $this->load->model('Mail_model');
                    $clsMail = new Mail_model();
                    $msg = $clsMail->reportError('Lỗi chèn tag vào database (tag_id not found)');
                }
                $res[$tag_id] = $tag_id;
            }
        }
        return arrayToPath($res);
    }
    public function pickToContent($content)
    {
        #
        $this->load->helper('simple_html_dom');
        $html = str_get_html($content);
        $i = 0;
        $data = array();
        if ($html) {
            foreach ($html->find('a') as $e) {
                $i++;
                $str = $e->outertext;
                $data[$i] = $str;
                $e->outertext = 'azz_'.$i.'_exp';
            }
        }
        if ($html) {
            foreach ($html->find('img') as $e) {
                $i++;
                $str = $e->outertext;
                $data[$i] = $str;
                $e->outertext = 'azz_'.$i.'_exp';
            }
        }
        #
        $content = $html->outertext;
        $all = $this->getAll('is_trash=0 and is_pick=1 order by tag_id desc limit 999', true, 'PICK');
        $count_ok = 0;
        if ($all) {
            foreach ($all as $id) {
                $one = $this->getOne($id);
                $title = $one['title'];
                if (stripos($content, $title)) {
                    $i++;
                    $count_ok++;
                    $content = str_replace($title, 'azz_'.$i.'_exp', $content);
                    $data[$i] = '<a class="autotag" title="'.$title.'" href="'.$this->getLink($id).'">'.$title.'</a>';
                }
                $title = ucfirst($title);
                if (stripos($content, $title)) {
                    $i++;
                    $count_ok++;
                    $content = str_replace($title, 'azz_'.$i.'_exp', $content);
                    $data[$i] = '<a class="autotag" title="'.$title.'" href="'.$this->getLink($id).'">'.$title.'</a>';
                }
                if ($count_ok>=3) {
                    break;
                }
            }
        }
        if ($data) {
            foreach ($data as $key=>$one) {
                $content = str_replace('azz_'.$key.'_exp', $one, $content);
            }
        }
        return $content;
    }
}
