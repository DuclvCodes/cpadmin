<?php

/**
*| --------------------------------------------------------------------------
*| Newstype Model
*| --------------------------------------------------------------------------
*| For newstype model
*|
*/

class Newstype_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "newstype_id";
        $this->tbl = DB_PREFIX."news_type";

        parent::__construct();
    }
}
