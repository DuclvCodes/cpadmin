<?php
    
    $this->load->model('User_model'); $clsUser = new User_model(); $assign_list['clsUser'] = $clsUser;
    $user_id = $clsUser->getUserID();
    $assign_list['user_id'] = $user_id;
    
    $clsChat = new Chat(); $assign_list['clsChat'] = $clsChat;
    $allChat = $clsChat->getAll("to_user_id='".$user_id."' order by is_viewed, chat_id desc limit 12", true, 'user_'.$user_id);
    $assign_list['allChat'] = $allChat;
