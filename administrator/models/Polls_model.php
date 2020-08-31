<?php

class Polls_Model extends CI_Model
{
    public function create_poll($data)
    {
        $this->db->insert("polls", $data);
        return $this->db->insert_id();
    }

    public function get_poll($id)
    {
        return $this->db
            ->select("polls.ID, polls.userid, polls.name, 
				polls.question, polls.timestamp, 
				polls.show_results, polls.ip_restricted,
				polls.cookie_restricted, polls.public,
				polls.status, polls.votes, polls.created, 
				polls.updated, polls.user_restricted,
				polls.hash, polls.vote_type, polls.votes_today,
				polls.votes_today_timestamp, polls.votes_month,
				polls.votes_month_timestamp, polls.themeid,
				poll_themes.name as themename, poll_themes.css_code")
            ->where("polls.ID", $id)
            ->join(
                "poll_themes",
                "poll_themes.ID = polls.themeid",
                "left outer"
            )
            ->get("polls");
    }

    public function get_user_poll($id, $userid)
    {
        return $this->db
            ->select("polls.ID, polls.userid, polls.name, 
				polls.question, polls.timestamp, 
				polls.show_results, polls.ip_restricted,
				polls.cookie_restricted, polls.public,
				polls.status, polls.votes, polls.created, 
				polls.updated, polls.user_restricted,
				polls.hash, polls.vote_type, polls.votes_today,
				polls.votes_today_timestamp, polls.votes_month,
				polls.votes_month_timestamp, polls.themeid,
				poll_themes.name as themename, poll_themes.css_code")
            ->where("polls.ID", $id)
            ->where("polls.userid", $userid)
            ->join(
                "poll_themes",
                "poll_themes.ID = polls.themeid",
                "left outer"
            )
            ->join("users", "users.ID = polls.userid", "left outer")
            ->get("polls");
    }

    public function get_polls($datatable)
    {
        $datatable->db_order();

        $datatable->db_search(
            array(
            "polls.name"
            )
        );

        return $this->db
            ->where("status !=", 2)
            ->limit($datatable->length, $datatable->start)
            ->get("polls");
    }

    public function get_all_polls($datatable)
    {
        $datatable->db_order();

        $datatable->db_search(
            array(
            "polls.name"
            )
        );

        return $this->db
            ->where("status !=", 2)
            ->where("public", 0)
            ->limit($datatable->length, $datatable->start)
            ->get("polls");
    }

    public function get_polls_archived($datatable)
    {
        $datatable->db_order();

        $datatable->db_search(
            array(
            "polls.name"
            )
        );

        return $this->db
            ->where("status", 2)
            ->limit($datatable->length, $datatable->start)
            ->get("polls");
    }

    public function get_total_polls()
    {
        $s = $this->db
            ->where("public", 0)
            ->select("COUNT(*) as num")
            ->get("polls");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function get_total_poll_votes($userid)
    {
        $s = $this->db
            ->select("SUM(votes) as num")
            ->where("userid", $userid)
            ->get("polls");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function get_total_poll_votes_today($userid)
    {
        $s = $this->db
            ->select("COUNT(*) as num")
            ->where("userid", $userid)
            ->where("timestamp >", time() - (24*3600))
            ->get("poll_votes");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function get_total_polls_archived()
    {
        $s = $this->db
            ->select("COUNT(*) as num")
            ->where("status", 2)
            ->get("polls");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function update_poll($id, $data)
    {
        $this->db->where("ID", $id)->update("polls", $data);
    }

    public function get_poll_answers($pollid)
    {
        return $this->db->where("pollid", $pollid)->get("poll_answers");
    }

    public function add_answer($pollid, $answer)
    {
        $this->db->insert(
            "poll_answers",
            array(
            "pollid" => $pollid,
            "answer" => $answer
            )
        );
        return $this->db->insert_id();
    }

    public function get_poll_answer($pollid, $answerid)
    {
        return $this->db
            ->where("ID", $answerid)
            ->where("pollid", $pollid)
            ->get("poll_answers");
    }

    public function update_answer($answerid, $data)
    {
        $this->db->where("ID", $answerid)->update("poll_answers", $data);
    }

    public function delete_answer($id)
    {
        $this->db->where("ID", $id)->delete("poll_answers");
    }

    public function check_user_vote($pollid)
    {
        return $this->db
            ->where("pollid", $pollid)
            ->where("IP", $_SERVER['REMOTE_ADDR'])
            ->get("poll_votes");
    }

    public function get_poll_vote($pollid, $userid)
    {
        return $this->db->where("pollid", $pollid)
            ->where("userid", $userid)
            ->get("poll_votes");
    }

    public function add_vote($data)
    {
        $this->db->insert("poll_votes", $data);
    }

    public function get_country_vote($pollid, $country)
    {
        return $this->db
            ->where("pollid", $pollid)
            ->where("country", $country)
            ->get("poll_countries");
    }

    public function update_country_vote($id, $data)
    {
        $this->db->where("ID", $id)->update("user_poll_countries", $data);
    }

    public function add_country_vote($data)
    {
        $this->db->insert("user_poll_countries", $data);
    }

    public function get_recent_votes($pollid)
    {
        return $this->db->where("polls_votes.pollid", $pollid)
            ->select("polls_votes.IP, polls_votes.user_agent, 
				polls_votes.timestamp, polls_votes.ID, 
				poll_answers.answer")
            ->join("poll_answers", "poll_answers.ID = 
				polls_votes.answerid")
            ->limit(5)
            ->order_by("polls_votes.ID", "DESC")
            ->get("polls_votes");
    }

    public function top_country_votes($pollid)
    {
        return $this->db
            ->where("pollid", $pollid)
            ->order_by("votes", "DESC")
            ->limit(5)
            ->get("poll_countries");
    }

    public function count_votes_date($date, $pollid)
    {
        $s = $this->db
            ->select("COUNT(*) as num")
            ->where("date_stamp", $date)
            ->where("pollid", $pollid)
            ->get("polls_votes");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function get_votes($pollid, $page)
    {
        return $this->db->where("polls_votes.pollid", $pollid)
            ->select("polls_votes.IP, polls_votes.user_agent, 
				polls_votes.timestamp, polls_votes.ID, 
				poll_answers.answer")
            ->join("poll_answers", "poll_answers.ID = 
				polls_votes.answerid")
            ->limit($page, 20)
            ->order_by("polls_votes.ID", "DESC")
            ->get("polls_votes");
    }

    public function get_total_votes_count($pollid)
    {
        $s = $this->db
            ->select("COUNT(*) as num")
            ->where("pollid", $pollid)
            ->get("polls_votes");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function update_all_poll_answers($id, $data)
    {
        $this->db->where("pollid", $id)->update("poll_answers", $data);
    }

    public function delete_poll_votes($pollid)
    {
        $this->db->where("pollid", $pollid)->delete("polls_votes");
    }

    public function delete_poll_countries($pollid)
    {
        $this->db->where("pollid", $pollid)->delete("poll_countries");
    }

    public function get_poll_themes()
    {
        return $this->db->get("poll_themes");
    }

    public function get_poll_theme($id)
    {
        return $this->db->where("ID", $id)->get("poll_themes");
    }

    public function add_poll_theme($data)
    {
        $this->db->insert("poll_themes", $data);
    }

    public function delete_theme($id)
    {
        $this->db->where("ID", $id)->delete("poll_themes");
    }

    public function update_poll_theme($id, $data)
    {
        $this->db->where("ID", $id)->update("poll_themes", $data);
    }

    public function delete_poll($id)
    {
        $this->db->where("ID", $id)->delete("polls");
    }

    public function count_user_votes_date($date, $userid)
    {
        $s = $this->db
            ->select("COUNT(*) as num")
            ->where("date_stamp", $date)
            ->where("userid", $userid)
            ->get("polls_votes");
        $r = $s->row();
        if (isset($r->num)) {
            return $r->num;
        }
        return 0;
    }

    public function get_user_recent_polls($userid)
    {
        return $this->db->where("userid", $userid)->limit(5)
            ->order_by("ID", "DESC")->get("polls");
    }
}
