<?php

/**
*| --------------------------------------------------------------------------
*| Ads Model
*| --------------------------------------------------------------------------
*| For ads model
*|
*/

class Ads_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "ads_id";
        $this->tbl = DB_PREFIX."ads";

        parent::__construct();
    }
    
    public function getAllAds()
    {
        $allAds = $this->getAll('1=1', true, 'CMS');
        if ($allAds) {
            foreach ($allAds as $ads_id) {
                $ads[$ads_id] = $this->getContent($ads_id);
            }
        }
        return $ads;
    }
    public function getTitle($_id)
    {
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getContent($id, $cat_id=0)
    {
        $one = $this->getOne($id);
        if (isset($_GET['show']) && $_GET['show']=='ads') {
            if (!$one['width']) {
                $one['width'] = 200;
            }
            if (!$one['height']) {
                $one['height'] = 200;
            }
            $content = '<span style="display:block;color:#FFF;font-size:21px;padding:8px 0;">'.$one['title'].'</span>';
            $content .= '<span style="display:block;color:#FFF">'.$one['width'].' x '.$one['height'].'</span>';
            $content = '<a href="http://'.ADMIN_DOMAIN.'/ads/edit?id='.$id.'" target="_blank" style="background:#ed4e2a;color:#FFF;width:'.$one['width'].'px;height:'.$one['height'].'px;text-align:center;align-content:inherit;display:block;">'.$content.'</a>';
            return $content;
        }
        if ($cat_id) {
            $clsArea = new Area_model();
            $area_id = $clsArea->getOneArea($id, $cat_id);
            if ($area_id) {
                return $clsArea->getContent($area_id);
            }
        }
        if (!$one['is_show']) {
            return '';
        }
        if ($one['share_sleep']) {
            if ($one['share_ad']==1) {
                return $this->getCode($id, 'code_path');
            } elseif ($one['share_ad']==2) {
                $res = '<div class="tkp_qc_share" data-sleep="'.$one['share_sleep'].'">';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_2').'</div>';
                return $res.'</div>';
            } elseif ($one['share_ad']==3) {
                $res = '<div class="tkp_qc_share" data-sleep="'.$one['share_sleep'].'">';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_2').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_3').'</div>';
                return $res.'</div>';
            } else {
                return '';
            }
        } else {
            if ($one['share_ad']==1) {
                $rand=1;
            } else {
                $rand = rand(1, $one['share_ad']);
            }
            if ($rand==1) {
                $name = 'code_path';
            } else {
                $name = 'code_path_'.$rand;
            }
            return $this->getCode($id, $name);
        }
    }
    public function getCode($ads_id, $name='code_path')
    {
        $this->load->model('Code_model');
        $clsCode = new Code_model();
        $oneAds = $this->getOne($ads_id);
        $allCode = pathToArray($oneAds[$name]);
        if ($oneAds['is_horizontal']) {
            $html = '<div style="display:inline-block;width:'.$oneAds['width'].'px;margin-left:'.$oneAds['margin_top'].'px;margin-right:'.$oneAds['margin_bottom'].'px;">';
            if ($allCode) {
                foreach ($allCode as $key=>$code_id) {
                    $oneCode = $clsCode->getOne($code_id);
                    if ($oneCode['is_show']) {
                        $ml = '';
                        if ($key) {
                            $ml = 'margin-left:'.$oneAds['light_height'].'px;';
                        }
                        $html .= '<div style="float:left;'.$ml.'width:'.$oneCode['width'].'px;height:'.$oneCode['height'].'px;">'.$oneCode['content'].'</div>';
                    }
                }
            }
        } else {
            $html = '<div style="text-align:center;margin-top:'.$oneAds['margin_top'].'px;margin-bottom:'.$oneAds['margin_bottom'].'px;">';
            if ($allCode) {
                foreach ($allCode as $key=>$code_id) {
                    $oneCode = $clsCode->getOne($code_id);
                    if ($oneCode['is_show']) {
                        $ml = '';
                        if ($key) {
                            $ml = 'margin-top:'.$oneAds['light_height'].'px;';
                        }
                        $html .= '<div style="'.$ml.'width:'.$oneCode['width'].'px;height:'.$oneCode['height'].'px;">'.$oneCode['content'].'</div>';
                    }
                }
            }
        }
        return $html.'</div>';
    }
    public function getIDs($code_id)
    {
        $all = $this->getAll('code_path like "%|'.$code_id.'|%" OR code_path_2 like "%|'.$code_id.'|%" OR code_path_3 like "%|'.$code_id.'|%" order by ads_id desc limit 100', true, 'CMS');
        return $all;
    }
}
