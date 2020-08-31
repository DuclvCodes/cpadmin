<?php
if(!function_exists('setLinkDefault')) {
    function setLinkDefault() {
        $_SESSION['LINK_DEFAULT_'] = $_SERVER['REQUEST_URI'];
    }
}

if(!function_exists('getLinkDefault')) {
    function getLinkDefault() {
        if($_SESSION['LINK_DEFAULT_']) return $_SESSION['LINK_DEFAULT_'];
        else return '/';
    }
}
if(!function_exists('check_user')) {
    function check_user() {
        $CI =& get_instance();
        $CI->load->model('User_model');
        $clsUser = new User_model();
        $arr = $clsUser->getModule();
        $method = current_method();
        
        $mod_name = $arr[$method['mod']]; 
        if(!$mod_name) $mod_name = $method['mod'];
        $mod = $method['mod'];
        $act = $method['act'];
        
        $title = 'Đang ở module '.$mod_name;
        if($act=='add') $title .= '. Thêm mới';
        elseif($act=='edit') {
            $classTable = ucfirst(strtolower($mod)).'_model';
            //check model exits
            if(file_exists(APPPATH."models/$classTable.php")){
                $CI->load->model($classTable);
                $clsClassTable = new $classTable;
             }
             else{
               // model doesn't exist
               return false;
             }
            
            
            $one = $clsClassTable->getOne($_GET['id']);
            if($mod_name=='Tin tức') $mod_name = 'bài';
            $title .= '. Sửa '.strtolower($mod_name).' '.$one['title'];
        }
        
        $user_id = $clsUser->getUserID();
        $oneUser = $clsUser->getOne($user_id);
        
        if(!$user_id) {
            if(get_cookie(['USER'])) redirect('/iframe/lock_screen?u='.rawurlencode(getAddress()));
            else redirect('/iframe/login?u='.rawurlencode(getAddress()));
            die();
        }
        else {
            if($oneUser['is_token'] && $oneUser['code_login']) {
                redirect('/iframe/confirm?u='.rawurlencode(getAddress()));
                die();
            }
        }
        $data = array('status'=>$title, 'status_link'=>getAddress(), 'last_login'=>time());
        if($mod=='news' && $act=='edit' && isset($_GET['id'])) {
            $data['editing_news_id'] = $_GET['id'];
            $key_open = 'news_'.$_GET['id'];
        }
        else {
            $data['editing_news_id'] = 0;
            $key_open = 'news_'.$oneUser['editing_news_id'];
        }
        $res = $clsUser->updateOne($user_id, $data);
        if($res) $clsUser->deleteArrKey($key_open);
        return true;
    }
}

if(!function_exists('display_icon')) {
    function display_icon($data) {
        $icon = '';
        if($data['is_photo'] == 1) {
            $icon = '<i class="fas icon-picture tkp_icon_title"></i>';
        }elseif($data['is_video'] == 1) {
            $icon = '<i class="fa-camera tkp_icon_title"></i>';
        }
        echo $icon;
    }
}
if(!function_exists('is_url_exist')) {
	function is_url_exist($url){
		$ch = curl_init($url);    
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($code == 200){
		   $status = true;
		}else{
		  $status = false;
		}
		curl_close($ch);
	   return $status;
	}
}
if(!function_exists('remove_utf8_bom')) {
    function remove_utf8_bom($text) {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}

if(!function_exists('current_method')) {
    function current_method() {
        $current_url =& get_instance(); //  get a reference to CodeIgniter
        $data['mod'] = $current_url->router->fetch_class(); // for Class name or controller
        $data['act'] = $current_url->router->fetch_method(); // for method name
        //load view at administrator
        if($data['act'] == 'index') $view = $data['mod'];
        else $view = $data['act'];
        $data['view'] = 'backend/standart/administrator/'.$data['mod'].'/'.$view;
        return $data;
    }
}

if(!function_exists('getBlock')) {
	function getBlock($name, $model_name = null) {
            $CI =& get_instance();

            #require_once( APPPATH . 'models/' . $model_name . '.php');
            if ($model_name) {
                $clsClassTable = $CI->load->model($model_name);
                $key_box       = 'cache_'.$name;
                $content_html  = $CI->$model_name->getCacheBox($key_box);
                if ($content_html) {
                    echo $content_html;
                    //return true;
                } else {
                    $content_html = getBockNoCache($name);
                    //ob_end_clean();
                    //$CI->$model_name->setCacheBox($key_box, $content_html);
                    echo $content_html;
                    //return true;
                }
            } else {
                $key_box       = 'cache_block_'.$name;
                $clsClassTable = $CI->load->model('My_Model');
                $content_html  = $CI->My_Model->getCacheBox($key_box);
                if ($content_html) {
                    echo $content_html;
                    //return true;
                } else {
                    $content_html = getBockNoCache($name);
                    //$CI->My_Model->setCacheBox($key_box, $content_html);
                    echo $content_html;
                    //return true;
                }
            }
    }
}

if(!function_exists('getBockNoCache')) {

    function getBockNoCache($name) {
    	$CI =& get_instance();
    	$my_value = APPPATH."views/block/".strtolower($name).'/value.php';
    	$my_html = APPPATH."views/block/".strtolower($name).'/html.php';
    	if(file_exists($my_value) && file_exists($my_html)) {
    		include_once($my_value);
	    	$cls = new $name();
	    	$cls->setBlockName((string)$name);
	    	$content_html = $cls->var_html();
                unset($cls);
	    	return $content_html;
    	}else {
    		return 'Not block '.$name.' found !';
    	}
	    	
    }
}

if(!function_exists('inc_dir')) {
    function inc_dir($str) {
        require($str);
        return $assign_list;
    }
}

if(!function_exists('getIP')) {
    function getIP(){
        return $_SERVER['REMOTE_ADDR'];
    }
}

if(!function_exists('toString')) {
    function toString($int){
        return number_format($int, 0, ',', '.');
    }
}

if(!function_exists('toSlug')) {
    function toSlug($doc){
        $str = addslashes(html_entity_decode($doc));
        $str = toNormal($str);
        $str = preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $str);
        $str = preg_replace('/( )/', '-', $str);
        $str = str_replace('--', '-', $str);
        $str = str_replace('/', '-', $str);
        $str = str_replace('\/', '', $str);
        $str = str_replace('+', '', $str);
        $str = strtolower($str);
        $str = stripslashes($str);
        return trim($str, '-');
    }
}

