<?php
class News_model extends MY_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->pkey = "news_id";
        $this->tbl = DB_PREFIX."news";
    }
    
    public function getTitle($news_id)
    {
        $res = $this->getOneNews($news_id);
        if (!$res) {
            return 'Bài viết không tồn tại hoặc đã xóa';
        }
        return $res['title'];
    }
    public function getOneNews($news_id)
    {
        $res = parent::getOne($news_id);
        // if(!$res) {
        //     $res = $this->getFromPack($news_id);
        //     $res['is_pack'] = 1;
        // }
        if (!$res) {
            return false;
        }
        return $res;
    }
    public function getLink($news_id, $oneNews=null)
    {
        $this->load->helper('url');
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $oneNews = $this->getOneNews($news_id);
        if ($oneNews) {
            $slug = $oneNews['slug'];
            $catSlug = $clsCategory->getSlug($oneNews['category_id']);
            $link = base_url($catSlug['slug'].'/'.$slug."-d".$news_id.".html");
            return $link;
        } else {
            return false;
        }
    }
    public function getLinkTitle($news_id, $oneNews=null, $class=null, $tag='h2')
    {
        if (!$oneNews) {
            $oneNews = $this->getOneNews($news_id);
        }
        $link = $this->getLink($news_id, $oneNews);
        $title = $this->getTitle($news_id, $oneNews);
        return '<'.$tag.'><a href="'.$link.'" class="'.$class.'" title="'.str_replace('"', '\'', $title).'">'.$title.'</a></'.$tag.'>';
    }
    public function getLinkImage($news_id, $width, $height, $oneNews=null, $class=null, $class_img=null)
    {
        if (!$oneNews) {
            $oneNews = $this->getOneNews($news_id);
        }
        $link = $this->getLink($news_id, $oneNews);
        $title = $this->getTitle($news_id, $oneNews);
        $img = $this->getImage($news_id, $width, $height, 'image', null, $oneNews);
        return '<a href="'.$link.'" class="'.$class.'" title="'.str_replace('"', '\'', $title).'" ><img class="'.$class_img.'" src="'.$img.'" width="'.$width.'" height="'.$height.'" alt="'.str_replace('"', '\'', $title).'" /></a>';
    }
    public function getCategory($news_id)
    {
        $res = $this->getOneNews($news_id);
        return $res['category_id'];
    }
    public function getAllType()
    {
        return array(1=>'Báo in', 2=>'Sản xuất', 3=>'Tổng hợp', 4=>'Báo bạn', 5=>'Bài dịch');
    }
    public function getType($id)
    {
        $all = $this->getAllType();
        return $all[$id];
    }
    public function plusView($news_id)
    {
        $key = MEMCACHE_NAME.'_VIEWS';
        $res = $this->getCache($key);
        if (!$res) {
            $res = array();
        }
        if (isset($res[$news_id])) {
            $res[$news_id]++;
        } else {
            $res[$news_id] = 1;
        }
        arsort($res);
        $this->setCache($key, $res);
        return true;
    }
    public function getCons($category_id=0)
    {
        $cons = "is_trash=0 and status=4 and push_date<now()";
        if ($category_id>0) {
            $clsCategory = new Category();
            $allCat = $clsCategory->getChild($category_id);
            $allCat[] = $category_id;
            $cons_related = '';
            if ($allCat) {
                foreach ($allCat as $oneCat) {
                    if (!$cons_related) {
                        $cons_related = "category_path like '%|".$oneCat."|%'";
                    } else {
                        $cons_related .= " or category_path like '%|".$oneCat."|%'";
                    }
                }
            }
            $cons.=" and (category_id in (".implode(',', $allCat).") OR ".$cons_related.")";
        }
        return $cons;
    }
    public function getLinkKeywords($news_id, $oneNews=null)
    {
        $clsTag = new Tag_model();
        if (!$oneNews) {
            $oneNews = $this->getOneNews($news_id);
        }
        $all = pathToArray($oneNews['tag_path']);
        $res = "";
        if (is_array($all)) {
            foreach ($all as $key=>$tag_id) {
                $oneTag = $clsTag->getOne($tag_id);
                if ($key>0) {
                    $res.=' ';
                }
                $res.='<a style="margin-bottom: 5px;" href="'.$clsTag->getLink($tag_id, $oneTag).'">'.$oneTag['title'].'</a>';
            }
        }
        return $res;
    }
    public function getRelatedNews($news_id)
    {
        $res = $this->getOneNews($news_id);
        return parent::pathToArray($res['news_path']);
    }
    public function getLinkRelated($news_id)
    {
        $res = $this->getOneNews($news_id);
        $slug = $res['slug'];
        return PCMS_URL.'/'.$slug."-d".$news_id."/lien-quan/";
    }
    public function getAllImage($news_id, $thumb = '70x70')
    {
        $one = $this->getOneNews($news_id);
        $keycache = 'getAllImage'.$one['last_edit'];
        if ($one[$keycache]) {
            if ($one[$keycache]=='false') {
                return false;
            } else {
                return $one[$keycache];
            }
        } else {
            $result = array();
            require_once('lib/simple_html_dom.php');
            $html = str_get_html($one['content']);
            $obj = $html->find('.tkp_tinyslide', 0);
            if ($obj) {
                foreach ($html->find('.tkp_one') as $key=>$e) {
                    $img = $e->find('img', 0)->src;
                    $result[$key]['src'] = $img;
                    $result[$key]['alt'] = $e->plaintext;
                    $result[$key]['thumb'] = str_replace(MEDIA_DOMAIN.'/files/', MEDIA_DOMAIN.'/resize/'.$thumb.'/files/', $img);
                }
            } else {
                foreach ($html->find('img') as $key=>$e) {
                    $img = $e->src;
                    $result[$key]['src'] = $img;
                    $result[$key]['alt'] = '';
                    $result[$key]['thumb'] = str_replace(MEDIA_DOMAIN.'/files/', MEDIA_DOMAIN.'/resize/'.$thumb.'/files/', $img);
                }
            }
            if (!$result) {
                $result = 'false';
            }
            $one[$keycache] = $result;
            $keycache = $this->getKey($news_id);
            $this->setCache($keycache, json_encode($one));
            return $result;
        }
    }
    public function getAllSlide($news_id, $thumb = '70x70')
    {
        $one = $this->getOneNews($news_id);
        $result = array();
        $slide = $one['slide'];
        if ($slide) {
            $oneIMG = explode('[n]', $slide);
            if ($oneIMG) {
                foreach ($oneIMG as $key=>$info) {
                    $info = explode('[v]', $info);
                    $result[$key]['src'] = $info[0];
                    $result[$key]['alt'] = $info[1];
                    $result[$key]['thumb'] = str_replace(MEDIA_DOMAIN.'/files/', MEDIA_DOMAIN.'/resize/'.$thumb.'/files/', $info[0]);
                }
            }
        }
        return $result;
    }
    public function syncTag($news_id)
    {
        $clsTag = new Tag_model();
        $one = $this->getOneNews($news_id);
        $arr = pathToArray($one['tag_path']);
        $tags = '';
        if ($arr) {
            foreach ($arr as $tag_id) {
                $oneTag = $clsTag->getOne($tag_id);
                $tags .= $oneTag['title'].', ';
            }
        }
        $tags = trim($tags, ', ');
        $res = $this->updateOne($news_id, array('tags'=>$tags));
        return $res;
    }
    public function getSphinx($query, $page=1, $rpp=18, $cat_id=0, $is_match_any=false)
    {
        $query = toNormal($query);
        $key = MEMCACHE_NAME.'_getSphinx_'.md5($query).'_'.$cat_id.'_'.$page.'_'.$rpp;
        //$res = $this->getCache($key);
        if ($res) {
            if ($res=='null') {
                return false;
            } else {
                return $res;
            }
        }
        require_once("lib/sphinxapi.php");
        $cl = new SphinxClient();
        $cl->SetServer('localhost', '9312');
        $cl->Open();
        $type = $is_match_any?SPH_MATCH_ANY:SPH_MATCH_ALL;
        $cl->SetMatchMode($type);
        $cl->SetLimits(($page-1)*$rpp, $rpp);
        if ($cat_id) {
            $clsCategory = new Category();
            $cat_id = $clsCategory->getChild($cat_id);
            $cl->SetFilter("category_id", $cat_id, false);
        }
        $res = $cl->Query($query, 'idx_exp');
        $cl->Close();
        $arr = array();
        if ($res["matches"]) {
            foreach ($res["matches"] as $oneNews=>$val) {
                $arr[]=$oneNews;
            }
        }
        $return = array();
        $return['res'] = $arr;
        $return['total'] = $res['total'];
        $this->setCache($key, $return, 60*60*24);
        return $return;
    }
    
    # FOR ADMIN UCP
    
    public function getPermissionEdit($oneItem, $me)
    {
        if ($me['level']==1 || $me['level']==0) {
            return true;
        } elseif ($me['level']>=4) {
            return false;
        } elseif ($me['level']==3) {
            if ($oneItem['user_id']==$me['user_id'] && ($oneItem['status'] == 4)) {
                return false;
            }
            if ($oneItem['user_id']!=$me['user_id'] || $oneItem['status']>=3 || $oneItem['status']==1) {
                return false;
            } else {
                return true;
            }
        } elseif ($me['level']==2) {
            if ($oneItem['user_id']==$me['user_id'] && ($oneItem['status']<4 or $oneItem != 6)) {
                return true;
            }
            $user_category = pathToArray($me['category_path']);
            $this->load->model('Category_model');
            $clsCategory = new Category_model();
            if (in_array($oneItem['category_id'], $user_category) || in_array($clsCategory->getParentID($oneItem['category_id']), $user_category)) {
                if ($me['is_push']==1) {
                    return true;
                } else {
                    if ($oneItem['status']>=4) {
                        return false;
                    } else {
                        return true;
                    }
                }
            } else {
                return false;
            }
        }
    }
    public function getTitleStatus($i)
    {
        if (!$i) {
            return 'Bài lưu nháp';
        } elseif ($i==1) {
            return 'Bài chờ biên tập';
        } elseif ($i==2) {
            return 'Bài trả về';
        } elseif ($i==3) {
            return 'Bài chờ xuất bản';
        } elseif ($i==4) {
            return 'Bài đã xuất bản';
        } elseif ($i==5) {
            return 'Bài bị gỡ xuống';
        } elseif ($i==-1) {
            return 'Bài hẹn giờ';
        } elseif ($i==-2) {
            return 'Bài được đánh dấu';
        }
    }
    public function getListStatus($i, $level, $is_push=false, $is_unpush=false)
    {
        if ($level>=4) {
            return false;
        } elseif ($level==3) {
            if (!$i) {
                return array(0=>'Lưu nháp', 1=>'Gửi biên tập');
            } elseif ($i==1) {
                return array(1=>'Cập nhật');
            } elseif ($i==2) {
                return array(2=>'Cập nhật', 1=>'Gửi biên tập lại', 0=>'Cho vào tin nháp');
            } else {
                die('error');
            }
        } else {
            if ($is_push) {
                if (!$i) {
                    return array(0=>'Lưu nháp', 3=>'Chờ xuất bản', 4=>'Xuất bản');
                } elseif ($i==4) {
                    if ($is_unpush) {
                        return array(4=>'Cập nhật', 5=>'Gỡ tin');
                    } else {
                        return array(4=>'Cập nhật');
                    }
                } elseif ($i==5) {
                    return array(5=>'Cập nhật', 4=>'Xuất bản lại', 2=>'Trả lại cho phóng viên');
                } elseif ($i==1) {
                    return array(1=>'Cập nhật', 3=>'Duyệt tin', 4=>'Duyệt và xuất bản tin', 2=>'Trả lại cho phóng viên');
                } elseif ($i==2) {
                    return array(2=>'Cập nhật', 3=>'Nhận lại tin này', 4=>'Xuất bản tin');
                } elseif ($i==3) {
                    return array(3=>'Cập nhật', 4=>'Xuất bản tin', 2=>'Trả lại phóng viên');
                } else {
                    die('error');
                }
            } else {
                if (!$i) {
                    return array(0=>'Lưu nháp', 3=>'Chờ xuất bản');
                } elseif ($i==4) {
                    return array(4=>'Cập nhật');
                } elseif ($i==5) {
                    return array(5=>'Cập nhật', 2=>'Trả lại cho phóng viên');
                } elseif ($i==1) {
                    return array(1=>'Cập nhật', 3=>'Duyệt tin', 2=>'Trả lại cho phóng viên');
                } elseif ($i==2) {
                    return array(2=>'Cập nhật', 3=>'Nhận lại tin này');
                } elseif ($i==3) {
                    return array(3=>'Cập nhật', 2=>'Trả lại phóng viên');
                } else {
                    die('error');
                }
            }
        }
    }
    public function sendNews($news_id, $lessUser=null)
    {
        if ($lessUser==null) {
            $lessUser = array();
        }
        $oneNews = $this->getOneNews($news_id);
        $this->load->model('Mail_model');
        $clsMail = new Mail_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        
        $link = 'https://'.DOMAIN.'/news/detail?id='.$news_id.'&xemnhanh';
        $link_cms = 'https://'.ADMIN_DOMAIN.'/news/edit?id='.$news_id;
        $info = '<a href="'.$link.'" style="float: left; margin-right: 8px;"><img src="'.$this->getImage($news_id, 160, 112).'" /></a>';
        $info .= '<h3 style="margin: 0 0 8px;"><a style="text-decoration: none; color: #444;font-size: 16px;" href="'.$link.'">'.$oneNews['title'].'</a></h3><p style="color: #888;margin: 0; line-height: 18px;">'.$oneNews['intro'].'</p>';
        $content = '<p><b>'.$clsUser->getFullName($oneNews['user_id']).'</b> vừa gửi cho bạn 1 bài viết thông qua CMS.</p>';
        $content .= '<div style="padding: 8px; border-top: 1px dashed #bababa; border-bottom: 1px dashed #bababa; background: #f2f2f2;">'.$info.'<div style="clear: both;"></div></div>';
        $content .= '<p>Để xem thông tin chi tiết bài viết, hãy click vào nút dưới đây:</p>';
        $content .= '<p style="text-align: center;"><a href="'.$link_cms.'" style="display: inline-block;padding: 7px 14px;font-size: 14px;background-color: #35aa47;color: white;line-height: 20px;text-decoration: none;">Xem chi tiết trong CMS</a></p>';
        $allUser = pathToArray($oneNews['action_path']);
        if ($allUser) {
            foreach ($allUser as $user_id) {
                if (!in_array($user_id, $lessUser)) {
                    $oneUser = $clsUser->getOne($user_id);
                    if ($oneUser['email']) {
                        $clsMail->sendMail($oneUser['email'], '[Duyệt bài] '.$oneNews['title'], $content);
                    }
                }
            }
        }
        if (defined('EMAIL_CONFIRM_NEWS')) {
            $all = explode(',', EMAIL_CONFIRM_NEWS);
            if ($all) {
                foreach ($all as $email) {
                    $clsMail->sendMail($email, '[Duyệt bài] '.$oneNews['title'], $content);
                }
            }
        }
    }
    public function sendToBoxNB($news_id)
    {
        $this->load->model('Box_model');
        $one = $this->getOneNews($news_id);
        if (!$one) {
            return false;
        }
        $cat_id = $one['category_id'];
        if (!$cat_id) {
            return false;
        }
        $clsBox = new Box_model();
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $clsBox->addNews($clsBox->getIDFromCat($cat_id), $news_id);
        $cat_id = $clsCategory->getCategoryRoot($cat_id);
        $clsBox->addNews(BOX_TINMOI, $news_id);
        if ($one['is_video']) {
            $clsBox->addNews(BOX_VIDEO, $news_id);
        }
        if ($one['is_photo']) {
            $clsBox->addNews(BOX_PHOTO, $news_id);
        }
        return true;
    }
    public function changeBox($news_id, $old_cat, $new_cat)
    {
        $this->load->model('Category_model');
        $this->load->model('Box_model');
        $box_old_cat = $this->Box_model->getIDFromCat($old_cat);
        if ($this->Box_model->hasNews($box_old_cat, $news_id)) {
            $this->Box_model->removeNews($news_id, array($box_old_cat));
            $box_new_cat = $this->Box_model->getIDFromCat($new_cat);
            $this->Box_model->addNews($box_new_cat, $news_id);
        }
        
        $parent_id = $this->Category_model->getParentID($old_cat);
        if ($parent_id) {
            $box_old_cat = $this->Box_model->getIDFromCat($parent_id);
            if ($this->Box_model->hasNews($box_old_cat, $news_id)) {
                $this->Box_model->removeNews($news_id, array($box_old_cat));
            }
        }
    }
    public function getFromPack($news_id)
    {
        $this->load->model('Pack_model');
        $res = $this->Pack_model->getOne($news_id);
        return $res;
    }
    public function is_sanxuat($news_id)
    {
        $one = $this->getOneNews($news_id);
        if ($one['type_post']==1||$one['type_post']==2) {
            $res = '<strong style="color:#333">Tạp chí GTVT </strong> -';
        } else {
            $res = '';
        }
        return $res;
    }
    public function hasVideo($news_id)
    {
        $this->load->model('Video_model');
        $clsVideo = new Video_model();
        $count = $clsVideo->getCount('news_id='.$news_id.' limit 1', true, 'CMS');
        if ($count) {
            return true;
        } else {
            return false;
        }
    }
}
