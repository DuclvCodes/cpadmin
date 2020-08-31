<?php

/**
*| --------------------------------------------------------------------------
*| Chuyengia Model
*| --------------------------------------------------------------------------
*| For chuyengia model
*|
*/

class Chuyengia_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = "chuyengia_id";
        $this->tbl = DB_PREFIX."chuyengia";

        parent::__construct();
    }
}
