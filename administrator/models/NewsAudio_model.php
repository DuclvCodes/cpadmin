<?php

/**
*| --------------------------------------------------------------------------
*| News_audio Model
*| --------------------------------------------------------------------------
*| For News_audio model
*|
*/

class NewsAudio_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "id";
        $this->tbl = DB_PREFIX."news_audio";
    }
    public function getLink($_id)
    {
        if (!$_id) {
            return '';
        }
        $res = $this->getOne($_id);
        return $res['file_link'];
    }
    public function checkNews($news_id) {
        if(!$news_id) return false;
        $one = $this->getParam('news_id',$news_id);
        if($one) return $one['id'];
        else return false;
    }
    public function getAudioByNews($news_id) {
        if(!$news_id) return false;
        $one = $this->getParam('news_id',$news_id);
        if($one) return $one;
        else return false;
    }
    
    function downloadAudioFile($news_id) {
        $this->load->model('News_model');
        $clsNews = new News_model();
        
        $oneNew = $clsNews->getOne($news_id);
        $api_key = array('nb4VI8TaL-lCC36pMjrjcFpxD4-9MfkHX8SS9cztCYLpHhIkNmjXJKbWw3YMYXNj');
        $content = strip_tags($oneNew['content']);
        $content = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $content);
        //$data_string_1 = split_string_2_paragraph($data_string,400);
        $post_data = array('text'=>$content,'voice'=>'phamtienquan','id'=>2,'without_filter'=>false,'speed'=>'1.0','tts_return_option'=>2,'timeout'=>60000);
        $localFile = toSlug($oneNew['title']).".wav";
        $fp = fopen(LOCAL_UPLOAD_PATH."/".$localFile, "w+");
        $ch = curl_init('https://vtcc.ai/voice/api/tts/v1/rest/syn');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'token:'. $api_key[0])
            //'Content-Length: ' . strlen($post_data))
        );
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //$result = curl_exec($ch);
        if ( $httpCode == 404 ) {
            return false;
        } else {
            $contents = curl_exec($ch);
            //fwrite($fp, $contents);
        }
        //sleep(60000);
        curl_close($curl);
        fclose($fp);
        return $localFile;
    }
}
