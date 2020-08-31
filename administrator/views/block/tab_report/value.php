<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tab_report
{
    private $block_name 	= '';
    private $path_html = '';

    public function setBlockName($name)
    {
        $this->block_name = $name;
        $this->path_html = 'block/'.$this->block_name.'/html';
    }

    public function var_html()
    {
        $CI =& get_instance();
        
        $html_return = $CI->load->view($this->path_html, '', true);

        return $html_return;
    }
}
