<?php

/**
*| --------------------------------------------------------------------------
*| Voter Model
*| --------------------------------------------------------------------------
*| For voter model
*|
*/

class Voter_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'voter_id';
        $this->tbl = DB_PREFIX.'voter';
    }
}
