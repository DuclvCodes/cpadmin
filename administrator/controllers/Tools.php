<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tools extends Admin
{
    private $me = '';
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        die('ok');
    }
    
    public function addBoxNews()
    {
        $this->load->model('Box_model');
        $sql = "SELECT category_id FROM tk_box WHERE category_id != 0";
        $result = $this->db->query($sql)->result_array();
        foreach ($result as $key=>$value) {
            $sql2 = "SELECT news_id FROM tk_news WHERE category_id = ".$value['category_id']." ORDER BY RAND() LIMIT 15";
            $result2 = $this->db->query($sql2)->result_array();
            if (count($result2) > 1) {
                foreach ($result2 as $key2=>$value2) {
                    $newsPath[] = $value2['news_id'];
                }
                //update news path
                $this->Box_model->updateOne($value['category_id'], array('news_path'=> arrayToPath($newsPath),'news_path_show'=> arrayToPath($newsPath)));
                unset($newsPath);
            }
        }
        die('ok');
    }
    
    public function replaceImg()
    {
        $this->load->helper('simple_html_dom');
        $this->load->model('News_model');
        $oneNews = $this->News_model->getOne(430264);
        $newImage = $oneNews['image'];
        $content = $oneNews['content'];
        
        $html = str_get_html($content);
        $first_img = $html->find('img');
        foreach ($first_img as $my_image) {
            $newsImage[] = MEDIA_DOMAIN.'/files/Images/'.basename($my_image->src);
        }
        
        print_r('<pre>');
        print_r($newsImage);
        print_r('</pre>');
        die();
        $string = preg_replace('/img.*?src=[\'\"](.*?)[\'\"]/', "img src='http://media.giaoducthoidai.net/files/Images'/$1", $content);
    }
    
    public function convert()
    {
        $this->load->model('News_model');
        $this->load->model('Source_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $this->load->model('Content_model');
        $this->load->database();
        $Source_model = new Source_model();
        $Tags = new Tag_model();
        $News_model = new News_model();
        
        $defaultDB = $this->load->database('default', true);
        $secondDB = $this->load->database('second', true);
        $default->get('table');
        $second->get('different_table');
        
        //get list news from db
        $sql = 'SELECT ContentID FROM contents WHERE is_convert = 0 ORDER BY ContentID DESC LIMIT 0,20000';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $query->free_result();
        foreach ($result as $arr) {
            $oneNew = $this->Content_model->getOne($arr['ContentID']);
            //create source
            //check source id
            if (isset($oneNew['Source']) or $oneNew['Source'] != '') {
                $source_id = $Source_model->slugToID(toSlug($oneNew['Source']));
                if (!$source_id) {
                    $source_id = $Source_model->insertOne(array('title'=>$oneNew['Source'],'slug'=>toSlug($oneNew['Source'])));
                //$Source_model->deleteArrKey('CMS');
                    //$Source_model->deleteArrKey();
                } else {
                    $source_id = '';
                }
            } else {
                $source_id = '';
            }
                
            
            //create tags
            $tags_id = array();
            $array_keyword = explode(',', $oneNew['Keywords']);
            if (count($array_keyword) > 1) {
                foreach ($array_keyword as $key=>$value) {
                    //create tags id
                    
                    //check tag id exits
                    $tag_id = $Tags->slugToID(toSlug($value));
                    if (!$tag_id) {
                        $tags_id[] = $Tags->insertOne(array('title'=>$value,'slug'=>toSlug($value)));
                    //$Tags->deleteArrKey('CMS');
                        //$Tags->deleteArrKey();
                    } else {
                        $tags_id[] = $tag_id;
                    }
                    unset($tag_id);
                }
            }
            
            $insert['news_id'] = $oneNew['ContentID'];
            $insert['title'] = strip_tags($oneNew['Title']);
            $insert['intro'] = $oneNew['Description'];
            $insert['intro_detail'] = '';
            $insert['reg_date'] = $oneNew['CreationDate'];
            $insert['is_trash'] = 0;
            $insert['category_id'] = $oneNew['ZoneID'];
            $insert['news_path'] = '';
            $insert['image'] = $oneNew['Avatar'];
            $insert['slug'] = toSlug($oneNew['Title']);
            $insert['user_id'] = $oneNew['WriterID'];
            $insert['source_id'] = $source_id;
            $insert['content'] = $oneNew['Body'];
            $insert['push_date'] = $oneNew['ModifiedDate'];
            $insert['push_date_mktime']  = strtotime($oneNew['ModifiedDate']);
            $insert['meta_title'] = $oneNew['Title'];
            $insert['meta_description'] = $oneNew['Description'];
            $insert['meta_keyword'] = $oneNew['Keywords'];
            $insert['status'] = 4;
            $insert['tags'] = $oneNew['Keywords'];
            $insert['type_post'] = 1;
            $insert['push_user'] = $oneNew['EditorID'];
            
            $insert['tag_path'] = arrayToPath($tags_id);
            $insert['is_ads'] = ($oneNew['HasAds'] != '') ? $oneNew['HasAds'] : 0;
            $insert['is_comment'] = $oneNew['AllowComment'];
            $insert['signature'] = $oneNew['Author'];

            //create news

            $news_id = $News_model->insertOne($insert);
            //$News_model->deleteArrKey('CMS');
            //$News_model->deleteArrKey();
            $this->db->trans_start();
            $query = $this->db->query('UPDATE contents SET is_convert = 1 WHERE ContentID='.$oneNew['ContentID']);
            //$res = $this->db->affected_rows();
            $this->db->trans_complete();

            echo "----- ".$news_id."    ".$oneNew['Title']."\n";

            unset($oneNew);
            unset($insert);
            unset($relate_array);
            unset($array_keyword);
            unset($category_id);
            unset($news_id);
            unset($tags_id);
            unset($source_id);
            flush();
            ob_flush();
        }
        $query->free_result();
    }

    /**
     * insert News to database
     */
    public function insertNews()
    {
        error_reporting(E_ALL);
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->model('News_model');
        $this->load->model('Source_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        for ($i=1;$i<13;$i++) {
            $folder = FCPATH.'files/2015/'.$i.'/';
            
            $map = directory_map($folder, false, true);

            foreach ($map as $key_map => $value_map) {
                $file_path = $folder.$key_map.'content.json';
                //$file_path = FCPATH.'files/2014/1/2-truong-dh-viet-nam-chiu-trach-nhiem-ve-olympic-hoa-hoc-quoc-te-2014-72917-v/content.json';
                if (file_exists($file_path)) {
                    $file_content = file_get_contents($file_path);
                    $data = json_decode(remove_utf8_bom($file_content), true);
                    unset($file_path);
                    unset($file_content);

                    $date_time = strtotime($data['date_time']) - 3600*8;
                    $slug_2 = explode('-', $data['slug']);
                    
                    
                    $News_model = new News_model();
                    //check newsID
                    if (count($slug_2) < 1) {
                        echo "----- ".$slug_2." not found ! \n";
                        
                        flush();
                        ob_flush();
                        continue;
                    } else {
                        $insert = array();
                        $news_id = $slug_2[count($slug_2)-2];
                        $oneNew = $News_model->getOne($news_id);
                        if (!$oneNew) {
                            //create source
                            $Source_model = new Source_model();
                            //check source id
                            $source_id = $Source_model->slugToID(toSlug($data['source']));
                            if (!$source_id) {
                                $source_id = $Source_model->insertOne(array('title'=>$data['source'],'slug'=>toSlug($data['source'])));
                                //$Source_model->deleteArrKey('CMS');
                            //$Source_model->deleteArrKey();
                            }

                            //create category id
                            $Category = new Category_model();
                            //check category id exits
                            $category_id = $Category->slugToID(toSlug($data['category']));
                            if (!$category_id) {
                                $category_id = $Category->insertOne(array('title'=>$data['category'],'slug'=>toSlug($data['category'])));
                                //$Category->deleteArrKey('CMS');
                            //$Category->deleteArrKey();
                            }

                            $tags_id = array();
                            $array_keyword = explode(',', $data['meta_keywords']);
                            if (count($array_keyword) > 1) {
                                foreach ($array_keyword as $key=>$value) {
                                    //create tags id
                                    $Tags = new Tag_model();
                                    //check tag id exits
                                    $tag_id = $Tags->slugToID(toSlug($value));
                                    if (!$tag_id) {
                                        $tags_id[] = $Tags->insertOne(array('title'=>$value,'slug'=>toSlug($value)));
                                    //$Tags->deleteArrKey('CMS');
                                    //$Tags->deleteArrKey();
                                    } else {
                                        $tags_id[] = $tag_id;
                                    }
                                    unset($tag_id);
                                }
                            }
                            

                            //insert news path
                            $relate_array = array();
                            if (count($data['relate_news']) > 0) {
                                foreach ($data['relate_news'] as $relate_key => $relate_value) {
                                    $slug_relate = explode('-', $relate_value['slug']);
                                    $relate_array[] = $slug_relate[count($slug_relate)-2];
                                    unset($slug_relate);
                                }
                            }

                            $media_main = isset(explode('?', $data['media_main'])[0]) ? explode('?', $data['media_main'])[0] : $data['media_main'];
                            $insert['news_id'] = $news_id;
                            $insert['title'] = strip_tags($data['title']);
                            $insert['intro'] = $data['summary'];
                            $insert['intro_detail'] = '';
                            $insert['reg_date'] = date('Y-m-d H:i:s', $date_time);
                            $insert['is_trash'] = 0;
                            $insert['category_id'] = $category_id;
                            if (count($relate_array) > 1) {
                                $insert['news_path'] = arrayToPath($relate_array);
                            } else {
                                $insert['news_path'] = '';
                            }
                            $insert['image'] = $media_main;
                            $insert['slug'] = $data['slug'];
                            $insert['user_id'] = -1;
                            $insert['source_id'] = $source_id;
                            $insert['content'] = $data['description'];
                            $insert['push_date'] = date('Y-m-d H:i:s', $date_time);
                            $insert['push_date_mktime']  = strtotime($data['date_time']);
                            $insert['meta_title'] = $data['title'];
                            $insert['meta_description'] = $data['meta_description'];
                            $insert['meta_keyword'] = $data['meta_keywords'];
                            $insert['status'] = 4;
                            $insert['tags'] = $data['meta_keywords'];
                            $insert['type_post'] = 1;
                            $insert['push_user'] = 1;
                            $insert['link'] = $data['post_url'];
                            $insert['tag_path'] = arrayToPath($tags_id);
                            $insert['is_ads'] = 0;
                            $insert['is_comment'] = 1;
                            $insert['signature'] = strip_tags($data['author']);

                            //create news

                            $news_id = $News_model->insertOne($insert);
                            //$News_model->deleteArrKey('CMS');
                            //$News_model->deleteArrKey();

                            //print_r('<pre>');
                            //print_r($news_id.'    '.$data['slug']);
                            //print_r('</pre>');
                        
                            echo "----- ".$news_id."    ".$data['slug']."\n";

                            unset($data);
                            unset($insert);
                            unset($relate_array);
                            unset($array_keyword);
                            unset($category_id);
                            unset($news_id);
                            unset($media_main);
                            unset($News_model);
                            unset($Source_model);
                            unset($Category_model);
                            unset($Source_model);
                            unset($tags_id);
                            unset($source_id);
                            flush();
                            ob_flush();
                        //sleep(1);
                        } else {
                            echo "----- ".$news_id." has inserted ! \n";
                            unset($oneNew);
                            flush();
                            ob_flush();
                            //sleep(1);
                            continue;
                        }
                    }
                } else {
                    //print_r('<pre>');
                    print_r("file not exits ".$value_map."\n");
                    //print_r('</pre>');
                    //print_r('<pre>');
                    //print_r();
                    //print_r('</pre>');

                    flush();
                    ob_flush();
                    //sleep(1);
                }
            }
        }
        echo "Working done well !";
        die();
    }
    
    /**
     * get json file and insert to database
     */
    public function myjson()
    {
        error_reporting(E_ALL);
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->model('News_model');
        $this->load->model('Source_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $map = directory_map(FCPATH.'files/2014/1/', false, true);
        //$file_path = FCPATH.'files/2014/1/'.array_keys($map)[0].'content.json';
        $file_path = FCPATH.'files/2014/1/2-truong-dh-viet-nam-chiu-trach-nhiem-ve-olympic-hoa-hoc-quoc-te-2014-72917-v/content.json';
        $file_content = file_get_contents($file_path);
        $data = json_decode(remove_utf8_bom($file_content), true);
        $date_time = strtotime($data['date_time']) - 3600*8;
        
        print_r('<pre>');
        print_r($data);
        print_r('</pre>');
        die();
        
        //create source
        $Source_model = new Source_model();
        //check source id
        $source_id = $Source_model->slugToID(toSlug($data['source']));
        if (!$source_id) {
            $Source_model->insertOne(array('title'=>$data['source'],'slug'=>toSlug($data['source'])));
            $Source_model->deleteArrKey('CMS');
            $Source_model->deleteArrKey();
            $source_id = $Source_model->getMaxID('CMS');
        }
            
        //create category id
        $Category = new Category_model();
        //check category id exits
        $category_id = $Category->slugToID(toSlug($data['category']));
        if (!$category_id) {
            $Category->insertOne(array('title'=>$data['category'],'slug'=>toSlug($data['category'])));
            $Category->deleteArrKey('CMS');
            $Category->deleteArrKey();
            $category_id = $Category->getMaxID('CMS');
        }
        
        $tags_id = array();
        foreach ($data['meta_keywords'] as $key=>$value) {
            //create tags id
            $Tags = new Tag_model();
            //check tag id exits
            $tag_id = $Tags->slugToID(toSlug($value));
            if (!$tag_id) {
                $Tags->insertOne(array('title'=>$value,'slug'=>toSlug($value)));
                $Tags->deleteArrKey('CMS');
                $Tags->deleteArrKey();
                $tags_id[] = $Tags->getMaxID('CMS');
            } else {
                $tags_id[] = $tag_id;
            }
            unset($tag_id);
        }
            
        
        
        $slug_2 = explode('-', $data['slug']);
        $insert['news_id'] = $slug_2[count($slug_2)-2];
        $insert['title'] = $data['title'];
        $insert['intro'] = $data['meta_description'];
        $insert['intro_detail'] = '';
        $insert['reg_date'] = date('d-m-Y H:i:s', $date_time);
        $insert['is_trash'] = 0;
        $insert['category_id'] = $category_id;
        $insert['news_path'] = '';
        $insert['image'] = $data['media_main'];
        $insert['slug'] = $data['slug'];
        $insert['user_id'] = -1;
        $insert['source_id'] = $source_id;
        $insert['content'] = $data['summary'];
        $insert['reg_date'] = date('d-m-Y H:i:s', $date_time);
        $insert['meta_title'] = $data['title'];
        $insert['meta_description'] = $data['meta_description'];
        $insert['meta_keyword'] = $data['meta_keyword'];
        $insert['status'] = 1;
        $insert['tags'] = $data['meta_keyword'];
        $insert['type_post'] = 1;
        $insert['push_user'] = 1;
        $insert['link'] = $data['post_url'];
        $insert['tag_path'] = arrayToPath($tags_id);
        $insert['is_ads'] = 0;
        $insert['is_comment'] = 1;
        $insert['signature'] = $data['author'];
        
        //create news
        $News_model = new News_model();
        $News_model->insertOne($insert);
        $News_model->deleteArrKey('CMS');
        $News_model->deleteArrKey();
        $news_id = $News_model->getMaxID('CMS');
        object_start();
        print_r('<pre>');
        print_r($news_id);
        print_r('</pre>');
        flush();
        ob_flush();
        sleep(1);
        die();
        
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
        }

        echo PHP_EOL;
        die();
    }
    
    public function downloadMedia($file, $type = 'image')
    {
        $url=base_url();
        $filename = basename($file);
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
                return $filename;
            //return true;
            } else {
                return 'not success';
                //return false;
            }
        } else {
            return 'file not exits';
        }
        return false;
    }
    
    public function testWatermark()
    {
        $logo = FCPATH.'html/watermark/mark2.png';
        $image = FCPATH.'html/watermark/imagetest.jpg';
        $new_image = FCPATH.'html/watermark/new.jpeg';
        
        $imgConfig = array();
        $imgConfig['image_library'] = 'GD2';
        $imgConfig['source_image']  = $image;
        $imgConfig['wm_type']       = 'overlay';
        $imgConfig['wm_opacity'] = 100;

        $imgConfig['wm_vrt_alignment'] = 'bottom';
        $imgConfig['wm_hor_alignment'] = 'right';
        $imgConfig['wm_overlay_path'] = $logo;
        


        $this->load->library('image_lib', $imgConfig);

        $this->image_lib->initialize($imgConfig);

        $this->image_lib->watermark();
        if (!$this->image_lib->watermark()) {
            die($this->image_lib->display_errors());
        }
        
        if ($image) {
            die('ok');
        } else {
            die('error');
        }
    }
    
    public function testUser()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        print_r('<pre>');
        print_r($_COOKIE);
        print_r('</pre>');
        print_r('<pre>');
        print_r($_SESSION);
        print_r('</pre>');
        die();
        $assign_list['me'] = $me;
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
    }
    
    public function testGetNew()
    {
        $this->load->helper('simple_html_dom');
        $url = 'https://tuoitre.vn/xe-7-cho-huc-do-dai-phan-cach-roi-lao-xuong-ho-truc-bach-20181217171104412.htm';
        $html = file_get_html($url);
        
        //remove node
        foreach ($html->find('div[type=RelatedOneNews]') as $node) {
            $node->outertext = '';
        }
//        foreach ($html->find('div[class=PhotoCMS_Caption]') as $key=>$element)
//        {
//            $html->find('div[class=PhotoCMS_Caption]',$key)->outertext="<figcaption>".$element->innertext."</figcaption>";
//        }
        $html->save();
        // get title
        $ret['title'] = $html->find('h1[class=article-title]', 0)->innertext;
        $ret['sapo'] = $html->find('h2[class=sapo]', 0)->innertext;
        $content = $html->find('div[id=main-detail-body]', 0);
        
        //to fetch all images from a webpage
        $images = array();
        foreach ($content->find('img') as $key_image => $img) {
            $images[$key_image] = $img->src;
            $listImage[] = $this->downloadMedia($images[$key_image]);
        }
        $ret['content'] = $content->innertext;
        print_r('<pre>');
        print_r($images);
        print_r('</pre>');
        print_r('<pre>');
        print_r($listImage);
        print_r('</pre>');
        //handling memory
        $html->clear();
        unset($html);
        print_r('<pre>');
        print_r($ret);
        print_r('</pre>');
        die();
    }
    
    public function scraping_IMDB()
    {
        $this->load->helper('simple_html_dom');
        $url = 'https://www.imdb.com/title/tt1477834';
        // create HTML DOM
        $html = file_get_html($url);

        // get title
        $ret['Title'] = $html->find('title', 0)->innertext;

        // get rating
        $ret['Rating'] = $html->find('div[class="ratingValue"] span', 0)->innertext;

        // get overview
        foreach ($html->find('div[class="info"]') as $div) {
            // skip user comments
            if ($div->find('h5', 0)->innertext=='User Comments:') {
                return $ret;
            }

            $key = '';
            $val = '';

            foreach ($div->find('*') as $node) {
                if ($node->tag=='h5') {
                    $key = $node->plaintext;
                }

                if ($node->tag=='a' && $node->plaintext!='more') {
                    $val .= trim(str_replace("\n", '', $node->plaintext));
                }

                if ($node->tag=='text') {
                    $val .= trim(str_replace("\n", '', $node->plaintext));
                }
            }

            $ret[$key] = $val;
        }

        // clean up memory
        $html->clear();
        unset($html);
        print_r('<pre>');
        print_r($ret);
        print_r('</pre>');
        die();
        return $ret;
    }
    
    public function testGetFile()
    {
        $this->load->model('File_model');
        $clsFile = new File_model();
        $file_url = 'https://image.giaoducthoidai.vn/dataimages/200906/original/images36495_0c5f1-250609-1.jpg?width=500';
        $file_url = strtok($file_url, '?');
        $param = parse_url($file_url);
        $file_encode = urldecode($file_url);
        //$filename = basename($file);
        $ext = pathinfo($file_encode, PATHINFO_EXTENSION); // To get extension
        $name2 =pathinfo($file_encode, PATHINFO_FILENAME); // File name without extension
        $filename = $name2.'.'.$ext;
        $ftp_path = 'epi'.str_replace($filename, '', $param['path']);
        
        $new_file = $clsFile->downloadMedia($file_url, 'video', '', $ftp_path);
        print_r('<pre>');
        print_r($new_file);
        print_r('</pre>');
        die();
    }
    public function testRedis() {
        $this->load->library('redis', array('connection_group' => 'slave'), 'redis_slave');
        $this->load->model('Box_model');
        $status = $this->redis->command('PING');
        $this->redis->set('PLPLUS_BOX_desktopcache_block_v2_pick_', 'tesststs');
        $this->redis->del('foo');
        print_r('<pre>');
        print_r($this->Box_model->getArrKey('BOX'));
        print_r('</pre>');
        die();
        print_r('<pre>');
        print_r($this->redis->get('PLPLUS_BOX_DESK_desktopcache_block_v2_pick_list_image_pick'));
        print_r('</pre>');
        die();
    }
    public function testmp3() {
        $this->load->model('News_model');
        $clsNews = new News_model();
        $this->load->model('File_model');
        $clsFile = new File_model();
        $this->load->model('NewsAudio_model');
        $clsNewsAudio = new NewsAudio_model();
        $this->load->model('Image_model');
        $clsImage = new Image_model();
        
        $api_key = array('nb4VI8TaL-lCC36pMjrjcFpxD4-9MfkHX8SS9cztCYLpHhIkNmjXJKbWw3YMYXNj');
        #Xác định các giọng đọc, voice có các giá trị là leminh (giọng nam miền bắc), male (giọng nam miền bắc),
        #female (giọng nữ miền bắc), hatieumai (giọng nữ miền nam), ngoclam (giọng nữ Huế)
        
        # Xác định các giọng đọc, voice có các giá trị là:
        # leminh (giọng nam miền bắc nghe ấm ), 
        # male (giọng nam miền bắc hơi già có tiếng thở),
        # female (giọng nữ miền bắc trẻ, giọng trong đọc hơi chậm so với các giọng khác), 
        # hatieumai (giọng nữ miền nam nghe đk), 
        # ngoclam (giọng nữ Huế  đọc hơi bị ngắt nên cho chậm lại)
        $voice = 'male';
        $speed = 0;
        #ngữ điệu 1 on. 0 off
        $prosody = 1;
        
        $news_id = 95046;
        $oneNew = $clsNews->getOne($news_id);
        $localFile = $clsNewsAudio->downloadAudioFile($news_id);
        $filesize = filesize(LOCAL_UPLOAD_PATH."/".$localFile);
        $filesize = round($filesize / 1024, 2); // kilobytes with two digits
        if($filesize > 1000) {
            $audio_path = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH."/".$localFile,'news_audio',toSlug($oneNew['title']));
            if($clsNewsAudio->checkNews($news_id) > 0) $clsNewsAudio->updateOne($clsNewsAudio->checkNews($news_id),array('file_link'=>$audio_path,'broken'=>false));
            else $clsNewsAudio->insertOne(array('news_id'=>$news_id,'file_link'=>$audio_path,'broken'=>$broken));
        }
        else $clsNewsAudio->insertOne(array('news_id'=>$news_id,'file_temp'=>$localFile,'broken'=>true));
        //$data_return = json_decode($result,true);
        
        print_r('<pre>');
        print_r(json_encode($post_data));
        print_r('</pre>');
        
        print_r('<pre>');
        print_r($audio_path);
        print_r('</pre>');
        die();
        //curl --header "Content-Type: application/json" --header "token: nb4VI8TaL-lCC36pMjrjcFpxD4-9MfkHX8SS9cztCYLpHhIkNmjXJKbWw3YMYXNj"   --request POST   --data "@data.json" https://vtcc.ai/voice/api/tts/v1/rest/syn > example.wav
        //if(count($data_string_1)>1) {
//            foreach($data_string_1 as $key => $post_data) {
//                
//                if(isset($data_return['error']) and $data_return['error'] == 0) {
//                    $file_name = toSlug($oneNew['title'].'_'.$key);
//                    $new_file = $clsFile->downloa2Local($data_return['async'], 'video', $file_name);
//                    $group_link[$key] = $new_file;
//                    sleep(2);
//                }else {
//                    $broken = 1;
//                    $group_link[$key] = 'error';
//                }
//                unset($file_name);
//                unset($post_data);
//                unset($data_return);
//            }
//            $clsNewsAudio->insertOne(array('news_id'=>$news_id,'file_temp'=>json_encode($group_link),'broken'=>$broken));
//        }
//        print_r('<pre>');
//        print_r($group_link);
//        print_r('</pre>');
//        die();
    }
}
