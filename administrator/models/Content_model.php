<?php

/**
*| --------------------------------------------------------------------------
*| Contents Model
*| --------------------------------------------------------------------------
*| For contents model
*|
*/

class Content_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "ContentID";
        $this->tbl = "contents";

        parent::__construct();
    }
}
