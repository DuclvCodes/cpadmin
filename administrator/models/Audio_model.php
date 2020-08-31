<?php

/**
*| --------------------------------------------------------------------------
*| Audio Model
*| --------------------------------------------------------------------------
*| For audio model
*|
*/

class Audio_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "audio_id";
        $this->tbl = DB_PREFIX."audio";
        $this->files = array('file');
    }
}
