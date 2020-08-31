<?php
defined('BASEPATH') or exit('No direct script access allowed');


class MY_Model extends CI_Model
{
    public $tbl;
    public $pkey;
    public $date;

    private $primary_key = 'id';
    private $table_name = 'table';
    private $field_search;

    public function __construct($config = array())
    {
        parent::__construct();

        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }

        $this->load->database();
    }

    public function remove($id = null)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table_name);
    }

    public function change($id = null, $data = array())
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $data);

        return $this->db->affected_rows();
    }

    public function find($id = null, $select_field = [])
    {
        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->db->where("".$this->table_name.'.'.$this->primary_key, $id);
        $query = $this->db->get($this->table_name);

        if ($query->num_rows()>0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function find_all()
    {
        $this->db->order_by($this->primary_key, 'DESC');
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function store($data = array())
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function get_all_data($table = '')
    {
        $query = $this->db->get($table);

        return $query->result();
    }


    public function get_single($where)
    {
        $query = $this->db->get_where($this->table_name, $where);

        return $query->row();
    }

    public function scurity($input)
    {
        return mysqli_real_escape_string($this->db->conn_id, $input);
    }

    public function export($table, $subject = 'file')
    {
        $this->load->library('excel');

        $result = $this->db->get($table);

        $this->excel->setActiveSheetIndex(0);

        $fields = $result->list_fields();

        $alphabet = 'ABCDEFGHIJKLMOPQRSTUVWXYZ';
        $alphabet_arr = str_split($alphabet);
        $column = [];

        foreach ($alphabet_arr as $alpha) {
            $column[] =  $alpha;
        }

        foreach ($alphabet_arr as $alpha) {
            foreach ($alphabet_arr as $alpha2) {
                $column[] =  $alpha.$alpha2;
            }
        }
        foreach ($alphabet_arr as $alpha) {
            foreach ($alphabet_arr as $alpha2) {
                foreach ($alphabet_arr as $alpha3) {
                    $column[] =  $alpha.$alpha2.$alpha3;
                }
            }
        }

        foreach ($column as $col) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        }

        $col_total = $column[count($fields)-1];

        //styling
        $this->excel->getActiveSheet()->getStyle('A1:'.$col_total.'1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'DA3232')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            )
        );

        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FFFFFF');

        $this->excel->getActiveSheet()->getStyle('A1:'.$col_total.'1')->getFont()->setColor($phpColor);

        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

        $this->excel->getActiveSheet()->getStyle('A1:'.$col_total.'1')
        ->getAlignment()->setWrapText(true);

        $col = 0;
        foreach ($fields as $field) {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, ucwords(str_replace('_', ' ', $field)));
            $col++;
        }
 
        $row = 2;
        foreach ($result->result() as $data) {
            $col = 0;
            foreach ($fields as $field) {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }

        //set border
        $styleArray = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $this->excel->getActiveSheet()->getStyle('A1:'.$col_total.''.$row)->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->setTitle(ucwords($subject));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.ucwords($subject).'-'.date('Y-m-d').'.xls');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function pdf($table, $title)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);

        $result = $this->db->get($table);
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title
        ], true);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }

    public function getKey($id)
    {
        return MEMCACHE_NAME . '_' . $this->tbl . '_' . $id;
    }
    public function getArrKey($key_open = 'SYS')
    {
        return $this->getCache(MEMCACHE_NAME . '_' . $this->tbl . '_' . $key_open);
    }
    public function setArrKey($key, $key_open = 'SYS')
    {
        $arr = $this->getArrKey($key_open);
        if (!in_array($key, $arr)) {
            $arr[] = $key;
            return $this->updateCache(MEMCACHE_NAME . '_' . $this->tbl . '_' . $key_open, $arr, 0);
        } else {
            return true;
        }
    }
    public function deleteArrKey($key_open = 'SYS')
    {
        $arr     = $this->getArrKey($key_open);
        $new_arr = array();
        if ($arr) {
            foreach ($arr as $key) {
                $res = $this->deleteCache($key);
                if (!$res) {
                    $new_arr[] = $key;
                }
            }
        }
        //$this->cache->flush();
        return $this->updateCache(MEMCACHE_NAME . '_' . $this->tbl . '_' . $key_open, $new_arr, 0);
    }
    public function getCache($key)
    {
        return $this->cache->get($key);
    }
    public function setCache($key, $value = 'null', $time = 0)
    {
        return $this->cache->set($value, $key,true);
    }
    public function updateCache($key, $value = 'null', $time = 0)
    {
        $this->cache->delete($key);
        return $this->cache->set($value, $key, $time);
    }
    public function deleteCache($key)
    {
        return $this->cache->delete($key);
    }
    public function setCacheBox($key, $html)
    {
        $key = MEMCACHE_NAME . '_BOX_' . $key;
        $this->setCache($key, $html, 86400);
        $this->setArrKey($key, 'BOX');
        echo $html;
    }
    public function getCacheBox($key)
    {
        $key = MEMCACHE_NAME . '_BOX_' . $key;
        return $this->getCache($key);
    }
    public function getField($id, $field)
    {
        $sql = 'SELECT ' . $field . ' FROM ' . $this->tbl . ' where ' . $this->pkey . '="' . $id . '"';
        $query = $this->db->query($sql);
        if ($row = $query->result_array()) {
            return $row;
        } else {
            return null;
        }
    }
    public function getOne($id)
    {
        if (!$id) {
            return false;
        }
        $key = $this->getKey($id);
        $arr = $this->getCache($key);
        if ($arr) {
            if ($arr == 'null') {
                return false;
            } else {
                return $arr;
            }
        } else {
            $sql = 'SELECT * FROM ' . $this->tbl . ' where ' . $this->pkey . '=' . $id;
            $query = $this->db->query($sql);
            if($query !== FALSE && $query->num_rows() > 0){
                foreach ($query->result_array() as $arr) {
                    $this->setCache($key, $arr, MEMCACHE_EXPI * 5);
                }
                $query->free_result();
            }
        }
        return $arr;
    }

    public function updateParam($param, $value)
    {
        if (!$param or !$value) {
            return false;
        }
        $key = $this->getKey('PARAM_'.$this->tbl.'_'.$param.'_'.$value);
        $this->deleteCache($key);
        return true;
    }
    
    public function getParam($param, $value)
    {
        if (!$param or !$value) {
            return false;
        }
        $key = $this->getKey('PARAM_'.$this->tbl.'_'.$param.'_'.$value);
        $arr = $this->getCache($key);
        if ($arr) {
            if ($arr == 'null') {
                return false;
            } else {
                return $arr;
            }
        } else {
            $sql = 'SELECT * FROM ' . $this->tbl . ' where ' . $param . '="' . $value.'"';
            $query = $this->db->query($sql);
            $_cn = $query->result_array();
            if (count($_cn) > 0) {
                foreach ($_cn as $arr) {
                    $this->setCache($key, $arr, 86400);
                }
            } else {
                $this->setCache($key, 'null', 86400);
            }
            $this->setArrKey($key, $key_open);
            $query->free_result();
        }
        return $arr;
    }

    public function getCount($cons, $cache = true, $key_open = 'SYS')
    {
        $key = MEMCACHE_NAME . '_COUNT_' . md5($this->tbl . $cons);
        if ($cache) {
            $res = $this->getCache($key);
        }
        if ($res == 'null') {
            return 0;
        }
        if ($res) {
            return $res;
        }
        if ($cons != '') {
            $cons = ' WHERE ' . $cons;
        }
        $sql = 'SELECT count(' . $this->pkey . ') as intCount FROM ' . $this->tbl . $cons;
        $query = $this->db->query($sql);
        if ($_cn = $query->result_array()) {
            $res = $_cn[0]['intCount'];
            if ($res) {
                $this->setCache($key, $res, 86400);
            } else {
                $this->setCache($key, 'null', 86400);
            }
            $this->setArrKey($key, $key_open);
            $query->free_result();
            return $res;
        }
    }
    public function getMax($field, $cons, $key_open = 'SYS')
    {
        $key = MEMCACHE_NAME . '_MAX_' . md5($this->tbl . $field . $cons);
        //$res = $this->getCache($key);
        $res = '';
        if ($res == 'null') {
            return 0;
        }
        if ($res) {
            return $res;
        }
        if ($cons != '') {
            $cons = ' WHERE ' . $cons;
        }
        $sql = 'SELECT max(' . $field . ') as intMax FROM ' . $this->tbl . $cons;
        $query = $this->db->query($sql);
        if ($_cn = $query->result_array()[0]) {
            $res = isset($_cn['intMax']) ? $_cn['intMax'] : false;
            if ($res) {
                $this->setCache($key, $res, 86400);
            } else {
                $this->setCache($key, 'null', 86400);
            }
            $this->setArrKey($key, $key_open);
            $query->free_result();
            return $res;
        }
    }
    public function getSum($field, $cons, $key_open = 'SYS')
    {
        $key = MEMCACHE_NAME . '_SUM_' . md5($this->tbl . $field . $cons);
        //$res = $this->getCache($key);
        $res = '';
        if ($res == 'null') {
            return 0;
        }
        if ($res) {
            return $res;
        }
        if ($cons != '') {
            $cons = ' WHERE ' . $cons;
        }
        $query = $this->db->query('SELECT sum(' . $field . ') as intSum FROM ' . $this->tbl . $cons);
        
        if ($_cn = $query->result_array()) {
            //$res = $_cn['intSum'];
            if (isset($_cn[0]['intSum'])) {
                $this->setCache($key, $_cn[0]['intSum'], 86400);
                $this->setArrKey($key, $key_open);
                return $_cn[0]['intSum'];
            } else {
                $this->setCache($key, 'null', 86400);
                $this->setArrKey($key, $key_open);
                return false;
            }
        }
    }
    public function getAll($cons, $cache = true, $key_open = 'SYS')
    {
        $key = MEMCACHE_NAME . '_ALL_' . md5($this->tbl . $cons);
        if ($cache) {
            $arr = $this->getCache($key);
        }
        //$arr = '';
        else {
            $arr = false;
        }
        $arr = '';
        if ($arr) {
            if ($arr == 'null') {
                return false;
            } else {
                return $arr;
            }
        } else {
            if ($cons != '') {
                $cons = ' WHERE ' . $cons;
            }
            $query = $this->db->query('SELECT ' . $this->pkey . ' FROM ' . $this->tbl . $cons);
            $_cn = $query->result_array();
            if ($_cn) {
                $arr = array();
                foreach ($_cn as $keys => $value) {
                    $arr[] = $_cn[$keys][$this->pkey];
                }

                /*while ($_cn = $query->result_array()) {
                    $arr[] = $_cn[$this->pkey];
                }*/
                $query->free_result();
                if ($arr) {
                    $this->setCache($key, $arr, 86400);
                } else {
                    $this->setCache($key, 'null', 86400);
                }
                $this->setArrKey($key, $key_open);
                return $arr;
            } else {
                return false;
            }
        }
    }
    public function updateOne($id, $array)
    {
        if (!is_array($array)) {
            return false;
        }
        $key_cache    = $this->getKey($id);
        $oneItem      = $this->getCache($key_cache);
        $exists_cache = false;
        if ($oneItem) {
            $exists_cache = true;
            if ($oneItem == 'null') {
                $oneItem = array();
            }
        }
        $value = '';
        if ($array) {
            foreach ($array as $key => $val) {
                if (!$value) {
                    $value = $key . '="' . addslashes($val) . '"';
                } else {
                    $value .= ',' . $key . '="' . addslashes($val) . '"';
                }
                $oneItem[$key] = $val;
            }
        }
        $this->db->trans_start();
        $query = $this->db->query('UPDATE ' . $this->tbl . ' SET ' . $value . ' WHERE ' . $this->pkey . '=' . $id);
        //$res = $this->db->affected_rows();
        $this->db->trans_complete();
        $res = $this->db->trans_status();
        $this->updateCache($key_cache, $oneItem, 86400);
        
        return $res;
    }
    public function updateAll($cons, $array, $key_open = 'SYS')
    {
        if (!is_array($array)) {
            return false;
        } else {
            foreach ($array as $key => $val) {
                if (!$value) {
                    $value = $key . '="' . addslashes($val) . '"';
                } else {
                    $value .= ',' . $key . '="' . addslashes($val) . '"';
                }
            }
        }
        $this->db->trans_start();
        $query = $this->db->query('UPDATE ' . $this->tbl . ' SET ' . $value . ' WHERE ' . $cons);
        $this->db->trans_complete();
        if ($this->db->trans_status() && $key_open) {
            $this->deleteArrKey($key_open);
        }
        return $res;
    }
    public function insertOne($array, $clean_cache = true, $key_open = 'SYS')
    {
        if (!is_array($array)) {
            return false;
        }
        if ($array) {
            foreach ($array as $key => $val) {
                if (!isset($field)) {
                    $field = $key;
                } else {
                    $field .= ',' . $key;
                }
                if (!isset($value)) {
                    $value = '"' . addslashes($val) . '"';
                } else {
                    $value .= ',"' . addslashes($val) . '"';
                }
            }
        }
        if ($clean_cache) {
            $this->deleteArrKey($key_open);
        }
        //$this->db->trans_start();
        $query = $this->db->query('INSERT INTO ' . $this->tbl . ' (' . $field . ') VALUES(' . $value . ')');
        //$this->db->trans_complete();
        $res = $this->db->insert_id();
        
        return $res;
    }
    public function deleteOne($id, $clean_cache = true, $key_open = 'SYS')
    {
        if (isset($this->files)) {
            $one = $this->getOne($id);
            if ($this->files) {
                foreach ($this->files as $val) {
                    if ($one[$val]) {
                        global $core;
                        ftpDelete(ltrim($one[$val], '/'));
                    }
                }
            }
        }
        if ($clean_cache) {
            $this->deleteArrKey($key_open);
        }
        $this->db->trans_start();
        $sql = 'DELETE FROM ' . $this->tbl . ' WHERE ' . $this->pkey . '=' . $id;
        $query = $this->db->query($sql);
        $this->db->trans_complete();
        $res = $this->db->trans_status();
        $this->deleteCache($this->getKey($id));
        return $res;
    }
    public function deleteAll($cons, $key_open = 'SYS')
    {
        $all = $this->getAll($cons, true, $key_open);
        if ($all) {
            foreach ($all as $one) {
                $this->deleteOne($one, true, $key_open);
            }
        }
        return true;
    }
    public function getListPage($cons, $rpp = RECORD_PER_PAGE, $key_open = 'SYS')
    {
        if ($cons == '') {
            $cons = '1=1';
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        return $this->getAll($cons . ' LIMIT ' . ($page - 1) * $rpp . ',' . $rpp, true, $key_open);
    }
    public function getNavPage($cons, $rpp = 15, $key_open = 'SYS')
    {
        if (!$cons) {
            $cons = '1=1';
        }
        $page      = isset($_GET['page']) ? $_GET['page'] : 1;
        $totalPage = ceil($this->getCount($cons, true, $key_open) / $rpp);
        $paging    = array();
        if ($page < $totalPage / 2) {
            $_from = max($page - 3, 1);
            $_to   = min($_from + 6, $totalPage + 1);
        } else {
            $_to   = min($page + 4, $totalPage + 1);
            $_from = max($_to - 6, 1);
        }
        if ($page > 1) {
            $paging[] = array(
                0 => 1,
                1 => 'Đầu'
            );
        }
        for ($i = $_from; $i < $_to; $i++) {
            if ($i > 0 && $i <= $totalPage) {
                $paging[] = array(
                    0 => $i,
                    1 => $i
                );
            }
        }
        if ($page < $totalPage) {
            $paging[] = array(
                0 => $totalPage,
                1 => 'Cuối'
            );
        }
        return $paging;
    }
    public function slugToID($slug)
    {
        $all = $this->getAll('slug="' . $slug . '" order by ' . $this->pkey . ' desc limit 1');
        if ($all) {
            return $all[0];
        } else {
            return false;
        }
    }
    public function getMaxID($key_open = 'SYS')
    {
        return $this->getMax($this->pkey, '1=1', $key_open);
    }
    public function getRegDate($_id, $field = 'reg_date')
    {
        $res      = $this->getOne($_id);
        $reg_date = strtotime($res[$field]);
        return '<time class="ago" datetime="' . date('Y-m-d', $reg_date) . 'T' . date('H:i:s', $reg_date) . 'Z+07:00">' . date('H:i - d.m.Y', $reg_date) . '</time>';
    }
    public function getImage($id, $w, $h, $field = 'image', $nophoto = null, $one = null)
    {
        if (!$nophoto) {
            $nophoto = DOMAIN.'/assets/images/no-photo.jpg';
        }
        if (!$one) {
            $one = $this->getOne($id);
        }
        $image = trim($one[$field]);
        if (!$image) {
            $image = $nophoto;
        }
        return MEDIA_DOMAIN . '/resize/' . $w . 'x' . $h . $image;
    }
}

/* End of file My_Model.php */
/* Location: ./application/core/My_Model.php */
