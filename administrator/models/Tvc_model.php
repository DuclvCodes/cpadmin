<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tvc Model
*| --------------------------------------------------------------------------
*|
*|
*/
class Tvc_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'tvc_id';
        $this->tbl = DB_PREFIX.'tvc';
    }
}
