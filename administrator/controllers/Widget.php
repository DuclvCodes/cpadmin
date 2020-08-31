<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Widget Controller
*| --------------------------------------------------------------------------
*| For widget controller
*|
*/
class Widget extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        setLinkDefault();
        $widget = array();
        $widget[] = array('title'=>'300 x 300', 'act'=>'300x300', 'width'=>300, 'height'=>300);
        $widget[] = array('title'=>'980 x 97', 'act'=>'980x97', 'width'=>980, 'height'=>97);
        $assign_list['widget'] = $widget;
        #
        $_widget = isset($_POST['widget'])?$_POST['widget']:0;
        $_campaign = isset($_POST['campaign'])? toNormal(str_replace(' ', '', $_POST['campaign'])):' News';
        $oneWidget = $widget[$_widget];
        $width = $oneWidget['width'];
        $height = $oneWidget['height'];
        $link = str_replace('cms.', 'www.', PCMS_URL).'/iframe/'.$oneWidget['act'].'&campaign='.$_campaign;
        if (isset($_POST['width']) && $_POST['width']) {
            $link .= '&width='.$_POST['width'];
            $width = $_POST['width'];
        }
        if (isset($_POST['rpp']) && $_POST['rpp']) {
            $link .= '&rpp='.$_POST['rpp'];
        }
        if (isset($_POST['nophoto']) && $_POST['nophoto']) {
            $link .= '&nophoto=1';
        } else {
            if (isset($_POST['iw']) && $_POST['iw']) {
                $link .= '&iw='.$_POST['iw'];
            }
            if (isset($_POST['ih']) && $_POST['ih']) {
                $link .= '&ih='.$_POST['ih'];
            }
        }
        $html = '<iframe src="'.$link.'" width="'.$width.'" height="'.$height.'" horizontalscrolling="no" verticalscrolling="no" allowtransparency="true" frameborder="0" scrolling="no" style="width: '.$width.'px !important; height: '.$height.'px !important; border: none !important; overflow: hidden !important;"></iframe>';
        $assign_list['_widget'] = $_widget;
        $assign_list['_campaign'] = $_campaign;
        $assign_list['_width'] = $_POST['width'];
        $assign_list['_rpp'] = $_POST['rpp'];
        $assign_list['_nophoto'] = $_POST['nophoto'];
        $assign_list['_iw'] = $_POST['iw'];
        $assign_list['_ih'] = $_POST['ih'];
        $assign_list['html'] = $html;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Nhúng BOX Widget";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
}
