<?php

/**
*| --------------------------------------------------------------------------
*| Image Model
*| --------------------------------------------------------------------------
*| For image model
*|
*/

class Image_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = 'image_id';
        $this->tbl = DB_PREFIX.'image';
        $this->files = array('file');
    }
    public function uploadFile($name='image', $dts_w=0, $dts_h=0, $path=LOCAL_UPLOAD_PATH, $filename = null)
    {
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'rar', 'zip', 'txt', 'doc', 'docx', 'pdf');
        $extension = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), $allowed)) {
            die('Do not support this extension');
        }
        $file_type=$_FILES[$name]['type'];
        $file_size=$_FILES[$name]['size'];
        if ((($file_type == "image/gif") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && ($file_size < 20000000)) {
        } else {
            return false;
        }
        list($src_w, $src_h) = getimagesize($_FILES[$name]['tmp_name']);
        #
        if ($dts_w>$src_w || !$dts_w) {
            $dts_w = $src_w;
        }
        if ($dts_h>$src_h) {
            $dts_h = $src_h;
        }
        if (!$dts_h) {
            $ratio = $dts_w / $src_w;
            $dts_h = $src_h * $ratio;
        }
        $ratio = max($dts_w / $src_w, $dts_h / $src_h);
        $src_x = ($src_w-$dts_w/$ratio)/2;
        $src_y = ($src_h-$dts_h/$ratio)/2;
        $src_w = $dts_w/$ratio;
        $src_h = $dts_h/$ratio;
        #
        if (!$filename) {
            $filename = date('ymdHis').'-'.$_FILES[$name]['name'];
        }
        $path = $path.strtolower($filename);
        
        //resize image file without gif file
        if ($file_type != 'image/gif') {
            $imgString = file_get_contents($_FILES[$name]['tmp_name']);
            $image = imagecreatefromstring($imgString);
            $tmp = imagecreatetruecolor($dts_w, $dts_h);
            $white = imagecolorallocate($tmp, 255, 255, 255);
            imagefill($tmp, 0, 0, $white);
            imagecopyresampled($tmp, $image, 0, 0, $src_x, $src_y, $dts_w, $dts_h, $src_w, $src_h);
        }
        if ($file_type == 'image/gif') {
            move_uploaded_file($_FILES[$name]['tmp_name'], $path) or die("Can't move file to $path");
        }
        switch ($_FILES[$name]['type']) {
            case 'image/jpeg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'image/png':
                imagepng($tmp, $path, 0);
                break;
            case 'image/gif':
                imagegif($tmp, $path);
                break;
            default:
                return false;
                break;
        }
        imagedestroy($image);
        imagedestroy($tmp);
        return $path;
    }
    public function uploadURL($url, $path='uploads/', $filename = null)
    {
        $name = strtolower(basename($url));
        $ext = $this->getFileType($url);
        if (!$filename) {
            $filename = date('ymdHis').'-'.strtolower($name);
        }
        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif" || $ext == "doc" || $ext == "docx" || $ext == "pdf") {
        } else {
            return false;
        }
        $data = @file_get_contents($url);
        if ($data) {
            $upload = file_put_contents($path.$filename, $data);
            if ($upload) {
                return $path.$filename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function moveToMedia($file, $paths=null, $slug_name=null, $time=0)
    {
        $directory = '/files/';
        if ($paths) {
            $paths = $directory.$paths;
        } else {
            $paths = $directory;
        }
        
        $this->load->library('ftp');
        $config['hostname'] = FTP_SERVER;
        $config['username'] = FTP_USERNAME;
        $config['password'] = FTP_PASSWORD;
        $config['debug']        = true;
        $this->ftp->connect($config);
        
        $ftp_server=FTP_SERVER;
        $ftp_user_name=FTP_USERNAME;
        $ftp_user_pass=FTP_PASSWORD;
        if (!$slug_name) {
            $slug_name = date('YmdHis');
        }
        $slug_name .= '.'.$this->getFileType($file);
        
        if (!$time) {
            $time=time();
        }
        
        $dtree = array(
            date('Y'),
            date('Y').'/'.date('m'),
            date('Y').'/'.date('m').'/'.date('d')
        );

        //first create path file
        if ($this->ftp->list_files($paths) === false) {
            $this->ftp->mkdir($paths);
        }
        foreach ($dtree as $dir) {
            if ($this->ftp->list_files($paths.'/'.$dir) === false) {
                $this->ftp->mkdir($paths.'/'.$dir);
            }
        }
        $new_paths = $paths.'/'.date('Y').'/'.date('m').'/'.date('d');
        
        //File upload path of remote server
        $destination = $new_paths.'/'.$slug_name;
        //Upload file to the remote server
        $upload = $this->ftp->upload($file, ".".$destination);
        
        $this->ftp->close();
        if (!$upload) {
            return false; //{print_r(error_get_last()); die();}
        } else {
            //Delete file from local server
            @unlink($file);
            return $new_paths.'/'.$slug_name;
        }
    }
    public function moveToMedia2($file, $paths=null, $slug_name=null, $time=0)
    {
        $directory = '/files/';
        if ($paths) {
            $paths = $directory.$paths;
        } else {
            $paths = $directory;
        }
        $ftp_server=FTP_SERVER2;
        $ftp_user_name=FTP_USERNAME2;
        $ftp_user_pass=FTP_PASSWORD2;
        if (!$slug_name) {
            $slug_name = date('YmdHis');
        }
        $slug_name .= '.'.$this->getFileType($file);
        
        $conn_id = ftp_connect($ftp_server);
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        if ((!$conn_id) || (!$login_result)) {
            error_log("FTP 2 connection has encountered an error!");
        }
        if (!$time) {
            $time=time();
        }
        
        if (!ftp_chdir($conn_id, $paths)) {
            ftp_mkdir($conn_id, $paths);
        }
        $paths .= date('/Y', $time);
        if (!ftp_chdir($conn_id, $paths)) {
            ftp_mkdir($conn_id, $paths);
        }
        $paths .= date('/m', $time);
        if (!ftp_chdir($conn_id, $paths)) {
            ftp_mkdir($conn_id, $paths);
        }
        $paths .= date('/d', $time);
        if (!ftp_chdir($conn_id, $paths)) {
            ftp_mkdir($conn_id, $paths);
        }
        
        $upload = ftp_put($conn_id, $paths.'/'.$slug_name, $file, FTP_BINARY);
        
        ftp_close($conn_id);
        if (!$upload) {
            return false;
        } //{print_r(error_get_last()); die();}
        unlink($file);
        return $paths.'/'.$slug_name;
    }
    public function getFileType($url)
    {
//        if(stripos($url, '?')) $url = array_shift(explode('?', $url));
//        $file_type = end(explode('.', $url));
//        $file_type = strtolower($file_type);
        $file_type = pathinfo($url, PATHINFO_EXTENSION);
        return $file_type;
    }
}
