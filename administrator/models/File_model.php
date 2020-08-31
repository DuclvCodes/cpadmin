<?php

/**
*| --------------------------------------------------------------------------
*| File Model
*| --------------------------------------------------------------------------
*| For file model
*|
*/

class File_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "file_id";
        $this->tbl = DB_PREFIX."file";
        $this->files = array('file');
    }
    public function downloadMedia($file, $type = 'image', $title = '', $ftp_path = '')
    {
        $file_encode = urldecode($file);
        //$filename = basename($file);
        $ext = pathinfo($file_encode, PATHINFO_EXTENSION); // To get extension
        $name2 =pathinfo($file_encode, PATHINFO_FILENAME); // File name without extension
        $filename = toSlug($name2).'.'.$ext;

        if (is_url_exist($file)) {
            //start download
            $path = LOCAL_UPLOAD_PATH.$filename;
            $fp = fopen($path, 'w');
            $ch = curl_init($file);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies');
            curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies');
            $data = curl_exec($ch);

            if (fwrite($fp, $data)) {
                $this->load->model('Image_model');
                $clsImage = new Image_model();
                if ($title == '') {
                    $title = toSlug($name2);
                }
                if ($ftp_path == '') {
                    $ftp_path = 'download';
                }
                $file_return = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$filename, $ftp_path, $title, time());
                return $file_return;
            } else {
                return false;
                //return false;
            }
        } else {
            return false;
        }
        return false;
    }
    
    public function downloa2Local($file, $type = 'image', $title = '')
    {
        $file_encode = urldecode($file);
        //$filename = basename($file);
        $ext = pathinfo($file_encode, PATHINFO_EXTENSION); // To get extension
        $name2 =pathinfo($file_encode, PATHINFO_FILENAME); // File name without extension
        if($title) $filename = toSlug($title).'.'.$ext;
        else $filename = toSlug($name2).'.'.$ext;

        if (is_url_exist($file)) {
            //start download
            $path = LOCAL_UPLOAD_PATH.$filename;
            $fp = fopen($path, 'w');
            $ch = curl_init($file);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies');
            curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies');
            $data = curl_exec($ch);

            if (fwrite($fp, $data)) {
                return $path;
            } else {
                return false;
                //return false;
            }
        } else {
            return false;
        }
        return false;
    }
}
