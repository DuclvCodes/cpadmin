$(document).ready(function(){
    var me_id, me_avatar;
    var i_index_chat = 5555;
    
    me_id           = $('#tkp_my_profile .username').attr('data-id');
    me_avatar       = $('#tkp_my_profile img').attr('src').replace('/resize_29x29/', '/resize_55x55/');
    
    if(socket!=null) {
        socket.on(chat_key+'msg_'+me_id, function(data) {
            var msg = JSON.parse(data);
            open_chat(msg.room);
            var e = $('#nodeChat_'+msg.room);
            appendMsg(e, msg.from, msg.message);
            if(e.hasClass('green')) markRead(msg.room);
            else e.removeClass('grey').addClass('green');
        });
        
        socket.on('init', function(me_id) {
            //
        });
        
        socket.on('online', function(user_id) {
            alert('Online: '+user_id)
        });
        
        socket.on('offline', function(user_id) {
            alert('Offline: '+user_id)
        });
    }
    else $('#alert_system').show().find('div').html('Hệ thống chat đang dừng hoạt động. Click <a href="/cron/start_nodejs.php" target="_blank">vào đây</a> để khắc phục');
    
    $('.btn_ichat').click(function() {
        var room = $(this).attr('data-id');
        open_chat(room);
        $('#nodeChat_'+room).click();
        $('#header_inbox_bar').removeClass('open');
        
        var badge = $(this).find('.badge').text();
        badge = parseInt(badge);
        if(badge>0) {
            $(this).find('.badge').remove();
            badge = parseInt($('#lbl_sum_message').text()) - badge;
            if(badge>0) $('#lbl_sum_message').text(badge);
            else $('#lbl_sum_message').remove();
            markRead($(this).attr('data-id'));
        }
        
        return false;
    });
    
    function markRead(room) {
        $.ajax({type: "GET", url: "/api/markRead", data:  {room: room}, dataType: "html", success: function(msg){}});
    }
    function makeRoom(array_user) {
        array_user.sort();
        return '_'+array_user.join('_')+'_';
    }
    function explodeRoom(str) {
        str = str.replace('_'+me_id+'_', '_');
        str = str.substring(1, str.length-1);
        var allUser = str.split('_');
        if(typeof allUser === 'string') allUser = [allUser];
        return allUser;
    }
    function getAvatar(user_id) {
        return $('#tkp_oneuser_'+user_id).find('img').attr('src');
    }
    function getFullname(user_id) {
        return $('#tkp_oneuser_'+user_id).find('.from').text();
    }
    
    function open_chat(room) {
        if($('#nodeChat_'+room).length) $('#nodeChat_'+room).addClass('focus');
        else {
            var title = '';
            var allUser = explodeRoom(room);
            allUser.forEach(function(user_id) {
                title += ', '+getFullname(user_id);
            });
            title = title.substring(2, title.length);
            
            $('#tkp_chat_extention').append('<div id="nodeChat_'+room+'" class="nodeChat portlet box grey"><div class="portlet-title bar_move"><div class="caption"><i class="icon-comment"></i> <span class="letter">'+title+'</span></div><div class="tools"> <a href="#" class="collapse"></a><a href="#" class="config"></a> <a href="#" class="remove btn_close"></a> </div></div><div class="js_scoll"><div class="portlet-body"><ul class="chats"><li style=" text-align: center; width: 100%; "><a href="#" class="btn_loadmore" data-mid="0">Tải thêm tin nhắn cũ</a><img src="/ucp/themes/img/input-spinner.gif" style="display: none;"></li></ul></div></div><div class="chatFoot"><div class="chat-form"><div class="input-cont"><input class="m-wrap inp_text" type="text" placeholder="Type a message here..."></div><div class="btn-cont"><span class="arrow"></span><a href="" class="btn blue icn-only btn_send" data-room="'+room+'"><i class="icon-ok icon-white"></i></a></div></div></div><div class="chatPopup"><div class="win_user"></div><div class="win_invite"></div></div></div>');
            event_chat($('#nodeChat_'+room));
            $('#nodeChat_'+room+' .btn_loadmore').click();
        }
        focus_chat($('#nodeChat_'+room));
        $('#nodeChat_'+room).find('input[type=text]').focus();
    }
    function focus_chat($obj) {
        i_index_chat++;
        $obj.show().css('z-index', i_index_chat);
    }
    function appendMsg($obj, user_id, msg) {
        var html;
        var currentTime = new Date();
        currentTime = '<span title="'+currentTime.toString('dd/MM/yy, hh:mm tt')+'">'+currentTime.toString('hh:mm tt')+'</span>';
        if(user_id==me_id) html = '<li class="out"><img class="avatar" src="'+me_avatar+'"><div class="message"><span class="body">'+msg+'</span><span class="arrow"></span><span class="name">TÔI</span><span class="datetime">&nbsp; &#8226; &nbsp; '+currentTime+'</span></div></li>';
        else html = '<li class="in"><img class="avatar" src="'+getAvatar(user_id)+'"><div class="message"><span class="body">'+msg+'</span><span class="arrow"></span><span class="name">'+getFullname(user_id)+'</span><span class="datetime">&nbsp; &#8226; &nbsp; '+currentTime+'</span></div></li>';
        $obj.find('ul.chats').append(html);
        $obj.find('.js_scoll').mCustomScrollbar("scrollTo","last");
    }
    function event_chat($obj) {
        $obj.find('.js_scoll').mCustomScrollbar();
        $obj.click(function(){
            $('.nodeChat.active').removeClass('active');
            $obj.addClass('active');
            if($obj.hasClass('green')) {
                $obj.removeClass('green').addClass('grey');
                markRead($obj.find('.btn_send').attr('data-room'));
            }
        });
        $obj.find('.btn_loadmore').click(function(){
            $(this).hide().parents('li').find('img').show();
            var _this = $(this).parents('li');
            var mid = $(this).attr('data-mid');
            $.ajax({
        		type: "GET",
        		url: "/api/getChat",
        		data:  {room: $obj.find('.btn_send').attr('data-room'), mid: mid},
        		dataType: "html",
        		success: function(msg){
        			if(msg=='0') {
                        _this.remove();
        			}
                    else {
                        var data = jQuery.parseJSON(msg);
                        var html = '';
                        var k = 0;
                        var currentTime;
                        $.each(data, function(i, item) {
                            currentTime = new Date(item.reg_date);
                            currentTime = '<span title="'+currentTime.toString('dd/MM/yy, hh:mm tt')+'">'+currentTime.toString('hh:mm tt')+'</span>';
                            if(item.user_id==me_id) html = '<li class="out"><img class="avatar" src="'+me_avatar+'"><div class="message"><span class="body">'+item.message+'</span><span class="arrow"></span><span class="name">TÔI</span><span class="datetime">&nbsp; &#8226; &nbsp; '+currentTime+'</span></div></li>'+html;
                            else html = '<li class="in"><img class="avatar" src="'+getAvatar(item.user_id)+'"><div class="message"><span class="body">'+item.message+'</span><span class="arrow"></span><span class="name">'+getFullname(item.user_id)+'</span><span class="datetime">&nbsp; &#8226; &nbsp; '+currentTime+'</span></div></li>'+html;
                            k++;
                            mid = item.chat_id;
                        });
                        _this.after(html);
                        _this.find('a').show().attr('data-mid', mid);
                        _this.find('img').hide();
                        if(k<10) _this.remove();
                        $obj.find('.js_scoll').mCustomScrollbar("scrollTo","first");
                    }
        		}
        	});
            return false;
        });
        $obj.find('.tools .collapse').click(function(){
            //
        });
        $obj.find('.tools .config').click(function(){
            $obj.find('.chatPopup').show();
            if($obj.find('.chatPopup .win_user').html()=='') {
                var html = '';
                var allUser = $obj.find('.btn_send').attr('data-room').replace('_'+me_id+'_', '_').split('_');
                var memInRoom = $obj.find('.btn_send').attr('data-room').split('_'); memInRoom.shift(); memInRoom.pop();
                allUser.forEach(function(entry) {
                    if(entry) {
                        html += '<li data-id="'+entry+'"><span class="photo"><img src="'+getAvatar(entry)+'"></span><span class="from">'+getFullname(entry)+'</span></li>';
                    }
                });
                $e = $('<ul class="listUser"><li class="add"><span class="photo"><b>+</b></span><span class="from">Thêm vào nhóm</span></li>'+html+'</ul><div class="row-fluid"><a href="#" class="btn_close btn grey span6">Hủy bỏ</a><a href="#" class="btn red span6 btn_out">Rời nhóm</a></div>');
                
                $e.find('.add').click(function(){
                    $obj.find('.chatPopup .win_user').hide();
                    $obj.find('.chatPopup .win_invite').show();
                    if($obj.find('.chatPopup .win_invite').html()=='') {
                        var html2 = '';
                        var allUser2 = $('#wrap_chat_listuser').attr('data-user').replace('_'+me_id+'_', '_').split('_');
                        allUser2.forEach(function(entry) {
                            if(entry) if(allUser.indexOf(entry) == -1) {
                                html2 += '<li data-id="'+entry+'"><span class="photo"><img src="'+getAvatar(entry)+'"></span><span class="from">'+getFullname(entry)+'</span><i class="icon-ok"></i></li>';
                            }
                        });
                        $e2 = $('<ul class="listUser">'+html2+'</ul><div class="row-fluid"><a href="#" class="btn_close btn grey span6">Quay lại</a><a href="#" class="btn blue span6 btn_add">Thêm</a></div>');
                        $e2.find('li').click(function(){
                            if($(this).hasClass('active')) $(this).removeClass('active');
                            else $(this).addClass('active');
                            return false;
                        });
                        $e2.find('.btn_close').click(function(){
                            $obj.find('.chatPopup .win_user').show();
                            $obj.find('.chatPopup .win_invite').hide();
                            return false;
                        });
                        $e2.find('.btn_add').click(function(){
                            $obj.find('.chatPopup ul.listUser li').each(function(){
                                if($(this).hasClass('active')) {
                                    var id = $(this).attr('data-id');
                                    $(this).remove();
                                    $obj.find('.chatPopup .win_user .listUser').append('<li data-id="'+id+'"><span class="photo"><img src="'+getAvatar(id)+'"></span><span class="from">'+getFullname(id)+'</span></li>');
                                    memInRoom.push(id);
                                }
                            });
                            memInRoom.sort();
                            var letter = '';
                            var path_id = '_'+memInRoom.join('_')+'_';
                            $obj.find('.btn_send').attr('data-room', path_id);
                            $obj.attr('id', 'nodeChat_'+path_id);
                            
                            memInRoom.forEach(function(entry) {
                                if(entry) if(entry!=me_id) {
                                    if(letter) letter += ', '+getFullname(entry);
                                    else letter = getFullname(entry);
                                }
                            });
                            $obj.find('.letter').text(letter).attr('title', letter);
                            $e2.find('.btn_close').click();
                            $e.find('.btn_close').click();
                            return false;
                        });
                        $e2.appendTo($obj.find('.chatPopup .win_invite'));
                    }
                    return false;
                });
                $e.find('.btn_close').click(function(){
                    $obj.find('.chatPopup').hide();
                    return false;
                });
                $e.find('.btn_out').click(function(){
                    //
                    return false;
                });
                $e.appendTo($obj.find('.chatPopup .win_user'));
            }
            return false;
        });
        $obj.find('.tools .btn_close').click(function(){
            $obj.hide();
            return false;
        });
        $obj.mousedown(function(){
            focus_chat($obj);
        });
        $obj.find('.btn_send').click(function(){
            var room = $(this).attr('data-room');
            var text = $obj.find('.inp_text').val();
            $obj.find('.inp_text').val('');
            var msg = {};
            msg['from'] = me_id;
            msg['room'] = room;
            msg['message'] = text;
            msg['domain'] = domain;
            msg['key'] = chat_key;
            appendMsg($obj, me_id, text);
            if(socket!=null) socket.emit('msg', JSON.stringify(msg));
            return false;
        });
        $obj.find('input.inp_text').keyup(function(e){
            if(e.which==13) {
                $obj.find('.btn_send').click();
                return false;
            }
        });
        
        var is_move = false;
        var move_left = 0;
        var move_top = 0;
        var fix_left = 0;
        var fix_top = 0;
        $obj.find('.bar_move').mousedown(function(event){
            event.stopPropagation();
            focus_chat($obj);
            is_move = true;
            move_left = event.pageX;
            move_top = event.pageY;
            fix_left = parseInt($obj.css('left'));
            fix_top = parseInt($obj.css('top'));
        });
        $('body').mouseup(function(event){
            event.stopPropagation();
            is_move = false;
        });
        $('body').mousemove(function(event){
            event.stopPropagation();
            if(is_move) {
                $obj.css('top', (fix_top+event.pageY-move_top)+'px');
                $obj.css('left', (fix_left+event.pageX-move_left)+'px');
            }
        });
    }
    
});