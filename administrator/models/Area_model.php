<?php

/**
*| --------------------------------------------------------------------------
*| Area Model
*| --------------------------------------------------------------------------
*| For area model
*|
*/

class Area_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->pkey = 'area_id';
        $this->tbl = DB_PREFIX.'ads_area';
    }
    public function getTitle($_id)
    {
        $res = $this->getOne($_id);
        return $res['title'];
    }
    public function getContent($id)
    {
        $oneArea = $this->getOne($id);
        if (!$oneArea['is_show']) {
            return '';
        }
        if ($oneArea['share_sleep']) {
            if ($oneArea['share_ad']==1) {
                return $this->getCode($id, 'code_path');
            } elseif ($oneArea['share_ad']==2) {
                $res = '<div class="tkp_qc_share" data-sleep="'.$oneArea['share_sleep'].'">';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_2').'</div>';
                return $res.'</div>';
            } elseif ($oneArea['share_ad']==3) {
                $res = '<div class="tkp_qc_share" data-sleep="'.$oneArea['share_sleep'].'">';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_2').'</div>';
                $res .= '<div class="tkp_qc_one">'.$this->getCode($id, 'code_path_3').'</div>';
                return $res.'</div>';
            } else {
                return '';
            }
        } else {
            if ($oneArea['share_ad']==1) {
                $rand=1;
            } else {
                $rand = rand(1, $oneArea['share_ad']);
            }
            if ($rand==1) {
                $name = 'code_path';
            } else {
                $name = 'code_path_'.$rand;
            }
            return $this->getCode($id, $name);
        }
    }
    public function getCode($area_id, $name='code_path')
    {
        $clsCode = new Code_model();
        $clsAds = new Ads_model();
        $oneArea = $this->getOne($area_id);
        $oneAds = $clsAds->getOne($oneArea['ads_id']);
        $allCode = $core->pathToArray($oneArea[$name]);
        if ($oneAds['is_horizontal']) {
            $width = $oneArea['width']?$oneArea['width']:$oneAds['width'];
            $html = '<div style="display:inline-block;width:'.$width.'px;margin-left:'.$oneAds['margin_top'].'px;margin-right:'.$oneAds['margin_bottom'].'px;">';
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
        $all = $this->getAll('code_path like "%|'.$code_id.'|%" OR code_path_2 like "%|'.$code_id.'|%" OR code_path_3 like "%|'.$code_id.'|%" order by area_id desc limit 100', true, 'CMS');
        return $all;
    }
    public function getOneArea($ads_id, $cat_id)
    {
        $all = $this->getAll('ads_id = "'.$ads_id.'" and cat_path like "%|'.$cat_id.'|%" order by area_id desc limit 1', true, 'CMS');
        if ($all) {
            return $all[0];
        } else {
            return false;
        }
    }
}
