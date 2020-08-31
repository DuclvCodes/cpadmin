<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//CUSTOM
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';
$fo = str_replace("index.php","", $_SERVER['SCRIPT_NAME']);
$base = $base = "$http" . $_SERVER['SERVER_NAME'] . "" . $fo;


defined('BASE_URL') 			OR define('BASE_URL'			, $base);
defined('BASE_ASSET') 			OR define('BASE_ASSET'			, BASE_URL . 'themes/'.BASE_TEMPLATE.'/asset/');
defined('BASE_ASSETV2') 		OR define('BASE_ASSETV2'		, BASE_URL . 'themes/v2/assets/');
defined('URL_IMAGES')			OR define('URL_IMAGES'			, BASE_ASSET.'themes/'.BASE_TEMPLATE.'/images/');

//defined('BASE_ASSET')                   OR define('BASE_ASSET', base_url('asset/')); // highest automatically-assigned error code
defined('VERSION')      		OR define('VERSION', '3.1.8'); // highest automatically-assigned error code

define('DATETIME_FORMAT',   'H:i - d/m');
define('RECORD_PER_PAGE',   10);
define('DOMAIN',            '');
define('ADMIN_DOMAIN',      '');
define('CACHEDB',           'redis');
define('DOMAIN_NAME',       'Pháp Luật Plus');
define('DOMAIN_SHORTNAME',  'PL+');
define('DB_PREFIX',         'default_');
define('MEMCACHE_NAME',     'PLPLUS');
define('MEMCACHE_EXPI',     3600);

define('PCMS_URL',          'phapluatplus.vn');
define('MEDIA_DOMAIN',         'https://media.phapluatplus.vn');
define('MAIL_DOMAIN',       'no-reply@'.DOMAIN);
define('ADS_EMAIL',         'quangcao@'.DOMAIN);

define('GA_NAME',           'phapluatplus');
define('GA_PROFILE_ID',     '109138624');
define('GO_EMAIL',          'phapluatplus-150403@appspot.gserviceaccount.com');
define('CAPTCHA_PUBLIC',    '6LfgKAMTAAAAAM8fFG2qmCDNsHViO-iyt28HPa3K');
define('CAPTCHA_PRIVATE',   '6LfgKAMTAAAAACnTJakh9fwCxJog136xnd6ENa9u');
define('FB_APPID',          '1076004079115399');
define('FB_FANPAGE',        '');
define('FBPAGEID',          '287193141862647');

# FOR CUSTOM
define('BOX_COVER_HOME',    11);
define('BOX_HOTNEWS',       10);
define('BOX_TINMOI',        12);
define('BOX_TOPVIEWS',      14);
define('BOX_VIDEO',         106);
define('BOX_PHOTO',         107);
define('BOX_MEDIA',         107);

define('MAX_TIMERNEWS',     20);
define('CMS_MTL',           30); // Max title length
define('CMS_MIL',           56); // Max intro length

#FOR ADMIN
define('ADMIN_EMAIL',       'ngbacong@gmail.com');

#FOR UPLOAD FILE
define('FTP_SERVER',        '123.31.43.211');
define('FTP_USERNAME',      'ftp_media_ph');
define('FTP_PASSWORD',      '1X0r0o8AAoRgHTMg8gii');
define('MAX_WIDTH',         680);
define('MAX_HEIGHT',        400);
define('MAX_WIDTH_POST',    680);
define('LOCAL_UPLOAD_PATH', FCPATH.'html_admin/uploads/');


# FOR SETTING
define('USE_FTP', 	         true);
define('USE_MEMCACHED', 	 true);

#WEBSITE INFO
define('PAGE_TITLE',        'Pháp Luật Plus');
define('META_DES',          'Pháp Luật Plus (Báo Pháp luật Việt Nam): Cập nhật nhanh nhất các thông tin thời sự, pháp luật, điều tra, bạn đọc, kinh tế, công nghệ...');
define('META_KEY',          'phap luat, phapluatplus, phap luat plus, tap chi phap luat, bao phap luat, tin tuc phap luat, tin phap luat, tro giup phap ly, tu van phap luat, dieu tra');


# GOOGLE reCAPTCHA
$config['google_key'] = '6LckMp8UAAAAAEFFbESXeQF14jegk16264xOoHPu';
$config['google_secret'] = '6LckMp8UAAAAAELS_UPeH6uZyo1Nrb4etdTKeQ3N';