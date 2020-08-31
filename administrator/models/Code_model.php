<?php
class Code_model extends MY_Model
{
    public function __construct()
    {
        $this->pkey = 'code_id';
        $this->tbl = DB_PREFIX.'ads_code';

        parent::__construct();
    }
}
