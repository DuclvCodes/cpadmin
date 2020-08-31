<?php

/**
*| --------------------------------------------------------------------------
*| Vote Model
*| --------------------------------------------------------------------------
*| For vote model
*|
*/

class Vote_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "vote_id";
        $this->tbl = DB_PREFIX."vote";
    }
}
