<?php
    
    if ($mod=='paper' && $act=='edit' && isset($_GET['id'])) {
        $news_id = $_GET['id'];
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $user_id = $clsUser->getUserID();
        $assign_list['user_id'] = $user_id;
        $assign_list['news_id'] = $news_id;
        
        $clsLog = new PaperLog();
        $assign_list['clsLog'] = $clsLog;
        $allLog = $clsLog->getAll("news_id='".$news_id."' order by log_id", true, 'news_'.$news_id);
        $assign_list['allLog'] = $allLog;
    }
