<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ViewMenu extends CI_Controller
{

    /**
    * Forms controller.
    * Aim: a controller for forms display.
    *
    *
    * Maps to the following URL
    *         http://www.businessname.biz/forms
    *
    */

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('menus_helper');
    }
    public function index()
    {
        $this->load->view('mymenu');
    }
    //-------------------------------------------------------------------
}
