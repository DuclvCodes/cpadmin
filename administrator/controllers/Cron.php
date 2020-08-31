<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Cron extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }
        
    public function index()
    {
        die();
        $clsVideo = new Video_model();
        $clsSystem = new System_model('MEDIA');
        $root = '/home/media/phapluatplus.vn';
        $all = $clsVideo->getAll('image="" order by video_id desc limit 1', false);
        if ($all) {
            foreach ($all as $id) {
                $one = $clsVideo->getOne($id);
                $video = $root.$one['file'];
                $image = '/files/video/'.date('Y/m/d', strtotime($one['reg_date'])).'/'.$id.'.jpg';
                $width = $one['width'];
                $height = $one['height'];
                if ($width>MAX_WIDTH_POST) {
                    $height = intval($height/($width/MAX_WIDTH_POST));
                    $width = MAX_WIDTH_POST;
                }
                $command = 'ffmpeg -itsoffset -'.intval(($one['duration']/2)).' -i '.$video.' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' '.$root.$image;
                $clsSystem->ssh($command);
                echo '<img src="'.MEDIA_DOMAIN.'/'.$image.'" />';
                $clsVideo->updateOne($id, array('image'=>$image));
            }
        }
        //print_r($res);
        die('da xong');
    }
    public function getArrKey()
    {
        $clsNews = new News_model();
        $res = $clsNews->getArrKey($_GET['key']);
        print_r($res);
        die();
    }

    public function getCache()
    {
        $clsNews = new News_model();
        $res = $clsNews->getCache($_GET['key']);
        print_r($res);
        die();
    }

    public function deleteArrKey()
    {
        $clsNews = new News_model();
        $res = $clsNews->deleteArrKey($_GET['key']);
        print_r($res);
        die();
    }

    public function auto_pick()
    {
        die('da xong');
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $clsBox = new Box_model();
        $clsNews = new News_model();
        $allCat = $clsCategory->getChild(0);
        if ($allCat) {
            foreach ($allCat as $cat_id) {
                $box_id = $clsBox->getIDFromCat($cat_id);
                $allNews = $clsNews->getAll($clsNews->getCons($cat_id).' order by news_id desc limit 9');
                if ($allNews) {
                    foreach ($allNews as $news_id) {
                        $clsBox->addNews($box_id, $news_id);
                    }
                }
            }
        }
        die('DONE');
    }
    
    public function ga_min()
    {
        require_once APPPATH.'libraries/Google/autoload.php';
        $service_account_email = GO_EMAIL;
        $key_file_location = APPPATH.'libraries/Google/client_secrets.p12';

        $client = new Google_Client();
        $client->setApplicationName(GA_NAME);

        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials($service_account_email, array(Google_Service_Analytics::ANALYTICS_READONLY), $key);
        $client->setAssertionCredentials($cred);

        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $analytics = new Google_Service_Analytics($client);

        $ids='ga:'.GA_PROFILE_ID;

        $results = $analytics->data_ga->get($ids, date('Y-m-d'), date('Y-m-d'), 'ga:users, ga:pageviews, ga:avgSessionDuration'); // ga:avgTimeOnPage
        $results = $results->totalsForAllResults;
        $res = array();
        $res['visits'] = $results['ga:users'];
        $res['pageviews'] = $results['ga:pageviews'];
        $res['timeOnPage'] = $results['ga:avgSessionDuration'];
        $this->cache->set($res, MEMCACHE_NAME.'GOOGLE_ANALYTICS', 0);

        $today = date('d');
        $results = $analytics->data_ga->get($ids, date('Y-m-d', time()-60*60*24), date('Y-m-d'), 'ga:users', array('dimensions' => 'ga:day, ga:hour'));
        $results = $results->rows;
        $res = array();
        if ($results) {
            foreach ($results as $one) {
                if ($one[0]==$today) {
                    $key = 'today';
                } else {
                    $key = 'yesterday';
                }
                $hours = intval($one[1]);
                $res[$hours][$key] = $one[2];
            }
        }
        $this->cache->set(json_encode($res), MEMCACHE_NAME.'SITE_VISITS', 0);

        $results = $analytics->data_realtime->get($ids, 'rt:activeUsers', array('dimensions' => 'rt:medium'));
        $results = $results->totalsForAllResults;
        $results = $results['rt:activeUsers'];
        $this->cache->set($results, MEMCACHE_NAME.'RIGHT_NOW', 0);

        die('1');
    }
    
    public function clean_views()
    {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $allNews = $clsNews->getAll("views_day>0", false);
        $data = array();
        if ($allNews) {
            foreach ($allNews as $news_id) {
                $oneNews = $clsNews->getOne($news_id);
                #
                $data['views_day'] = '0';
                $data['views_week'] = $oneNews['views_week'];
                $data['views_month'] = $oneNews['views_month'];
                $data['views'] = $oneNews['views'];

                if (date('N')=="1") {
                    $data['views_week'] = '0';
                }
                if (date('d')=="1") {
                    $data['views_month'] = '0';
                }
                #
                $clsNews->updateOne($news_id, $data);
            }
        }
        #
        die('Done');
    }
    
    public function check_topviews()
    {
        $box_topviews_id = BOX_TOPVIEWS;
        $this->load->model('Box_model');
        $clsBox = new Box_model();
        $this->load->model('News_model');
        $clsNews = new News_model();
        #
        $oneBox = $clsBox->getOne($box_topviews_id);
        $max_item = max($oneBox['count_item'], $on['count_item_2']);
        $allNews = $clsNews->getAll($clsNews->getCons().' and push_date like "'.date('Y-m-d').'%" order by views desc limit '.$max_item, false);
        $string = arrayToPath($allNews);
        $clsBox->updateOne($box_topviews_id, array('news_path'=>$string, 'news_path_timer'=>'', 'news_path_show'=>$string));
        #
        print_r('<pre>');
        print_r($allNews);
        print_r('</pre>');
        
        echo 'DONE';
        exit();
    }
    
    public function sphinx()
    {
        $response = shell_exec("indexer idx_exp --rotate");
        echo PHP_EOL.$response;
        die();
    }
    
    public function check_timer()
    {
        $is_update = false;
        $time = time();
        $this->load->model('News_model');
        $this->load->model('Box_model');
        $clsNews = new News_model();
        $clsBox = new Box_model();
        $allBox = $clsBox->getAll('1=1', true, 'CMS');
        if($allBox) foreach($allBox as $box_id) {
            $oneBox = $clsBox->getOne($box_id);
            if($oneBox['news_path_timer']) {
                $news_path_show = $oneBox['news_path'];
                $news_path_timer = $oneBox['news_path_timer'];
                $all_timer = explode('|',trim($news_path_timer,'|'));
                if($all_timer) foreach($all_timer as $one) {
                    $arr = explode(':',$one);
                    $news_id = intval($arr[0]);
                    $push_date = intval($arr[1]);
                    if($push_date>$time) $news_path_show = str_replace('|'.$news_id.'|', '|', $news_path_show);
                    else $news_path_timer = str_replace($one, '', $news_path_timer); $news_path_timer = trim($news_path_timer,'|');
                }
                $news_path_show = trim($news_path_show,'|'); if($news_path_show!=$oneBox['news_path_show']) {
                    $is_update = true;
                    echo 'Fixed '.$box_id.'<br>';
                    $clsBox->updateOne($box_id, array('news_path_show'=>$news_path_show, 'news_path_timer'=>$news_path_timer));
                }
            }
        }
        if ($is_update) {
            $clsBox = new Box_model();
            $clsBox->deleteArrKey('BOX');
            $clsNews = new News_model();
            $clsNews->deleteArrKey('CMS');
            $clsNews->deleteArrKey('SYS');
            $clsNews->deleteArrKey('BOX');
            $clsNews->deleteArrKey();
        }

        die('DONE');
        exit();
    }
    
    public function check_ads()
    {
        $this->load->model('Code_model');
        $this->load->model('Mail_model');
        $this->load->model('Area_model');
        $this->load->model('Ads_model');
        $clsCode = new Code_model();
        $clsAds = new Ads_model();
        $clsArea = new Area_model();
        $clsMail = new Mail_model();
        #
        $allCode = $clsCode->getAll("is_show=1 and todate between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime('+2 day'))."' order by code_id desc limit 100", false);
        if ($allCode) {
            foreach ($allCode as $code_id) {
                $oneCode = $clsCode->getOne($code_id);
                $day_text = '';
                if ($oneCode['todate']==date('Y-m-d')) {
                    $day_text = 'hôm nay';
                } elseif ($oneCode['todate']==date('Y-m-d', strtotime('+1 day'))) {
                    $day_text = 'ngày mai';
                } else {
                    $day_text = 'ngày '.date('d/m/Y', strtotime($oneCode['todate']));
                }

                $subject = 'Thông báo hết hạn treo banner quảng cáo '.$oneCode['title'].' vào '.$day_text;
                $content = '<p>Xin thông báo thời hạn treo banner <b>'.$oneCode['title'].'</b> sẽ hết hạn vào '.$day_text.'. Nếu bên khách hàng có nhu cầu gia hạn thêm, bạn hãy click <a href="https://cms.'.DOMAIN.'/code/edit?id='.$code_id.'" target="_blank">vào đây</a> và cập nhật lại thời hạn treo quảng cáo. Trong trường hợp khách hàng không gia hạn, Hệ thống sẽ tự động chuyển quảng cáo đó về chế độ ẩn. Chúng tôi sẽ không chịu trách nhiệm pháp lý và bồi thường đối với bất kỳ tổn thất hoặc thiệt hại nào phát sinh.</p>';

                $ads_title = '';
                $allAds = $clsAds->getIDs($code_id);
                if ($allAds) {
                    foreach ($allAds as $key=>$id) {
                        $ads_title.=', <a href="https://cms.'.DOMAIN.'/ads/edit?id='.$id.'">'.$clsAds->getTitle($id).'</a>';
                    }
                }
                $allArea = $clsArea->getIDs($code_id);
                if ($allArea) {
                    foreach ($allArea as $key=>$id) {
                        $one=$clsArea->getOne($id);
                        $ads_title.=', <a href="https://cms.'.DOMAIN.'/ads/editcat?id='.$id.'">'.$clsAds->getTitle($one['ads_id']).' ['.$one['title'].']</a>';
                    }
                }
                $ads_title = trim($ads_title, ', ');

                $arr = array('title'=>'<a href="https://cms.'.DOMAIN.'/code/edit?id='.$code_id.'">'.$oneCode['title'].'</a>', 'todate'=>'ngày '.date('d/m/Y', strtotime($oneCode['todate'])), 'kt'=>$oneCode['width'].'x'.$oneCode['height'], 'ads_title'=>$ads_title);
                $arr_f = array('title'=>'Đối tác', 'todate'=>'Thời hạn', 'kt'=>'Kích thước', 'ads_title'=>'Vùng quảng cáo');
                $content .= '<div style="text-align:center;">'.$clsMail->genTable($arr, $arr_f, 'Thông tin quảng cáo').'</div>';
                $content .= '<p>Xin cảm ơn !</p>';
                #
                $clsMail->sendMail(ADS_EMAIL, $subject, $content, 'now', null, 'Quản trị '.DOMAIN_NAME);
            }
        }

        $allCode = $clsCode->getAll("is_show=1 and todate = '".date('Y-m-d', strtotime('-1 day'))."' order by code_id desc limit 100", false);
        if ($allCode) {
            foreach ($allCode as $code_id) {
                $clsCode->updateOne($code_id, array('is_show'=>0));
            }
        }

        echo 'DONE';
        #
        exit();
    }
    
    public function sys_alert()
    {
        $server = isset($_GET['server'])?$_GET['server']:'WEB';
        $value = isset($_GET['value'])?$_GET['value']:'0';
        $type = isset($_GET['type'])?$_GET['type']:'XXX';
        if ($type=='Banwidth') {
            $value .= 'Mb/s';
        }
        $value .= '%';
        #
        $this->load->model('Mail_model');
        $clsMail = new Mail_model();
        $subject = DOMAIN_NAME.' - '.$type.' high usage ['.$value.'] in server '.$server;
        $content = date('H:i - d/m/Y');
        $clsMail->sendMail('ngbacong@gmail.com', $subject, $content);
        #
        exit();
    }
    
    public function ga_news()
    {
        $this->load->model('News_model');
        $clsNews = new News_model();
        
        require_once APPPATH.'libraries/Google/autoload.php';
        $service_account_email = GO_EMAIL;
        $key_file_location = APPPATH.'libraries/Google/client_secrets.p12';
        $client = new Google_Client();
        $client->setApplicationName(GA_NAME);
        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials($service_account_email, array(Google_Service_Analytics::ANALYTICS_READONLY), $key);
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $analytics = new Google_Service_Analytics($client);

        $ids='ga:'.GA_PROFILE_ID;

        if (isset($_GET['news_id'])) {
            $id = $_GET['news_id'];
            $results = $analytics->data_ga->get($ids, date('Y-m-d', strtotime('-30 day')), date('Y-m-d'), 'ga:pageviews', array('filters' => 'ga:pagePath=@-d'.$id.'.html'));
            $results = $results->rows;
            if ($results) {
                $results = $results[0];
                if ($results) {
                    $results = $results[0];
                } else {
                    $results = 0;
                }
            } else {
                $results = 0;
            }
            if ($results) {
                $clsNews->updateOne($id, array('views'=>$results));
            } else {
                $results = 1;
            }
            die(''.$results);
        }

        $key = MEMCACHE_NAME.'_VIEWS';
        $res = $this->cache->get($key);
        if ($res) {
            // || date('i')==0
            if (isset($_GET['all'])) {
                $all = $res;
                $this->cache->set($key, array(), 0);
            } else {
                $all = array();
                foreach ($res as $id=>$views) {
                    if ($views>=5) {
                        $all[$id] = $views;
                        unset($res[$id]);
                    } else {
                        break;
                    }
                }
                $this->cache->set($res, $key, 0);
            }

            if ($all) {
                foreach ($all as $id=>$views) {
                    $oneNews = $clsNews->getOne($id);
                    if (strtotime($oneNews['push_date'])>=strtotime('-30 day')) {
                        $results = $analytics->data_ga->get($ids, date('Y-m-d', strtotime('-30 day')), date('Y-m-d'), 'ga:pageviews', array('filters' => 'ga:pagePath=@-d'.$id.'.html'));
                        $results = $results->rows;
                        if ($results) {
                            $results = $results[0];
                            if ($results) {
                                $results = $results[0];
                            } else {
                                $results = 0;
                            }
                        } else {
                            $results = 0;
                        }
                        if ($results) {
                            $clsNews->updateOne($id, array('views'=>$results));
                            echo 'Update '.$id.': '.$results."\n";
                        }
                    }
                }
            }
        }

        die('1');
    }
    
    public function video_240()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        #
        $allVideo = $clsVideo->getAll('(file_240="" or file_240="null") and width>=426 and height>=240 order by video_id desc limit 0,1', false);

        if ($allVideo) {
            foreach ($allVideo as $video_id) {
                $clsVideo->updateOne($video_id, array('file_240'=>'null'));
                $oneVideo = $clsVideo->getOne($video_id);
                $file = $oneVideo['file'];
                $url2 = MEDIA_DOMAIN.'/cron/video_resize.php?file='.rawurlencode($file).'&size=240';
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $url2);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HEADER, false);
            
                $output=curl_exec($ch2);
                curl_exec($ch2);
                curl_close($ch2);

                $out = str_replace('/files/video/', '/video_240/', $file);
                $clsVideo->updateOne($video_id, array('file_240'=>$out));
                echo $video_id.': '.MEDIA_DOMAIN.$out;
            }
        } else {
            echo 'DONE';
        }
        exit();
    }
    
    public function video_360()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        #
        $allVideo = $clsVideo->getAll('(file_360="" OR file_360="null") and width>=640 and height>=360 order by video_id desc limit 0,1', false);
        if ($allVideo) {
            foreach ($allVideo as $video_id) {
                $clsVideo->updateOne($video_id, array('file_360'=>'null'));
                $oneVideo = $clsVideo->getOne($video_id);
                $file = $oneVideo['file'];
            
                $url2 = MEDIA_DOMAIN.'/cron/video_resize.php?file='.rawurlencode($file).'&size=360';
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $url2);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HEADER, false);
            
                $output=curl_exec($ch2);
                curl_exec($ch2);
                curl_close($ch2);

                $out = str_replace('/files/video/', '/video_360/', $file);
                $clsVideo->updateOne($video_id, array('file_360'=>$out));
                echo $video_id.': '.MEDIA_DOMAIN.$out;
            }
        } else {
            echo 'DONE';
        }
        exit();
    }
    
    public function video_480()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        #
        $allVideo = $clsVideo->getAll('(file_480="" OR file_480="null") and width>=854 and height>=480 order by video_id desc limit 0,1', false);
        if ($allVideo) {
            foreach ($allVideo as $video_id) {
                $clsVideo->updateOne($video_id, array('file_480'=>'null'));
                $oneVideo = $clsVideo->getOne($video_id);
                $file = $oneVideo['file'];
            
                $url2 = MEDIA_DOMAIN.'/cron/video_resize.php?file='.rawurlencode($file).'&size=480';

                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $url2);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HEADER, false);
            
                $output=curl_exec($ch2);
                curl_exec($ch2);
                curl_close($ch2);

                $out = str_replace('/files/video/', '/video_480/', $file);
                $clsVideo->updateOne($video_id, array('file_480'=>$out));
                echo $video_id.': '.MEDIA_DOMAIN.$out;
            }
        } else {
            echo 'DONE';
        }
        exit();
    }
    
    public function video_720()
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        #
        $this->load->model('News_model');
        $clsNews = new News_model();
        $allVideo = $clsVideo->getAll('news_id=0 order by video_id desc limit 1', false);
        if ($allVideo) {
            foreach ($allVideo as $video_id) {
                $allNews = $clsNews->getAll('content like "%/watch/'.$video_id.'%" order by news_id desc limit 1', true, 'CMS');
                if ($allNews) {
                    $clsVideo->updateOne($video_id, array('news_id'=>$allNews[0], 'title'=>$clsNews->getTitle($allNews[0])));
                } else {
                    $clsVideo->updateOne($video_id, array('news_id'=>'-1'));
                }
            }
        }
        #
        $allVideo = $clsVideo->getAll('(file_720="" OR file_720="null") and width>=1280 and height>=720 order by video_id desc limit 0,1', false);
        if ($allVideo) {
            foreach ($allVideo as $video_id) {
                $clsVideo->updateOne($video_id, array('file_720'=>'null'));
                $oneVideo = $clsVideo->getOne($video_id);
                $file = $oneVideo['file'];


                $url2 = MEDIA_DOMAIN.'/cron/video_resize.php?file='.rawurlencode($file).'&size=720';
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $url2);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HEADER, false);
                $output=curl_exec($ch2);
                curl_exec($ch2);
                curl_close($ch2);

                $out = str_replace('/files/video/', '/video_720/', $file);
                $clsVideo->updateOne($video_id, array('file_720'=>$out));
                echo $video_id.': '.MEDIA_DOMAIN.$out;
            }
        } else {
            echo 'DONE';
        }
        exit();
    }
    
    public function check_news()
    {
        error_reporting(-1);
        ini_set('display_errors', 1);
        $box_topviews_id = BOX_TINMOI;
        $this->load->model('Box_model');
        $this->load->model('News_model');
        
        $clsBox = new Box_model();
        $clsNews = new News_model();
        #
        $oneBox = $clsBox->getOne($box_topviews_id);
        $max_item = max($oneBox['count_item'], $on['count_item_2']);
        $query = " status = 4 and is_trash = 0 and push_date <= '".date('Y-m-d H:i:s')."' order by push_date desc limit 10";
        $allNews = $clsNews->getAll($query, false);
        $string = arrayToPath($allNews);
        $clsBox->updateOne($box_topviews_id, array('news_path'=>$string, 'news_path_timer'=>'', 'news_path_show'=>$string));
        $data = $clsBox->getOne($box_topviews_id);
        print_r('<pre>');
        print_r($data);
        print_r('</pre>');
        die();
        #
        echo 'DONE';
        exit();
    }
    
    public function newsAudio() {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $this->load->model('File_model');
        $clsFile = new File_model();
        $this->load->model('NewsAudio_model');
        $clsNewsAudio = new NewsAudio_model();
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        
        $cons = "active_audio = 1";
        $listNews = $clsNews->getAll($cons);
        foreach($listNews as $key => $news_id) {
            $oneNew = $clsNews->getOne($news_id);
            $audio = $clsNewsAudio->getAudioByNews($news_id);
            if(!$audio or ($audio['file_link'] != null and $audio['broken'] == 1)) {
                $localFile = $clsNewsAudio->downloadAudioFile($news_id);
                $filesize = filesize(LOCAL_UPLOAD_PATH."/".$localFile);
                $filesize = round($filesize / 1024, 2); // kilobytes with two digits
                if($filesize > 1000) {
                    $audio_path = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH."/".$localFile,'news_audio',toSlug($oneNew['title']));
                    echo $audio_path.'<br/>';
                    if($clsNewsAudio->checkNews($news_id) > 0) $clsNewsAudio->updateOne($clsNewsAudio->checkNews($news_id),array('file_link'=>$audio_path,'broken'=>false));
                    else $clsNewsAudio->insertOne(array('news_id'=>$news_id,'file_link'=>$audio_path,'broken'=>$broken));
                }
                else $clsNewsAudio->insertOne(array('news_id'=>$news_id,'file_temp'=>$localFile,'broken'=>true));
                
                $keyCache = $clsNewsAudio->getKey($audio['id']);
                $clsNewsAudio->deleteCache($keyCache);
                $clsNewsAudio->updateParam('news_id',$news_id);
            }
        }
        
        die('done');
    }
    
    public function tienich_chungkhoan() {
        
    }
    public function tienich_xoso() {
        
    }
    public function tienich_thoitiet() {
        $this->load->model('Tienich_model');
        $this->load->helper('simple_html_dom');
        
        $thoitiet = $this->Tienich_model->getBySlug('thoi_tiet');
        $html = get_web_page($thoitiet['craw_url']);
        
        if($html['content']) {
            //save to db
            $this->Tienich_model->updateOne($thoitiet['tienich_id'],array('content' => $html['content']));
        }
        die('ok');
    }
}
