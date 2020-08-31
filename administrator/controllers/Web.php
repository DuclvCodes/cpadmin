<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Web extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('Ads');
        $data['ads'] = $this->Ads->getAllAds();
        $this->template->build('home', $data);
    }


    public function home()
    {
    }
    
    public function thoitiet() {
        $this->load->model('Tienich_model');
        $this->load->helper('simple_html_dom');
        
        //load data
        $thoitiet = $this->Tienich_model->getBySlug('thoi_tiet');
        $content = json_decode($thoitiet['content'],true);
        $html = str_get_html($content['html']);
        $data = array();
        
        foreach($html->find('#weather_result .info_weather') as $row){
        
            $column = $row->find('.info_weather_col', 0);
            $data[] = array(
                $column->find('img',0)->src,
                $column->find('h3',0)->plaintext,
                $column->find('.forecast',0)->plaintext,
            );
        }
        if(!empty($_GET['d'])){
            if(empty($data[$_GET['d']])){
                $_GET['d'] = 0;
            }
        }
        
        $assign_list['data'] = $data;
        $this->load->view('backend/thoitiet', $assign_list);
    }
}


/* End of file Web.php */
/* Location: ./application/controllers/Web.php */