if(!function_exists('toNormal')) {
    function toNormal($str){
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str);
        $str = preg_replace('/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str);
        $str = preg_replace('/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str);
        $str = preg_replace('/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str);
        $str = preg_replace('/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str);
        $str = preg_replace('/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str);
        $str = preg_replace('/(Đ)/', 'D', $str);
        return $str;
    }
}

if(!function_exists('toNumber')) {
    function toNumber($str){
        $str = preg_replace('/[^0-9\/_|+ -]/', '', $str);
        $str = str_replace('_', '', $str);
        $str = str_replace(' ', '', $str);
        return intval($str);
    }
}

if(!function_exists('toBytes')) {
    function toBytes($bytes, $precision = 2, $_mb = 1024){
        $base     = log($bytes) / log($_mb);
        $suffixes = array(
            '',
            'k',
            'M',
            'G',
            'T'
        );
        return round(pow($_mb, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }
}

if(!function_exists('get_limit_content')) {
    function get_limit_content($string, $length = 255){
        $string = strip_tags($string);
        if (strlen($string) > 0) {
            $arr    = explode(' ', $string);
            $return = '';
            if (count($arr) > 0) {
                $count = 0;
                if ($arr)
                    foreach ($arr as $str) {
                        $count += strlen($str);
                        if ($count > $length) {
                            $return .= '...';
                            break;
                        }
                        $return .= ' ' . $str;
                    }
            }
            return $return;
        }
    }
}
    function split_string_2_paragraph($string, $length = 255){
        $string = strip_tags($string);
        if (strlen($string) > 0) {
            $arr    = explode(' ', $string);
            $return = array();
            if (count($arr) > 0) {
                $count = 0;
                $count_2 = 0;
                if ($arr)
                    foreach ($arr as $key=> $str) {
                        $count += strlen($str);
                        if ($count > $length) {
                            $return[$count_2] .= '';
                            $count_2 ++;
                            $count = 0;
                        }
                        $return[$count_2] .= ' ' . $str;
                        
                    }
            }
            return $return;
        }
    }

    function formatUrlsInText($text){
        $reg_exUrl = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
        preg_match_all($reg_exUrl, $text, $matches);
        $usedPatterns = array();
        foreach ($matches[0] as $pattern) {
            if (!array_key_exists($pattern, $usedPatterns)) {
                $usedPatterns[$pattern] = true;
                $text                   = str_replace($pattern, '<a href="' . $pattern . '" rel="nofollow" target="_blank">' . $pattern . '</a> ', $text);
            }
        }
        return $text;
    }
    function time_ago($tm, $rcs = 0){
        $cur_tm = time();
        $dif    = $cur_tm - $tm;
        $pds    = array(
            'giây',
            'phút',
            'giờ',
            'ngày',
            'tuần',
            'tháng',
            'năm',
            'thập kỉ'
        );
        $lngh   = array(
            1,
            60,
            3600,
            86400,
            604800,
            2630880,
            31570560,
            315705600
        );
        for ($v = sizeof($lngh) - 1; ($v >= 0) && (($no = $dif / $lngh[$v]) <= 1); $v--);
        if ($v < 0)
            $v = 0;
        $_tm = $cur_tm - ($dif % $lngh[$v]);
        $no  = floor($no);
        if ($no <> 1)
            $pds[$v] .= '';
        $x = sprintf("%d %s ", $no, $pds[$v]);
        if (($rcs == 1) && ($v >= 1) && (($cur_tm - $_tm) > 0))
            $x .= time_ago($_tm);
        return $x . ' trước';
    }
    function time_str($time){
        return date(DEFAULT_TIME_FORMAT, $time);
    }
    function db2datepicker($str, $has_time = true){
        if (!$str || $str == '1970-01-01 00:00:00' || $str == '0000-00-00 00:00:00' || $str == '0000-00-00' || $str == '1970-01-01')
            return false;
        if ($has_time)
            $res = date('d/m/Y H:i:s', strtotime($str));
        else
            $res = date('d/m/Y', strtotime($str));
        return $res;
    }
    function datepicker2db($str, $has_time = true){
        if (!$str || trim($str) == '')
            return '';
        if ($has_time) {
            $arr  = explode(' ', trim($str));
            $date = explode('/', $arr[0]);
            return $date[2] . '-' . $date[1] . '-' . $date[0] . ' ' . $arr[1];
        } else {
            $date = explode('/', trim($str));
            return $date[2] . '-' . $date[1] . '-' . $date[0];
        }
    }
    function getAddress(){
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    function getLinkReplateGET($arr){
        $res = $_GET;
        $str = '?';
        $i   = 0;
        if ($arr)
            foreach ($arr as $key => $val) {
                $res[$key] = $val;
                if ($val == '')
                    unset($res[$key]);
            }
        if ($res)
            foreach ($res as $key => $val) {
                if ($i == 0)
                    $i = 1;
                else
                    $str .= '&';
                $str .= $key . '=' . $val;
            }
        if( strpos( $res, "#" ) === true ) {
            $hastag = explode( "#", $res )[1];
            $str .= '#'.$hastag;
        }
        echo $str;
    }
if(!function_exists('pathToArray')) {
    function pathToArray($path){
        if (!$path)
            return false;
        $path = trim($path, '|');
        if (!$path)
            return false;
        $path = str_replace('||', '|', $path);
        if (!$path)
            return false;
        return explode('|', $path);
    }
}
if(!function_exists('arrayToPath')) {
    function arrayToPath($arr){
        if (is_array($arr))
            return '|' . implode('|', $arr) . '|';
        else
            return false;
    }
}

if(!function_exists('localhostUpload')) {
    function localhostUpload($file, $paths = null, $slug_name = null, $time = 0, $max_width = 500, $max_height = 0){
        $file_type = $_FILES[$file]['type'];
        if ((($file_type == 'image/gif') || ($file_type == 'image/bmp') || ($file_type == 'image/jpeg') || ($file_type == 'image/png') || ($file_type == 'image/pjpeg')) && ($file_size < 10000000)) {
            $CI =& get_instance();
            $CI->load->model('Image_model');
            $clsImage = new Image_model();
            $directory = 'files/';
            if ($paths)
                $directory .= $paths . '/';
            if (!is_dir($directory)) {
                $old = umask(0);
                mkdir($directory, 0777);
                umask($old);
            }
            $directory .= date('Y', $time) . '/';
            if (!is_dir($directory)) {
                $old = umask(0);
                mkdir($directory, 0777);
                umask($old);
            }
            $directory .= date('m', $time) . '/';
            if (!is_dir($directory)) {
                $old = umask(0);
                mkdir($directory, 0777);
                umask($old);
            }
            $directory .= date('d', $time) . '/';
            if (!is_dir($directory)) {
                $old = umask(0);
                mkdir($directory, 0777);
                umask($old);
            }
            $file_name = $_FILES[$file]['name'];
            if ($slug_name)
                $slug_name .= '.' . $clsImage->getFileType($file_name);
            else
                $slug_name = $file_name;
            $slug_name = strtolower($slug_name);

            $res       = $clsImage->uploadFile($file, $max_width, $max_height, $directory, $slug_name);
            if ($res)
                return '/' . $res;
            else
                return false;
        } else
            return false;
    }
}
if(!function_exists('localUpload')) {
    function localUpload($file, $paths = null, $slug_name = null, $time = 0, $max_width = 500, $max_height = 0){
        if (USE_FTP == false)
            return $this->localhostUpload($file, $paths, $slug_name, $time, $max_width, $max_height);
        $CI =& get_instance();
        $CI->load->model('Image_model');
        $clsImage = new Image_model();
        $local    = $clsImage->uploadFile($file, $max_width, $max_height);
        return $local;
        if (substr($local, -4, 4) == '.png') {
            $_local = str_replace('.png', '.jpg', $local);
            $image  = imagecreatefrompng($local);
            imagejpeg($image, $_local, 100);
            imagedestroy($image);
            unlink($local);
            $local = $_local;
            unset($_local);
        }
        //$res = $clsImage->moveToMedia($local, $paths, $slug_name, $time);
        //$res = $clsImage->moveToMedia2($local, $paths, $slug_name, $time);
        return $local;
    }
}  
if(!function_exists('ftpUpload')) {
    function ftpUpload($file, $paths = null, $slug_name = null, $time = 0, $max_width = 500, $max_height = 0){
        if (USE_FTP == false)
            return $this->localhostUpload($file, $paths, $slug_name, $time, $max_width, $max_height);
        $CI =& get_instance();
        $CI->load->model('Image_model');
        $clsImage = new Image_model();
        $local    = $clsImage->uploadFile($file, $max_width, $max_height);
        if (substr($local, -4, 4) == '.png') {
            $_local = str_replace('.png', '.jpg', $local);
            $image  = imagecreatefrompng($local);
            imagejpeg($image, $_local, 100);
            imagedestroy($image);
            unlink($local);
            $local = $_local;
            unset($_local);
        }
        $res = $clsImage->moveToMedia($local, $paths, $slug_name, $time);
        //$res = $clsImage->moveToMedia2($local, $paths, $slug_name, $time);
        return $res;
    }
}
if(!function_exists('fptUrlUpload')) {
    function ftpUrlUpload($url, $paths = null, $slug_name = null, $time = 0){
        $CI =& get_instance();
        $CI->load->model('Image_model');
        $clsImage = new Image_model();
        if (USE_FTP == false) {
            if ($paths)
                $paths = 'files/' . $paths . '/';
            else
                $paths = 'files/';
            if (!$time)
                $time = time();
            if (!is_dir($paths)) {
                $old = umask(0);
                mkdir($paths, 0777);
                umask($old);
            }
            $paths .= date('Y', $time) . '/';
            if (!is_dir($paths)) {
                $old = umask(0);
                mkdir($paths, 0777);
                umask($old);
            }
            $paths .= date('m', $time) . '/';
            if (!is_dir($paths)) {
                $old = umask(0);
                mkdir($paths, 0777);
                umask($old);
            }
            $paths .= date('d', $time) . '/';
            if (!is_dir($paths)) {
                $old = umask(0);
                mkdir($paths, 0777);
                umask($old);
            }
            
            $upload   = $clsImage->uploadURL($url, $paths, $slug_name . '.' . $clsImage->getFileType($url));
            if ($upload)
                return '/' . $upload;
            else
                return false;
        }
        
        $local    = $clsImage->uploadURL($url);
        $res      = $clsImage->moveToMedia($local, $paths, $slug_name, $time);
        return $res;
    }
}    
if(!function_exists('fptDelete')) {
    function ftpDelete($file){
        if (!$file)
            return false;
        $file = str_replace(MEDIA_DOMAIN, '', $file);
        if (stripos($file, '?'))
            $file = array_shift(explode('?', $file));
        $ci =& get_instance();
        $ci->load->library('ftp');
        
        $config['hostname'] = FTP_SERVER;
        $config['username'] = FTP_USERNAME;
        $config['password'] = FTP_PASSWORD;
        $config['port']     = 21;
        $config['debug']    = false;
        $ci->ftp->connect($config);
        $res = $ci->ftp->delete_file($file);
        $ci->ftp->close();
        return $res;
    }
}
if(!function_exists('fptScandir')) {
    function ftpScandir($path, $year = null, $month = null, $day = null){
        $ftp_server    = FTP_SERVER;
        $ftp_user_name = FTP_USERNAME;
        $ftp_user_pass = FTP_PASSWORD;
        $conn_id       = ftp_connect($ftp_server);
        $login_result  = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        if ($path)
            $path = '/files/' . $path;
        if ($year)
            $path .= '/' . $year;
        if ($month)
            $path .= '/' . $month;
        if ($day)
            $path .= '/' . $day;
        $contents = ftp_nlist($conn_id, $path);
        if ($contents && $contents[0] == '.')
            array_shift($contents);
        if ($contents && $contents[0] == '..')
            array_shift($contents);
        return $contents;
    }
}
if(!function_exists('get_mysql_version')) {
	function get_mysql_version() {
		$mysql_info = explode(' ', mysqli_get_client_info());
		$mysql_version = isset($mysql_info[1]) ? $mysql_info[1] : false;
		$mysql_version_number = explode('-', $mysql_version)[0];

		if ($mysql_version_number) {
			return $mysql_version_number;
		} else if (isset($mysql_info[0])) {
			return (int)substr($mysql_info[0], 0, 3);
		}

		return 5;
	}
}

if(!function_exists('get_database_config')) {
	function get_database_config($param = '') {
		if(file_exists($file_path = APPPATH.'/config/database.php'))
		{
			include($file_path);
		}

		if(isset($db[$active_group][$param])) {
			return $db[$active_group][$param];
		}
	}
}

if(!function_exists('redirect_back')) {
	function redirect_back($url = '')
	{
	    if(isset($_SERVER['HTTP_REFERER']))
	    {
	        header('Location: '.$_SERVER['HTTP_REFERER']);
	    }
	    else
	    {
	        redirect($url);
	    }
	    exit;
	}
}

if(!function_exists('db_get_all_data')) {
	function db_get_all_data($table_name = null, $where = false) {
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
	  	$query = $ci->db->get($table_name);

	    return $query->result();
	}
}

if(!function_exists('is_image')) {
	function is_image($filename = '') {
		$array = explode('.', $filename);
		$extension = strtolower(end($array));
		$list_image_ext = ['', 'png', 'jpg', 'jpeg', 'gif'];

		if (array_search($extension, $list_image_ext)) {
			return TRUE;
		}

		return FALSE;
	}
}

if(!function_exists('clean_snake_case')) {
	function clean_snake_case($text = '') {
		$text = preg_replace('/_/', ' ', $text);

		return $text;
	}
}

if(!function_exists('get_group_user')) {
	function get_group_user($id_user = '') {
		return get_user_groups($id_user);
	}
}

if(!function_exists('get_user_data')) {
	function get_user_data($field_name = '') {
		$ci =& get_instance();
		$user_id = $ci->session->userdata('id');
		if ($user_id) {
			if (empty($field_name)) {
				return $ci->aauth->get_user($user_id);
			} else {
				return $ci->aauth->get_user($user_id)->$field_name;
			}
		}

		return false;
	}
}

if(!function_exists('is_allowed')) {
	function is_allowed($permission, Closure $func) {
		$ci =& get_instance();
		$reflection = new ReflectionFunction($func);
		$arguments  = $reflection->getParameters();


		if ($ci->aauth->is_allowed($permission)) {
			call_user_func($func, $arguments);
		} else {
			ob_start();
			call_user_func($func, $arguments);
			$buffer = ob_get_contents();
			ob_end_clean();

		}
	}
}

if(!function_exists('message_flash')) {
	function message_flash($message, $type) {
		$ci =& get_instance();
		$ci->session->set_flashdata('f_message', $message);
		$ci->session->set_flashdata('f_type', $type);
	}
}

if(!function_exists('display_menu_module')) {
	function display_menu_module($parent, $level, $menu_type, $ignore_active = false) {
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->model('model_menu');
		$menu_type_id = $ci->model_menu->get_id_menu_type_by_flag($menu_type);
	    $result = $ci->db->query("SELECT a.id, a.label, a.type, a.active, a.link, Deriv1.Count FROM `menu` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `menu` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.menu_type_id = ".$menu_type_id." AND a.parent=" . $parent." ".($ignore_active ? '' : 'and active = 1')." order by `sort` ASC")->result();

		$ret = '';
	    if ($result) {
		    $ret .= '<ol class="dd-list">';
		   	foreach ($result as $row) {
		        if ($row->Count > 0) {
		        	 $ret .= '<li class="dd-item dd3-item '.($row->active ? '' : 'menu-toggle-activate_inactive').' menu-toggle-activate" data-id="'.$row->id.'" data-status="'.$row->active.'">';

		        	if ($row->type != 'label') {
		        		$ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
		            	$ret .= '<div class="dd3-content">'._ent($row->label);
		        	} else{
		            	$ret .= '<div class="dd3-content  dd-label dd-handles"><b>'._ent($row->label).'</b>';
		        	}

		            if ($ci->aauth->is_allowed('menu_delete')) {
				            $ret .= '<span class="pull-right"><a class="remove-data" href="javascript:void()" data-href="'.site_url('administrator/menu/delete/'.$row->id).'"><i class="fa fa-trash btn-action"></i></a>
				                </span';
		            }

		            if ($ci->aauth->is_allowed('menu_update')) {
				            $ret .= '<span class="pull-right"><a href="'.site_url('administrator/menu/edit/'.$row->id).'"><i class="fa fa-pencil btn-action"></i></a>
		                        </span>';
		            }

		            $ret .= '</div>';
					$ret .= display_menu_module($row->id, $level + 1, $menu_type, $ignore_active);
					$ret .= "</li>";
		        } elseif ($row->Count==0) {
		            $ret .= '<li class="dd-item dd3-item '.($row->active ? '' : 'menu-toggle-activate_inactive').' menu-toggle-activate" data-id="'.$row->id.'" data-status="'.$row->active.'">';

		        	if ($row->type != 'label') {
		        		$ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
		            	$ret .= '<div class="dd3-content">'._ent($row->label);
		        	} else{
		            	$ret .= '<div class="dd3-content  dd-label dd-handles"><b>'._ent($row->label).'</b>';
		        	}

		            if ($ci->aauth->is_allowed('menu_delete')) {
				            $ret .= '<span class="pull-right"><a class="remove-data" href="javascript:void()" data-href="'.site_url('administrator/menu/delete/'.$row->id).'"><i class="fa fa-trash btn-action"></i></a>
				                </span';
		            }

		            if ($ci->aauth->is_allowed('menu_update')) {
				            $ret .= '<span class="pull-right"><a href="'.site_url('administrator/menu/edit/'.$row->id).'"><i class="fa fa-pencil btn-action"></i></a>
		                        </span>';
		            }

					$ret .= '</div></li>';
		        }
		    }
		    $ret .= "</ol>";
	    }

	    return $ret;
	}
}

if(!function_exists('display_menu_admin')) {
	function display_menu_admin($parent, $level) {
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->model('model_menu');
	    $result = $ci->db->query("SELECT a.id, a.label,a.icon_color, a.type, a.link,a.icon, Deriv1.Count FROM `menu` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `menu` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.menu_type_id = 1 AND a.parent=" . $parent." and active = 1  order by `sort` ASC")->result();

		$ret = '';
	    if ($result) {
	    	if (($level > 1) AND ($parent > 0) ) {
		    	$ret .= '<ul class="treeview-menu">';
	    	} else {
	    		$ret = '';
	    	}
		   	foreach ($result as $row) {

		   

		   		$perms = 'menu_'.strtolower(str_replace(' ', '_', $row->label));

		   		$links = explode('/', $row->link);

				$segments = array_slice($ci->uri->segment_array(), 0, count($links));
				
		   		if (implode('/', $segments) == implode('/', $links)) {
		   			$active = 'active';
		   		} else {
		   			$active = '';
		   		}
		   		if ($row->type == 'label') {
		   			if ($ci->aauth->is_allowed($perms)) {
		        		$ret .= '<li class="header treeview">'._ent($row->label).'</li>';
		        	}
		   		} else {
			        if ($row->Count > 0) {
			        	if ($ci->aauth->is_allowed($perms)) {
				        	$ret .= '<li class="'.$active.' "> 
										        	<a href="'.site_url($row->link).'">';

							if ($parent) {
								$ret .= '<i class="fa fa-circle-o '._ent($row->icon_color).'"></i> <span>'._ent($row->label).'</span>
									            <span class="pull-right-container">
									              <i class="fa fa-angle-left pull-right"></i>
									            </span>
									          </a>';
							} else {
								$ret .= '<i class="fa '._ent($row->icon).' '._ent($row->icon_color).'"></i> <span>'._ent($row->label).'</span>
									            <span class="pull-right-container">
									              <i class="fa fa-angle-left pull-right"></i>
									            </span>
									          </a>';
							}

							$ret .= display_menu_admin($row->id, $level + 1);
							$ret .= "</li>";
						}
			        } elseif ($row->Count==0) {
			           if ($ci->aauth->is_allowed($perms)) {
							$ret .= '<li class="'.$active.' "> 
										        	<a href="'.site_url($row->link).'">';

							if ($parent) {
								$ret .= '<i class="fa fa-circle-o '._ent($row->icon_color).'"></i> <span>'._ent($row->label).'</span>
									            <span class="pull-right-container"></i>
									            </span>
									          </a>';
							} else {
								$ret .= '<i class="fa '._ent($row->icon).' '._ent($row->icon_color).'"></i> <span>'._ent($row->label).'</span>
									            <span class="pull-right-container"></i>
									            </span>
									          </a>';
							}

							$ret .= "</li>";
						}
			        }
		   		}

		    	if ($row->id == 14) {
		    		$ret .= cicool()->getSidebar();
		    	}
		    }
		    if ($level != 1) {
		    	$ret .= '</ul>';
	    	}

	    }



	    return $ret;
	}
}

if(!function_exists('set_message')) {
	function set_message($message = null, $type = 'success') {
		$ci =& get_instance();

		$ci->session->set_flashdata('f_message', $message);
        $ci->session->set_flashdata('f_type', $type);
	}
}

if(!function_exists('form_builder')) {
	function form_builder($id = 0) {
		$ci =& get_instance();
		
		$model_form = $ci->load->model('model_form');
		$form = $ci->model_form->find($id);

		if ($form) {
			$form_name = strtolower($form->table_name);
			$ci->template->title($form->title);

			return $ci->load->view('public/'.$form_name.'/' .$form_name, [], true);
		} else {
			return false;
		}
	}
}

if(!function_exists('get_icon_file')) {
	function get_icon_file($file_name = '') {
		$extension_list = [
			'avi' => ['avi'], 
			'css' => ['css'], 
			'csv' => ['csv'], 
			'eps' => ['eps'], 
			'html' => ['html', 'htm'], 
			'jpg' => ['jpg', 'jpeg'], 
			'mov' => ['mov', 'mp4', '3gp'], 
			'mp3' => ['mp3'], 
			'pdf' => ['pdf'], 
			'png' => ['png'], 
			'ppt' => ['ppt', 'pptx'], 
			'rar' => ['rar'], 
			'raw' => ['raw'], 
			'ttf' => ['ttf'],
			'txt' => ['txt'], 
			'wav' => ['wav'], 
			'xls' => ['xls', 'xlsx'], 
			'zip' => ['zip'], 
			'doc' => ['docx', 'doc']
		];

		$file_name_arr = explode('.', $file_name);
		if (is_array($file_name_arr)) {
			foreach ($extension_list as $ext => $list_ext) {
				if (in_array(end($file_name_arr), $list_ext)) {
					return '/asset/img/icon/' . $ext . '.png'; 
				}
			}
		}

		return '/asset/img/icon/any.png';
	}
}

if(!function_exists('check_is_image_ext')) {
	function check_is_image_ext($file_name = '') {
		$extension_list = [
			'jpg' => ['jpg', 'jpeg'], 
			'png' => ['png']
		];

		$file_name_arr = explode('.', $file_name);
		if (is_array($file_name_arr)) {
			foreach ($extension_list as $ext => $list_ext) {
				if (in_array(end($file_name_arr), $list_ext)) {
					return $file_name;
				}
			}
		}

		return get_icon_file($file_name);
	}
}

if(!function_exists('build_rules')) {
	function build_rules($delimiter = '|', $rules = []) {
		if (count($rules)) {
			return $delimiter.implode($delimiter, $rules);
		}
	}
}

if(!function_exists('_ent')) {
	function _ent($string = null) {
		return htmlentities($string);
	}
}

if(!function_exists('dd')) {
	function dd($array) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
}

if(!function_exists('get_captcha')) {
	function get_captcha($string = null) {
		$ci =& get_instance();
		$ci->load->helper('captcha');

		$vals = array(
		        'img_path'      => './captcha/',
		        'img_url'       => base_url('/captcha/'),
		        'font_path'     => './asset/font/captcha.ttf',
		        'img_width'     => '150',
		        'img_height'    => 30,
		        'expiration'    => 7200,
		        'word_length'   => 4,
		        'font_size'     => 15,
		        'img_id'        => 'image-captcha',
		        'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',

		        // White background and border, black text and red grid
		        'colors'        => array(
		                'background' => array(255, 255, 255),
		                'border' => array(255, 255, 255),
		                'text' => array(0, 0, 0),
		                'grid' => array(190, 190, 190)
		        )
		);

		$cap = create_captcha($vals);
		$expiration = time() - 7200; // Two hour limit
		$ci->db->where('captcha_time < ', $expiration)
		        ->delete('captcha');


		$data = array(
		        'captcha_time'  => $cap['time'],
		        'ip_address'    => $ci->input->ip_address(),
		        'word'          => $cap['word']
		);

		$query = $ci->db->insert_string('captcha', $data);
		$ci->db->query($query);


		return $cap;
	}
}

if(!function_exists('display_block_element')) {
	function display_block_element() {
		$ci =& get_instance();
		$ci->load->database();
	    $result = $ci->db->query("SELECT * FROM `page_block_element` GROUP BY `group_name` ")->result();
	    $childs = $ci->db->query("SELECT * FROM `page_block_element`")->result();
	    $child_list = [];

	    foreach ($childs as $row) {
	    	$child_list[$row->group_name][] = $row;
	    }

	    $ret = null;

	    foreach ($result as $row) {
	    	$ret .= '<li><a href="#">'.ucwords($row->group_name).'</a>';
	    	if (isset($child_list[$row->group_name])) {
	    		$ret .= '<ul>';
	    		foreach ($child_list[$row->group_name] as $child) {
	    			$ret .= '<li class="block-item" data-src="'.$child->content.'" data-block-name="'.$child->block_name.'">
				                <div class="nav-content-wrapper noselect">
				                  <i class="fa fa-gear"></i>
				                  <div class="tool-nav delete">
				                    <i class="fa fa-trash"></i> <span class="info-nav">Delete</span>
				                  </div>
				                  <div class="tool-nav source">
				                    <i class="fa fa-code"></i> <span class="info-nav">Source</span>
				                  </div>
				                  <div class="tool-nav copy">
				                    <i class="fa fa-copy"></i> <span class="info-nav">Copy</span>
				                  </div>
				                  <div class="tool-nav handle">
				                    <i class="fa fa-arrows"></i> <span class="info-nav">Move</span>
				                  </div>
				                </div>
				              <img src="'.BASE_ASSET.'img/header10.png" data-src="aadas/asdasd.html" class="preview-only">
				              <div id="element'.$child->id.'" class="block-content"><div class="edit"></div></div>
				            </li>';
	    		}

	    		$ret .= '</ul>';
	    	}
	    	$ret .= '</li>';
	    }
	    return $ret;
	}
}

if(!function_exists('get_extensions')) {
	function get_extensions($type = false) {
		$ci =& get_instance();
		$ci->load->helper('directory');

		$ext_path = FCPATH . 'cc-content/extensions/';

		$dir = directory_map($ext_path, 2);

		$list_extension = [];

		foreach ($dir as $dirname => $childs) {
			if (is_file($ext_path . $dirname . '/ext.json')) {
				$ext_info = file_get_contents($ext_path . $dirname . '/ext.json');
				$ext_info_array = json_decode($ext_info);
				$ext_info_array->path = $ext_path . $dirname;
				$ext_info_array->dirname = $dirname;
				$list_extension[$ext_info_array->type][] = $ext_info_array;
			}
		}

		if ($type !== false) {
			if (isset($list_extension[$type])) {
				return $list_extension[$type];
			}
		} else {
			return $list_extension;
		}

		return false;
	}
}

if(!function_exists('get_installed_extension')) {
	function get_installed_extension() {
		$ci =& get_instance();
		$ci->load->library('cc_extension');
		$extensions = $ci->cc_extension->getExtensions();
		$actived = [];
		foreach ($extensions as $extension) {
			if (is_dir($extension->item->path)) {
				$actived[] = $extension->item->regid;
			}
		}

		return $actived;
	}
}


if(!function_exists('get_page_element')) {
	function get_page_element($group = false) {
		$ci =& get_instance();

		$ci->cc_page_element->get_page_element();
	}
}

if(!function_exists('load_extensions')) {
	function load_extensions() {

		$ci =& get_instance();
		$ci->load->helper('directory');
		$ci->load->library('cc_extension');

		$list_extensions = get_extensions();
		if (!is_array($list_extensions)) {
			return false;
		}

		$ext_load = null;
		$cc_core = get_instance();
		$current_uri = $ci->uri->uri_string;

		foreach ($list_extensions as $type => $extensions) {
			foreach ($extensions as $ext) {
				if (isset($ext->loader)) {
					if (isset($ext->routes)) {
						foreach ($ext->routes as $route) {


							// Convert wildcards to RegEx
							$route = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $route);

							if (preg_match('#^'.$route.'$#', $current_uri, $matches)) {
								foreach ($ext->loader as $filename) {
									if (is_file($ext->path.$filename)) {
										if ($ci->input->method()) {
											$ccExtension = new Cc_extension_item($ext);
											include  $ext->path.$filename;
										}
									}
								}
							}

						}
					} else {
						foreach ($ext->loader as $filename) {
							if (is_file($ext->path.$filename)) {
								if (file_exists($ext->path . 'actived')) {
									if ($ci->input->method() == 'get') {
										$ccExtension = new Cc_extension_item($ext);
										include  $ext->path.$filename;
									} else {
										$ccExtension = new Cc_extension_item($ext);
										ob_start();
										include  $ext->path.$filename;
										$buffer = ob_get_contents();
										ob_end_clean();
									}
								}
							}
						}
					}
				}
			}
		}
		return false;
	}
}

if(!function_exists('url_extension')) {
	function url_extension($ext = null) {
		return FCPATH . 'cc-content/extensions/' . $ext;
	}
}

if(!function_exists('get_option')) {
	function get_option($option_name = null, $default = null) {
		$ci =& get_instance();
		$ci->load->library('cc_app');
		return $ci->cc_app->getOption($option_name, $default);
	}
}

if(!function_exists('add_option')) {
	function add_option($option_name = null, $option_value = null) {
		$ci =& get_instance();
		$ci->load->library('cc_app');
		return $ci->cc_app->addOption($option_name, $option_value);
	}
}

if(!function_exists('set_option')) {
	function set_option($option_name = null, $option_value = null) {
		$ci =& get_instance();
		return $ci->cc_app->setOption($option_name, $option_value);
	}
}

if(!function_exists('delete_option')) {
	function delete_option($option_name = null) {
		$ci =& get_instance();
		return $ci->cc_app->deleteOption($option_name);
	}
}

if(!function_exists('option_exists')) {
	function option_exists($option_name = null) {
		$ci =& get_instance();
		return $ci->cc_app->optionExists($option_name);
	}
}

if(!function_exists('theme_url')) {
	function theme_url($url_additional = null) {
		$ci =& get_instance();
        $active_theme = get_option('active_theme', 'cicool');

        return '/themes/' . $active_theme . '/' . $url_additional;
	}
}

if(!function_exists('theme_asset')) {
	function theme_asset() {
        return theme_url('asset/');
	}
}


if(!function_exists('site_name')) {
	function site_name() {
        return get_option('site_name');
	}
}

if(!function_exists('installation_complete')) {
	function installation_complete() {
		return true;
		return is_file(FCPATH . '/application/config/site.php');
	}
}

if(!function_exists('get_menu')) {
	function get_menu($menu_type = null) {
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->model('model_menu');

		if(is_numeric($menu_type)) {
			$menu_type_id = $menu_type;
		} 
		else {
			$menu_type_id = $ci->model_menu->get_id_menu_type_by_flag($menu_type);
		}


		$menus = $ci->db
			->where(['menu_type_id' =>  $menu_type_id])
			->order_by('sort', 'ASC')
			->get('menu')
			->result();

		$menu_parents = $ci->db
			->where( ['menu_type_id' => $menu_type_id, 'parent' => 0])
			->order_by('sort', 'ASC')
			->get('menu')
			->result();
		

		$new = array();
		foreach ($menus as $a){
		    $new[$a->parent][] = $a;
		}

		$news = array();
		$menus_tree = array();
		foreach ($menus as $a){
		    $news[$a->parent][] = $a;
		}

		foreach ($menu_parents as $new) {
			$menus_tree = array_merge($menus_tree, create_tree($news, array($new)));
		}
		return $menus_tree;
	}
}


if(!function_exists('create_tree')) {
	function create_tree(&$list, $parent) {

	    $tree = array();
	    foreach ($parent as $k=>$l){
	        if(isset($list[$l->id])){

	            $l->children = create_tree($list, $list[$l->id]);
	        }
	        $tree[] = $l;
	    } 
	    return $tree;
	}
}

if(!function_exists('get_header')) {
	function get_header() {
		$ci =& get_instance();
		return $ci->cc_app->getHeader();
	}
}

if(!function_exists('get_footer')) {
	function get_footer() {
		$ci =& get_instance();
		return $ci->cc_app->getFooter();
	}
}

if(!function_exists('get_navigation')) {
	function get_navigation() {
		$ci =& get_instance();
		return $ci->cc_app->getNavigation();
	}
}

if(!function_exists('generate_key')) {
	function generate_key($length = 40) {
		$ci =& get_instance();
        $salt = base_convert(bin2hex($ci->security->get_random_bytes(64)), 16, 36);
        if ($salt === FALSE)
        {
            $salt = hash('sha256', time() . mt_rand());
        }
        $ci->load->config('config');

        $new_key = substr($salt, 0, $length);
        return $new_key;
	}
}

if(!function_exists('get_table_not_allowed_for_builder')) {
	function get_table_not_allowed_for_builder() {
		return [
			'aauth_group_to_group',
			'aauth_groups',
			'aauth_login_attempts',
			'aauth_perm_to_group',
			'aauth_perm_to_user',
			'aauth_perms',
			'aauth_pms',
			'aauth_user',
			'aauth_user_to_group',
			'aauth_user_variables',
			'aauth_users',
			'captcha',
			'cc_options',
			'cc_session',
			'crud',
			'crud_custom_option',
			'crud_field',
			'crud_field_validation',
			'crud_input_type',
			'crud_input_validation',
			'form',
			'form_custom_attribute',
			'form_custom_option',
			'form_field',
			'form_field_validation',
			'keys',
			'menu',
			'menu_icon',
			'menu_type',
			'migrations',
			'page',
			'page_block_element',
			'rest',
			'rest_field',
			'rest_field_validation',
			'rest_input_type',
			'cc_log',
			'cc_block_client',
			'cc_block',
			'cc_visitor'
		];
	}
}

if(!function_exists('my_app')) {
	function my_app() {
		return get_instance();
	}
}

if (!function_exists('getallheaders'))
{
    function getallheaders()
    {
           $headers = '';
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
} 

if (!function_exists('cclang'))
{
    function cclang($langkey = null, $params = [])
    {
    	if (!is_array($params)) {
    		$params = [$params];
    	}

        $lang = lang($langkey);

        $idx = 1;
        foreach ($params as $value) {
        	$lang = str_replace('$'.$idx++, $value, $lang);
        }

        return preg_replace('/\$([0-9])/', '', $lang);
    }
} 

if (!function_exists('get_langs'))
{
    function get_langs()
    {
    	return [
    		[
    			'folder_name' => 'english',
    			'name' => 'English',
    			'initial_name' => 'gb',
    			'icon_name' => 'flag-icon-gb',
    		]
    	];
    }
} 


if (!function_exists('get_current_lang'))
{
    function get_current_lang()
    {
    	$ci =& get_instance();
    	return get_cookie('language') ? get_cookie('language') : $ci->config->item('language');
    }
} 

if (!function_exists('get_current_initial_lang'))
{
    function get_current_initial_lang()
    {
    	$current_lang = get_current_lang();

    	foreach (get_langs() as $lang) {
    		if ($current_lang == $lang['folder_name']) {
    			return $lang['icon_name'];
    		}
    	}
    }
} 



if (!function_exists('get_geolocation')) {
    
    function get_geolocation($ip) {
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));

		if (isset($details->country)) {
			return strtolower($details->country);
		}

		return 'gb';
    }
}


if (!function_exists('get_lang_by_ip')) {
    
    function get_lang_by_ip($ip) {
    	$location = get_geolocation($ip);

    	foreach (get_langs() as $key) {
    		if ($key['initial_name'] == $location) {
    			return $key['folder_name'];
    		}
    	}

    	return 'english';
    }
}


if (!function_exists('debug')) {
    
    function debug($vars = null) {
    	return get_instance()->console->debug($vars);
    }
}


if (!function_exists('cicool')) {
    function cicool() {
    	app()->load->library('cc_app');
    	return app()->cc_app->initialize();
    }
}


if (!function_exists('webPageUrl')) {
    function webPageUrl($page, $params = []) {
    	$params = array_merge(['page' => $page], $params);
    	return site_url('administrator/web-page?'.http_build_query($params));
    }
}

if (!function_exists('recurse_copy')) {
	function recurse_copy($src,$dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	} 
}

if (!function_exists('create_childern')) {

	function create_childern($childern, $parent, $tree) {
	   foreach($childern as $child): 
	   	?>
	    <option <?= $child->id == $parent? 'selected="selected"' : ''; ?> value="<?= $child->id; ?>"><?= str_repeat('----', $tree) ?>   <?= ucwords($child->label); ?></option>
	    <?php if (isset($child->children) and count($child->children)): 
	    $tree++;
	    ?>
	    <?php create_childern($child->children, $parent, $tree); ?>
	    <?php endif ?>
	    <?php endforeach;  
	} 
}

if (!function_exists('extendsObject')) {
	function extendsObject($obj = []) {
		return $obj;
	}
}

/**
 * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
 * array containing the HTTP server response header fields and content.
*/
if(!function_exists('get_web_page')) {
    function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
}