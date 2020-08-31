<?php

/**
*| --------------------------------------------------------------------------
*| Question Model
*| --------------------------------------------------------------------------
*| For question model
*|
*/

class Question_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "question_id";
        $this->tbl = "gltt_question";
    }
    public function addQuestion($fullname, $email, $question)
    {
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if ($gltt_id) {
            $oneGltt = $clsGltt->getOne($gltt_id);
            if (!$oneGltt['is_done']) {
                $res = $this->insertOne(array('gltt_id'=>$gltt_id, 'fullname'=>addslashes($fullname), 'email'=>addslashes($email), 'question'=>addslashes($question), 'reg_date'=>date('Y-m-d H:i:s')), true, 'CMS');
                if ($res) {
                    $this->deleteArrKey('GLTT_'.$gltt_id);
                }
                return $res;
            }
            return false;
        }
        return false;
    }
    public function getQuestion($answer_id=0)
    {
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if ($gltt_id) {
            $oneGltt = $clsGltt->getOne($gltt_id);
            $cons = 'gltt_id='.$gltt_id;
            if ($answer_id>=0) {
                $cons .= ' and answer_id='.$answer_id;
                if ($answer_id>0) {
                    $cons .= ' and is_send=0';
                }
            } elseif ($answer_id==-1) {
                $cons .= ' and is_send=1';
            }
            if (!$oneGltt['is_done']) {
                return $this->getAll($cons.' order by question_id desc limit 1000', true, 'GLTT_'.$gltt_id);
            }
            return false;
        }
        return false;
    }
    public function checkCountQuestion($ids, $answer_id=0)
    {
        $clsGltt = new Gltt_model();
        $gltt_id = $clsGltt->getMaxID('CMS');
        if ($gltt_id) {
            $oneGltt = $clsGltt->getOne($gltt_id);
            if (!$oneGltt['is_done']) {
                $cons = 'gltt_id='.$gltt_id;
                if ($answer_id>=0) {
                    $cons .= ' and answer_id='.$answer_id;
                    if ($answer_id>0) {
                        $cons .= ' and is_send=0';
                    }
                } elseif ($answer_id==-1) {
                    $cons .= ' and is_send=1';
                }
                if ($ids) {
                    $cons .= ' and question_id not in('.$ids.')';
                }
                return $this->getCount($cons, true, 'GLTT_'.$gltt_id);
            }
            return 0;
        }
        return 0;
    }
}
