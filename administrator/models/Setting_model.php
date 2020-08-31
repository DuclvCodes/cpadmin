<?php

/**
*| --------------------------------------------------------------------------
*| Setting Model
*| --------------------------------------------------------------------------
*| For setting model
*|
*/

class Setting_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "setting_id";
        $this->tbl = DB_PREFIX."system_setting";
        $this->info = $this->getOne(1);
    }
    public function getTitle()
    {
        $one = $this->info;
        return $one['title'];
    }
    public function getMetaDes()
    {
        $one = $this->info;
        return $one['description'];
    }
    public function getMetaKey()
    {
        $one = $this->info;
        return $one['keyword'];
    }
    public function getNamePage()
    {
        $one = $this->info;
        return $one['name_page'];
    }
    public function getAnalytics()
    {
        $one = $this->info;
        return $one['analytics'];
    }
    public function getTextlink()
    {
        $one = $this->info;
        return $one['textlink'];
    }
    public function getContact()
    {
        $one = $this->info;
        $contact = json_decode($one['contact']);
        if (is_object($contact)) {
            $contact = get_object_vars($contact);
        }
        return $contact;
    }
    public function getEmail()
    {
        $one = $this->info;
        return $one['email'];
    }
    public function getLogo()
    {
        $one = $this->info;
        return $one['logo'];
    }
    public function getAbout()
    {
        $one = $this->info;
        return $one['about'];
    }
    public function getCommingDate()
    {
        $one = $this->info;
        return $one['comming_date'];
    }
    public function getGLTT()
    {
        $one = $this->info;
        return $one['gltt_news_id'];
    }
    public function getOptions()
    {
        $one = $this->info;
        if ($one['options']) {
            $res = json_decode($one['options']);
        }
        if (is_object($res)) {
            $res = get_object_vars($res);
        }
        return $res;
    }
    public function updateLogo($logo)
    {
        $res = $this->updateOne(1, array('logo'=>$logo));
        return $res;
    }
}
