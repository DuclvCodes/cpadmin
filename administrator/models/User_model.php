<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->pkey  = "user_id";
        $this->tbl   = DB_PREFIX."system_user";
        $this->files = array(
            'image'
        );
    }
    public function getMe()
    {
        $user_id = $this->getUserID();
        if ($user_id) {
            $one = $this->getOne($user_id);
            if (isset($one['password'])) {
                unset($one['password']);
            }
            return $one;
        } else {
            return false;
        }
    }
    public function getUserID()
    {
        $now = time();
        $login = true;
        if(isset($_SESSION['expire']) and $now > $_SESSION['expire']) {
            $login = false;
        }
        if(!isset($_SESSION['expire']) or $login == false) {
            delete_cookie('USER');
            delete_cookie('PASS');
            delete_cookie('EDITOR');
            // remove all session variables
            session_unset(); 
            // destroy the session 
            session_destroy();
            return false;
        }
        if (isset($_SESSION['USER_ID']) or $_SESSION['USER_ID'] != '' and $login ) {
            $_SESSION['expire'] = $now + (60 * 30);
            return $_SESSION['USER_ID'];
        } else {
            if (get_cookie('USER') && get_cookie('PASS')) {
                $all = $this->getAll("is_trash=0 and username='" . get_cookie('USER') . "' and password='" . get_cookie('PASS') . "' order by user_id desc limit 1", true, 'login_' . get_cookie('USER'));
                if ($all) {
                    $_SESSION['USER_ID'] = $all[0];
                    $this->addLogin($all[0]);
                    return $all[0];
                } else {
                    $login = false;
                }
            } else {
                $login = false;
            }
        }
        if(!isset($_SESSION['expire'])) {
            delete_cookie('USER');
            delete_cookie('PASS');
            delete_cookie('EDITOR');
            // remove all session variables
            session_unset(); 
            // destroy the session 
            session_destroy();
            return false;
        }
        if($login == false) {
            delete_cookie('USER');
            delete_cookie('PASS');
            delete_cookie('EDITOR');
            // remove all session variables
            session_unset(); 
            // destroy the session 
            session_destroy();
            return false;
        }else return true;
    }
    public function login($user_name, $user_pass, $is_rebember = true)
    {
        $user_name = addslashes($user_name);
        $user_pass = md5(addslashes($user_pass));
        $all       = $this->getAll("is_trash=0 and username='" . $user_name . "' and password='" . $user_pass . "' order by user_id desc limit 1", true, 'login_' . $user_name);
        $all_2       = $this->getAll("is_trash=0 and email='" . $user_name . "' and password='" . $user_pass . "' order by user_id desc limit 1", true, 'login_' . $user_name);
        
        $session_login_time = 60 * 30;  // Ending a session in 10 minutes from the starting time.
        $cookie_login_time = 60 * 60 * 24;
        if ($all or $all_2) {
            if ($all) {
                $_SESSION['USER_ID'] = $all[0];
                $_SESSION['expire'] = time() + $session_login_time;
            } else {
                $_SESSION['USER_ID'] = $all_2[0];
                $_SESSION['expire'] = time() + $session_login_time;
            }
            $one = $this->getOne($_SESSION['USER_ID']);
            
            $this->addLogin($one['user_id']);
            if ($is_rebember) {
                set_cookie("USER", $one['username'], $cookie_login_time);
                set_cookie("PASS", $user_pass, $cookie_login_time);
                set_cookie("EDITOR", '1', $cookie_login_time, DOMAIN, '/');
            }
            return true;
        } else {
            return false;
        }
    }
    public function addLogin($user_id)
    {
        $one       = $this->getOne($user_id);
        $login_arr = pathToArray($one['login_path']);
        $count     = sizeof($login_arr);
        if ($count == 10) {
            unset($login_arr[0]);
        } elseif ($count > 10) {
            $login_arr = array();
        }
        $login_arr[] = time();
        $res         = $this->updateOne($user_id, array(
            'login_path' => arrayToPath($login_arr)
        ));
        unset($login_arr);
        unset($count);
        unset($one);
        return $res;
    }
    public function is_exits_user($user_name)
    {
        $all = $this->getAll("is_trash=0 and username='" . addslashes($user_name) . "'");
        if ($all[0]) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserName($user_id)
    {
        $one = $this->getOne($user_id);
        return $one['username'];
    }
    public function getFullName($user_id)
    {
        if (!$user_id) {
            return 'System';
        }
        $one = $this->getOne($user_id);
        return trim($one['fullname']);
    }
    public function getLashName($user_id)
    {
        $str   = $this->getFullName($user_id);
        $arr   = explode(' ', $str);
        $count = count($arr);
        if ($count > 1) {
            return $arr[($count - 2)] . ' ' . $arr[($count - 1)];
        } else {
            return $str;
        }
    }
    public function is_online($user_id)
    {
        $one        = $this->getOne($user_id);
        $last_login = $one['last_login'];
        if (!$last_login) {
            return false;
        }
        if (time() < $last_login + 60 * 5) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getSelect($name, $value, $class, $is_multiple = false, $title_default = ' --- Chọn --- ', $filed = 'username')
    {
        $all  = $this->getAll('is_trash=0 order by username limit 1000', true, 'CMS');
        $html = '<select name="' . $name . '" class="' . $class . '">';
        if ($title_default) {
            if ($value) {
                $html .= '<option value="">' . $title_default . '</option>';
            } else {
                $html .= '<option value="" selected="selected">' . $title_default . '</option>';
            }
        }
        if ($all) {
            foreach ($all as $one) {
                $one      = $this->getOne($one);
                $selected = '';
                if ($one[$this->pkey] == $value) {
                    $selected = 'selected="selected"';
                }
                $html .= '<option value="' . $one[$this->pkey] . '" ' . $selected . '>' . $one[$filed] . '</option>';
            }
        }
        return $html . '</select>';
    }
    public function getModule($is_menu = true)
    {
        $arr             = array();
        $arr['home']     = 'Bảng điều khiển';
        $arr['news']     = 'Bài viết';
        $arr['comment']  = 'Bình luận';
        $arr['source']   = 'Nguồn tin';
        $arr['channel']  = 'Dòng sự kiện';
        $arr['royalty']  = 'Nhuận bút';
        $arr['tag']      = 'Từ khóa';
        //$arr['library']  = 'Thư viện báo giấy';
        $arr['vote']     = 'Thăm dò ý kiến';
        $arr['partner']  = 'Liên kết tin tức';
        if (!$is_menu) {
            $arr['mom']     = 'Gửi thông báo';
            $arr['emailnb'] = 'Gửi Email nhuận bút';
            $arr['ads']     = 'Quảng cáo';
            $arr['setting'] = 'Setting';
            $arr['chart'] = 'Thống kê';
            $arr['report'] = 'Báo cáo';
        }
        return $arr;
    }
    public function getIconMenu($mod)
    {
        $arr              = array();
        $arr['home']      = 'home';
        $arr['news']      = 'edit';
        $arr['comment']   = 'comments-alt';
        $arr['source']    = 'share-alt';
        $arr['channel']   = 'reorder';
        $arr['signature'] = 'user-md';
        $arr['royalty']   = 'money';
        $arr['tag']       = 'tag';
        $arr['library']   = 'file';
        $arr['vote']      = 'thumbs-up';
        $arr['chuyengia']      = 'calendar';
        $arr['partner']   = 'link';
        $arr['lichphat']  = 'calendar';
        $arr['newstype']  = 'reorder';
        return $arr[$mod];
    }
    public function getMenu($mod, $mod_curent)
    {
        $res   = array();
        $me_id = $this->getUserID();
        $me    = $this->getOne($me_id);
        $act = current_method()['act'];
        $mnu_trash = false;
        if ($mod == 'news') {
            $mnu_me = false;
            $this->load->model('News_model');
            if ($act == 'edit') {
                $oneNews = $this->News_model->getOne($_GET['id']);
                $status  = $oneNews['status'];
                if ($oneNews['status'] == 4 and strtotime($oneNews['push_date']) >= time()) {
                    $status = -1;
                }
                if ($oneNews['is_trash'] == 1) {
                    $mnu_trash = true;
                }
            } elseif ($act == 'index') {
                if (isset($_GET['status'])) {
                    $status = $_GET['status'];
                } elseif (isset($_GET['status_path'])) {
                    $status = $_GET['status_path'];
                } elseif (isset($_GET['is_trash']) && $_GET['is_trash'] == 1) {
                    $mnu_trash = true;
                } else {
                    $mnu_me = true;
                    $status = false;
                }
            }
            
            $count_m = $this->News_model->getCount('is_trash=0 and user_id=' . $me_id, true, 'ADMIN');
            $text_m  = '';
            if ($count_m > 0) {
                $text_m = '<span class="badge badge-info">' . toBytes($count_m, 2, 1000) . '</span>';
            }
            $count_0 = $this->News_model->getCount('is_trash=0 and status=0 and user_id=' . $me_id, true, 'ADMIN');
            $text_0  = '';
            if ($count_0 > 0) {
                $text_0 = '<span class="badge badge-important">' . toBytes($count_0, 2, 1000) . '</span>';
            }
            
            $res[] = array(
                '/add',
                'Thêm mới',
                $mod == $mod_curent && ($act == 'add')
            );
            //$res[] = array('&act=store', 'Kho tin tổng hợp ', $mod==$mod_curent && ($act=='store'));
            $res[] = array(
                '?user_id=' . $me_id,
                'Bài của tôi ' . $text_m,
                $mod == $mod_curent && $mnu_me
            );
            $res[] = array(
                '?status=0&user_id=' . $me_id,
                'Bài đang viết ' . $text_0,
                $mod == $mod_curent && ($status === '0') && !$mnu_trash
            );
            if ($me['level'] <= 2) {
                $count_b = $this->News_model->getCount('is_trash=0 and action_path like "%|' . $me_id . '|%"', true, 'ADMIN');
                $text_b  = '';
                if ($count_b > 0) {
                    $text_b = '<span class="badge badge-important">' . toBytes($count_b, 2, 1000) . '</span>';
                }
                $count_1 = $this->News_model->getCount('is_trash=0 and status=1', true, 'ADMIN');
                $text_1  = '';
                if ($count_1 > 0) {
                    $text_1 = '<span class="badge badge-important">' . toBytes($count_1, 2, 1000) . '</span>';
                }
                $count_2 = $this->News_model->getCount('is_trash=0 and status=2', true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0) {
                    $text_2 = '<span class="badge badge-important">' . toBytes($count_2, 2, 1000) . '</span>';
                }
                $count_3 = $this->News_model->getCount('is_trash=0 and status=3', true, 'ADMIN');
                $text_3  = '';
                if ($count_3 > 0) {
                    $text_3 = '<span class="badge badge-important">' . toBytes($count_3, 2, 1000) . '</span>';
                }
                $count_4 = $this->News_model->getCount('is_trash=0 and status=4', true, 'ADMIN');
                $text_4  = '';
                if ($count_4 > 0) {
                    $text_4 = '<span class="badge badge-info">' . toBytes($count_4, 2, 1000) . '</span>';
                }
                $count_5 = $this->News_model->getCount('is_trash=0 and status=5', true, 'ADMIN');
                $text_5  = '';
                if ($count_5 > 0) {
                    $text_5 = '<span class="badge badge-important">' . toBytes($count_5, 2, 1000) . '</span>';
                }
                $count_time = $this->News_model->getCount('is_trash=0 and status=4 and push_date>=now()', true, 'ADMIN');
                $text_time  = '';
                if ($count_time > 0) {
                    $text_time = '<span class="badge badge-success">' . toBytes($count_time, 2, 1000) . '</span>';
                }
                
                $res[] = array(
                    '?status=-2',
                    'Bài được đánh dấu ' . $text_b,
                    $mod == $mod_curent && ($status == -2) && !$mnu_trash
                );
                $res[] = array(
                    '?status=1',
                    'Bài chờ biên tập ' . $text_1,
                    $mod == $mod_curent && ($status == '1') && !$mnu_trash
                );
                $res[] = array(
                    '?status=3',
                    'Bài chờ xuất bản ' . $text_3,
                    $mod == $mod_curent && ($status == '3') && !$mnu_trash
                );
                $res[] = array(
                    '?status=-1',
                    'Bài hẹn giờ ' . $text_time,
                    $mod == $mod_curent && ($status == '-1') && !$mnu_trash
                );
                $res[] = array(
                    '?status=4',
                    'Bài đã xuất bản ' . $text_4,
                    $mod == $mod_curent && ($status == '4') && !$mnu_trash
                );
                $res[] = array(
                    '?status=5',
                    'Tin bài gỡ xuống ' . $text_5,
                    $mod == $mod_curent && ($status == '5') && !$mnu_trash
                );
                $res[] = array(
                    '?status=2',
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2') && !$mnu_trash
                );
            } elseif ($me['level'] <= 2) {
                $count_1 = $this->News_model->getCount('is_trash=0 and status=1 and user_id=' . $me_id, true, 'ADMIN');
                $text_1  = '';
                if ($count_1 > 0) {
                    $text_1 = '<span class="badge badge-important">' . toBytes($count_1, 2, 1000) . '</span>';
                }
                $count_2 = $this->News_model->getCount('is_trash=0 and status=2 and user_id=' . $me_id, true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0) {
                    $text_2 = '<span class="badge badge-important">' . toBytes($count_2, 2, 1000) . '</span>';
                }
                $count_p = $this->News_model->getCount('is_trash=0 and (status=3 OR status=4 OR status=5) and user_id=' . $me_id, true, 'ADMIN');
                $text_p  = '';
                if ($count_p > 0) {
                    $text_p = '<span class="badge badge-info">' . toBytes($count_p, 2, 1000) . '</span>';
                }
                
                $res[] = array(
                    '?status_path=3.4.5&user_id=' . $me_id,
                    'Bài đã duyệt ' . $text_p,
                    $mod == $mod_curent && ($status == '3.4.5' || $status == 3 || $status == 4 || $status == 5) && !$mnu_trash
                );
                $res[] = array(
                    '?status=1&user_id=' . $me_id,
                    'Bài chờ duyệt ' . $text_1,
                    $mod == $mod_curent && ($status == '1') && !$mnu_trash
                );
                $res[] = array(
                    '?status=2&user_id=' . $me_id,
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2') && !$mnu_trash
                );
            }  elseif ($me['level'] == 3) {
                
                $count_1 = $this->News_model->getCount('is_trash=0 and status=1 and user_id=' . $me_id, true, 'ADMIN');
                $text_1  = '';
                if ($count_1 > 0)
                    $text_1 = '<span class="badge badge-important">' . toBytes($count_1, 2, 1000) . '</span>';
                $count_2 = $this->News_model->getCount('is_trash=0 and status=2 and user_id=' . $me_id, true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0)
                    $text_2 = '<span class="badge badge-important">' .toBytes($count_2, 2, 1000) . '</span>';
                $count_p = $this->News_model->getCount('is_trash=0 and (status=3 OR status=4 OR status=5) and user_id=' . $me_id, true, 'ADMIN');
                $text_p  = '';
                if ($count_p > 0)
                    $text_p = '<span class="badge badge-info">' . toBytes($count_p, 2, 1000) . '</span>';
                
                $res[] = array(
                    '?status_path=3.4.5&user_id=' . $me_id,
                    'Bài đã duyệt ' . $text_p,
                    $mod == $mod_curent && ($status == '3.4.5' || $status == 3 || $status == 4 || $status == 5) && !$mnu_trash
                );
                $res[] = array(
                    '?status=1&user_id=' . $me_id,
                    'Bài chờ duyệt ' . $text_1,
                    $mod == $mod_curent && ($status == '1') && !$mnu_trash
                );
                $res[] = array(
                    '?status=2&user_id=' . $me_id,
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2') && !$mnu_trash
                );
            }else {
            }
            $count_t = $this->News_model->getCount('is_trash=1 and user_id=' . $me_id, true, 'ADMIN');
            $text_t  = '';
            if ($count_t > 0) {
                $text_t = '<span class="badge badge-important">' . toBytes($count_t, 2, 1000) . '</span>';
            }
            $res[] = array('?is_trash=1&user_id=' . $me_id, 'Thùng rác' . $text_t, $mod == $mod_curent && $mnu_trash);
            return $res;
        } elseif ($mod == 'paper') {
            $clsPaper = new Paper();
            if ($act == 'edit') {
                $onePaper = $clsPaper->getOne($_GET['id']);
                $status   = $onePaper['status'];
            } elseif ($act == 'index') {
                if (isset($_GET['status'])) {
                    $status = $_GET['status'];
                } elseif (isset($_GET['status_path'])) {
                    $status = $_GET['status_path'];
                } elseif (isset($_GET['is_trash']) && $_GET['is_trash'] == 1) {
                    $mnu_trash = true;
                } else {
                    $mnu_me = true;
                }
            }
            
            $count_0 = $clsPaper->getCount('is_trash=0 and status=0 and user_id=' . $me_id, true, 'ADMIN');
            $text_0  = '';
            if ($count_0 > 0) {
                $text_0 = '<span class="badge badge-important">' . toBytes($count_0, 2, 1000) . '</span>';
            }
            
            $res[] = array(
                '&act=add',
                'Thêm mới',
                $mod == $mod_curent && ($act == 'add')
            );
            $res[] = array(
                '&status=0&user_id=' . $me_id,
                'Bài đang viết ' . $text_0,
                $mod == $mod_curent && ($status == '0')
            );
            if ($me['level'] == 1) {
                $count_2 = $clsPaper->getCount('is_trash=0 and status=2', true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0) {
                    $text_2 = '<span class="badge badge-important">' . toBytes($count_2, 2, 1000) . '</span>';
                }
                $count_3 = $clsPaper->getCount('is_trash=0 and status=3', true, 'ADMIN');
                $text_3  = '';
                if ($count_3 > 0) {
                    $text_3 = '<span class="badge badge-important">' . toBytes($count_3, 2, 1000) . '</span>';
                }
                $count_4 = $clsPaper->getCount('is_trash=0 and status=4', true, 'ADMIN');
                $text_4  = '';
                if ($count_4 > 0) {
                    $text_4 = '<span class="badge badge-info">' . toBytes($count_4, 2, 1000) . '</span>';
                }
                $count_all = $clsPaper->getCount('is_trash=0', true, 'ADMIN');
                $text_all  = '';
                if ($count_all > 0) {
                    $text_all = '<span class="badge badge-important">' . toBytes($count_all, 2, 1000) . '</span>';
                }
                
                $res[] = array(
                    '&status=3',
                    'Bài chờ duyệt ' . $text_3,
                    $mod == $mod_curent && ($status == '3')
                );
                $res[] = array(
                    '&status=4',
                    'Bài đã duyệt ' . $text_4,
                    $mod == $mod_curent && ($status == '4')
                );
                $res[] = array(
                    '&status=2',
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2')
                );
            } elseif ($me['level'] == 2) {
                $count_1 = $clsPaper->getCount('is_trash=0 and status=1', true, 'ADMIN');
                $text_1  = '';
                if ($count_1 > 0) {
                    $text_1 = '<span class="badge badge-important">' . toBytes($count_1, 2, 1000) . '</span>';
                }
                $count_2 = $clsPaper->getCount('is_trash=0 and status=2', true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0) {
                    $text_2 = '<span class="badge badge-important">' . toBytes($count_2, 2, 1000) . '</span>';
                }
                $count_3 = $clsPaper->getCount('is_trash=0 and status=3', true, 'ADMIN');
                $text_3  = '';
                if ($count_3 > 0) {
                    $text_3 = '<span class="badge badge-important">' . toBytes($count_3, 2, 1000) . '</span>';
                }
                $count_all = $clsPaper->getCount('is_trash=0', true, 'ADMIN');
                $text_all  = '';
                if ($count_all > 0) {
                    $text_all = '<span class="badge badge-important">' . toBytes($count_all, 2, 1000) . '</span>';
                }
                
                $res[] = array(
                    '&status=1',
                    'Bài chờ biên tập ' . $text_1,
                    $mod == $mod_curent && ($status == '1')
                );
                $res[] = array(
                    '&status=3',
                    'Bài chờ duyệt ' . $text_3,
                    $mod == $mod_curent && ($status == '3')
                );
                $res[] = array(
                    '&status=2',
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2')
                );
            } else {
                $count_1 = $clsPaper->getCount('is_trash=0 and status=1 and user_id=' . $me_id, true, 'ADMIN');
                $text_1  = '';
                if ($count_1 > 0) {
                    $text_1 = '<span class="badge badge-important">' . toBytes($count_1, 2, 1000) . '</span>';
                }
                $count_2 = $clsPaper->getCount('is_trash=0 and status=2 and user_id=' . $me_id, true, 'ADMIN');
                $text_2  = '';
                if ($count_2 > 0) {
                    $text_2 = '<span class="badge badge-important">' . toBytes($count_2, 2, 1000) . '</span>';
                }
                $count_all = $clsPaper->getCount('is_trash=0 and status<3 and user_id=' . $me_id, true, 'ADMIN');
                $text_all  = '';
                if ($count_all > 0) {
                    $text_all = '<span class="badge badge-important">' . toBytes($count_all, 2, 1000) . '</span>';
                }
                
                $res[] = array(
                    '&status=1&user_id=' . $me_id,
                    'Bài chờ duyệt ' . $text_1,
                    $mod == $mod_curent && ($status == '1')
                );
                $res[] = array(
                    '&status=2&user_id=' . $me_id,
                    'Tin bài trả về ' . $text_2,
                    $mod == $mod_curent && ($status == '2')
                );
            }
            $res[]   = array(
                '',
                'Tất cả ' . $text_all,
                $mod == $mod_curent && !isset($_GET['status']) && !isset($_GET['is_trash']) && !isset($_GET['act'])
            );
            $count_t = $clsPaper->getCount('is_trash=1 and user_id=' . $me_id, true, 'ADMIN');
            $text_t  = '';
            if ($count_t > 0) {
                $text_t = '<span class="badge badge-important">' . toBytes($count_t, 2, 1000) . '</span>';
            }
            $res[] = array(
                '&is_trash=1&user_id=' . $me_id,
                'Thùng rác' . $text_t,
                $mod == $mod_curent && $mnu_trash
            );
            return $res;
        } else {
            return false;
        }
    }
    public function getEditing($news_id)
    {
        $me_id = $this->getUserID();
        $all   = $this->getAll("editing_news_id='" . $news_id . "' order by user_id desc limit 10", true, 'news_' . $news_id);
        if ($all) {
            $res = '';
            foreach ($all as $id) {
                if ($id != $me_id) {
                    $res .= $this->getFullName($id) . ', ';
                }
            }
            return trim($res, ', ');
        } else {
            return false;
        }
    }
    public function permission($module_name)
    {
        $me = $this->getMe();
        if ($me['permission']) {
            $listMenu = json_decode($me['permission']);
            if (is_object($listMenu)) {
                $listMenu = get_object_vars($listMenu);
            }
            if (isset($listMenu[$module_name])) {
                if ($listMenu[$module_name] == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public function getPermissCat($user_id, $cat_id, $oneUser = null)
    {
        if (!$oneUser) {
            $oneUser = $this->getOne($user_id);
        }
        $cat_path = $oneUser['category_path'];
        $cat_arr  = pathToArray($cat_path);
        if (in_array($cat_id, (array)$cat_arr)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function setPermissCat($user_id, $cat_id, $oneUser = null)
    {
        if (!$oneUser) {
            $oneUser = $this->getOne($user_id);
        }
        $cat_path = $oneUser['category_path'];
        $cat_arr  = pathToArray($cat_path);
        if (in_array($cat_id, $cat_arr)) {
            return true;
        } else {
            $cat_arr[] = $cat_id;
            $cat_path  = arrayToPath($cat_arr);
            $res       = $this->updateOne($user_id, array(
                'category_path' => $cat_path
            ));
            return $res;
        }
    }
    public function unsetPermissCat($user_id, $cat_id, $oneUser = null)
    {
        if (!$oneUser) {
            $oneUser = $this->getOne($user_id);
        }
        $cat_path = $oneUser['category_path'];
        $cat_arr  = pathToArray($cat_path);
        if (!in_array($cat_id, $cat_arr)) {
            return true;
        } else {
            $res = $this->updateOne($user_id, array(
                'category_path' => str_replace('|' . $cat_id . '|', '|', $cat_path)
            ));
            return $res;
        }
    }
}
