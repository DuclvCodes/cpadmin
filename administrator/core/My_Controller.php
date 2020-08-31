<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/Jwt/BeforeValidException.php';
require_once APPPATH . '/libraries/Jwt/ExpiredException.php';
require_once APPPATH . '/libraries/Jwt/SignatureInvalidException.php';
require_once APPPATH . '/libraries/Jwt/JWT.php';
//require_once APPPATH . '/libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class MY_Controller extends CI_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        
        $this->config->set_item('language', 'english');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        $this->load->helper(['cookie']);

        if ($lang = get_cookie('language')) {
            $this->lang->load([
                'web',
                'form_validation',
                'upload',
                'db',
            ], $lang);
        } else {
            //$lang = get_lang_by_ip($this->input->ip_address());
            $lang = 'english';
            $this->lang->load([
                'web',
                'form_validation',
                'upload',
                'db',
            ], $lang);
            set_cookie('language', $lang, (60 * 60 * 24) * 365);
        }

        //date_default_timezone_set(get_option('timezone', 'asia/jakarta'));
        //load_extensions();
        $this->load->library(['aauth', 'cc_html', 'cc_page_element', 'cc_app', 'cc_extension']);

        if (ENVIRONMENT != 'production') {
            $this->output->enable_profiler(true);
        }
    }

    /**
    * Response JSON
    *
    * @param Array $data
    * @param String $status
    *
    * @return JSON
    */
    public function response($data, $status = 200)
    {
        die(json_encode($data));

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }

    /**
    * Render pagination
    *
    * @param Array $config
    *
    * @return HTML
    */
    public function pagination($config = [])
    {
        $this->load->library('pagination');
        
        $config = [
            'suffix'           => isset($_GET)?'?'.http_build_query($_GET):'',
            'base_url'         => site_url($config['base_url']),
            'total_rows'       => $config['total_rows'],
            'per_page'         => $config['per_page'],
            'uri_segment'      => $config['uri_segment'],
            'num_links'        => 1,
            'num_tag_open'     => '<li>',
            'num_tag_close'    => '</li>',
            'full_tag_open'    => '<ul class="pagination">',
            'full_tag_close'   => '</ul>',
            'first_link'       => 'First',
            'first_tag_open'   => '<li>',
            'first_tag_close'  => '</li>',
            'last_link'        => 'Last',
            'last_tag_open'    => '<li>',
            'last_tag_close'   => '</li>',
            'next_link'        => 'Next',
            'next_tag_open'    => '<li>',
            'next_tag_close'   => '</li>',
            'prev_link'        => 'Prev',
            'prev_tag_open'    => '<li>',
            'prev_tag_close'   => '</li>',
            'cur_tag_open'     => '<li class="active"><a href="#">',
            'cur_tag_close'    => '</a></li>',
        ];

        $this->pagination->initialize($config);
        
        return  '<center>'.$this->pagination->create_links().'</center>';
    }

    /**
    * Valid number
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_number($str)
    {
        $this->form_validation->set_message('valid_number', 'The %s field may only contain number characters.');

        if (preg_match("/[0-9]/", $str)) {
            return true;
        }

        return false;
    }

    /**
    * Regular expression validation
    *
    * @param String $str
    * @param String $val
    *
    * @return boolean
    */
    public function regex($str, $val = null)
    {
        $this->form_validation->set_message('regex', 'The %s field must be in accordance with the pattern.');

        if ($ret = preg_match("/".$val."/", $str)) {
            return true;
        }

        return false;
    }

    /**
    * datetime validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_datetime($str)
    {
        $this->form_validation->set_message('valid_datetime', 'The %s field may only contain date time.');

        if ($ret = preg_match("[(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2})]", $str)) {
            return true;
        }

        return false;
    }

    /**
    * Date validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_date($str)
    {
        $this->form_validation->set_message('valid_date', 'The %s field may only contain date.');

        if ($ret = preg_match("[(\d{4})\-(\d{2})\-(\d{2})]", $str)) {
            return true;
        }

        return false;
    }

    /**
    * Group validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_group($str)
    {
        $str = json_decode($str);
        $this->form_validation->set_message('valid_group', 'The %s field may only contain array.');

        if (is_array($str)) {
            return true;
        }

        return false;
    }

    /**
    * Valid regex validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_regex($str)
    {
        $this->form_validation->set_message('valid_regex', 'The %s field pattern "'.$str.'" is not valid.');

        if (@preg_match($str, null) === false) {
            return false;
        }

        return true;
    }
    
    /**
    * Valid regex validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_alpha_numeric_spaces_underscores($str)
    {
        $this->form_validation->set_message('valid_alpha_numeric_spaces_underscores', 'The %s field input only alpha numeric spaces and underscores.');

        return (bool) preg_match('/^[A-Z0-9 _]+$/i', $str);
    }

    /**
    * Valid disallowed chars
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_disallowed_chars($str)
    {
        $this->form_validation->set_message('valid_disallowed_chars', 'The %s character '.$chars.' dis allowed.');

        if (preg_match('(\')/i', $str)) {
            return false;
        }
        return true;
    }
    
    /**
    * Valid regex validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_json($str)
    {
        $this->form_validation->set_message('valid_json', 'The %s field input not valid json format.');

        json_decode($str);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
    * Valid multiple value validation
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_multiple_value($str)
    {
        $this->form_validation->set_message('valid_multiple_value', 'The %s field input not valid multiple value ex val1, val2, val3, more.');

        return (count(explode(',', $str)));
    }

    /**
    * Valid table is avaiable
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_table_avaiable($str)
    {
        $this->form_validation->set_message('valid_table_avaiable', 'The %s is not valid.');
        $tables = $this->db->list_tables();

        return in_array($str, $tables);
    }

    /**
    * Valid captcha
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_captcha($str)
    {
        $this->form_validation->set_message('valid_captcha', 'You must submit %s word that appears in the %s image.');

        $expiration = time() - 7200;

        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array($str, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0) {
            return false;
        }

        return true;
    }

    /**
    * Valid extension list
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_extension_list($str)
    {
        $this->load->helper('file');

        $mimes = get_mimes();
        $mime_arr = [];
        $ret = true;
        $mime_not_valid = [];

        foreach ($mimes as $key => $value) {
            $mime_arr[] = $key;
        }
        if (strpos($str, ',') === false) {
            $mime_not_valid[] = $str;
            $ret = in_array(strtolower(trim($str)), $mime_arr);
        }

        foreach (explode(',', $str) as $extension) {
            if (trim($extension) !== '' && in_array(strtolower(trim($extension)), $mime_arr) === false) {
                $mime_not_valid[] = $extension;
                $ret = false;
            }
        }

        $this->form_validation->set_message('valid_extension_list', 'The %s extension "'.implode(',', $mime_not_valid).'" is not valid.');

        return $ret;
    }

    /**
    * Validation max selected option
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_max_selected_option($str, $val = 2)
    {
        $field_match = $this->check_field_has_rules('valid_max_selected_option\['.$val.'\]', $str);
        $this->form_validation->set_message('valid_max_selected_option', 'The %s field selected options maximum is "'.$val.'".');

        if ($field_match) {
            $field = $this->input->post($field_match);

            if (is_array($field)) {
                if (count($field) <= $val) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
    * Validation min selected option
    *
    * @param String $str
    *
    * @return boolean
    */
    public function valid_min_selected_option($str, $val = 2, $additional = 55)
    {
        $field_match = $this->check_field_has_rules('valid_min_selected_option\['.$val.'\]', $str);

        if ($field_match) {
            $field = $this->input->post($field_match);

            $this->form_validation->set_message('valid_min_selected_option', 'The %s field selected options minimum is "'.$val.'".');

            if (is_array($field)) {
                if (count($field) < $val) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
    * Check field has rules
    *
    * @param String $str
    *
    * @return boolean
    */
    public function check_field_has_rules($rule_name = null, $post_data = null)
    {
        foreach ($this->form_validation->_field_data as $field_name => $option) {
            if (isset($option['rules'])) {
                foreach ($option['rules'] as $rule) {
                    if (preg_match("/".$rule_name."/", $rule)) {
                        if (is_array($option['postdata'])) {
                            if (in_array($post_data, $option['postdata'])) {
                                return str_replace('[]', '', $field_name);
                            }
                        }
                    }
                }
            }
        }

        return false;
    }
}

/**
* Admin controller
*
* This class will be extended with administrator class modules
*/
class Admin extends MY_Controller
{
    public $limit_page = 10;

    public function __construct()
    {
        parent::__construct();
    }


    /**
    * render admin page
    *
    * @param String $view
    * @param Array $data
    * @param Boolean $bool
    *
    * @return JSON
    */
    public function render($view = '', $data = array(), $bool = false)
    {
        $this->template->enable_parser(false);
        $this->template->set_partial('content', $view, $data);
        $this->template->build('backend/standart/main_layout', $data);
    }

    /**
    * User is allowed
    *
    * @param String $perm
    * @param Boolean $redirect
    *
    * @return JSON
    */
    public function is_allowed($perm, $redirect = true)
    {
        if (!$this->aauth->is_loggedin()) {
            if ($redirect) {
                redirect('administrator/login', 'refresh');
            } else {
                return false;
            }
        } else {
            if ($this->aauth->is_allowed($perm)) {
                return true;
            } else {
                if ($redirect) {
                    $this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
                    $this->session->set_flashdata('f_type', 'warning');
                    redirect('administrator/dashboard', 'refresh');
                }
                return false;
            }
        }
    }

    /**
    * Upload Files tmp
    *
    * @param Array $data
    *
    * @return JSON
    */
    public function upload_file($data = [])
    {
        $default = [
            'uuid'          => '',
            'allowed_types' => '*',
            'max_size'      => '',
            'max_width'     => '',
            'max_height'    => '',
            'upload_path'   => './uploads/tmp/',
            'input_files'   => 'qqfile',
            'table_name'    => '',
        ];

        foreach ($data as $key => $value) {
            if (isset($default[$key])) {
                $default[$key] = $value;
            }
        }

        $dir = FCPATH . $default['upload_path'] . $default['uuid'];
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        if (empty($default['file_name'])) {
            $default['file_name'] = date('Y-m-d').$default['table_name'].date('His');
        }

        $config = [
            'upload_path'       => $default['upload_path'] . $default['uuid'] . '/',
            'allowed_types'     => $default['allowed_types'],
            'max_size'          => $default['max_size'],
            'max_width'         => $default['max_width'],
            'max_height'        => $default['max_height'],
            'file_name'         => $default['file_name']
        ];
        
        $this->load->library('upload', $config);
        $this->load->helper('file');

        if (! $this->upload->do_upload('qqfile')) {
            $result = [
                'success'   => false,
                'error'     =>  $this->upload->display_errors()
            ];

            return json_encode($result);
        } else {
            $upload_data = $this->upload->data();

            $result = [
                'uploadName'    => $upload_data['file_name'],
                'previewLink'  => $dir.'/'.$upload_data['file_name'],
                'success'       => true,
            ];

            return json_encode($result);
        }
    }

    /**
    * Delete Files tmp
    *
    * @param Array $data
    *
    * @return JSON
    */
    public function delete_file($data = [])
    {
        $default = [
            'uuid'              => '',
            'delete_by'         => '',
            'field_name'        => 'image',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'test',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/blog/'
        ];

        foreach ($data as $key => $value) {
            if (isset($default[$key])) {
                $default[$key] = $value;
            }
        }

        if (!empty($default['uuid'])) {
            $this->load->helper('file');
            $delete_file = false;

            if ($default['delete_by'] == 'id') {
                $row = $this->db->get_where($default['table_name'], [$default['primary_key'] => $default['uuid']])->row();
                if ($row) {
                    $path = FCPATH . $default['upload_path'] . $row->{$default['field_name']};
                }

                if (isset($default['uuid'])) {
                    if (is_file($path)) {
                        $delete_file = unlink($path);
                        $this->db->where($default['primary_key'], $default['uuid']);
                        $this->db->update($default['table_name'], [$default['field_name'] => '']);
                    }
                }
            } else {
                $path = FCPATH . $default['upload_path_tmp'] . $default['uuid'] . '/';
                $delete_file = delete_files($path, true);
            }

            if (isset($default['uuid'])) {
                if (is_dir($path)) {
                    rmdir($path);
                }
            }

            if (!$delete_file) {
                $result = [
                    'error' =>  'Error delete file'
                ];

                return json_encode($result);
            } else {
                $result = [
                    'success' => true,
                ];

                return json_encode($result);
            }
        }
    }

    /**
    * Get Files
    *
    * @param Array $data
    *
    * @return JSON
    */
    public function get_file($data = [])
    {
        $default = [
            'uuid'              => '',
            'delete_by'         => '',
            'field_name'        => 'image',
            'table_name'        => 'test',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/blog/',
            'delete_endpoint'   => 'administrator/blog/delete_image_file'
        ];

        foreach ($data as $key => $value) {
            if (isset($default[$key])) {
                $default[$key] = $value;
            }
        }
        
        $row = $this->db->get_where($default['table_name'], [$default['primary_key'] => $default['uuid']])->row();

        if (!$row) {
            $result = [
                'error' =>  'Error getting file'
            ];

            return json_encode($result);
        } else {
            if (!empty($row->{$default['field_name']})) {
                if (strpos($row->{$default['field_name']}, ',')) {
                    foreach (explode(',', $row->{$default['field_name']}) as $filename) {
                        $result[] = [
                            'success'               => true,
                            'thumbnailUrl'          => check_is_image_ext(base_url($default['upload_path'] . $filename)),
                            'id'                    => 0,
                            'name'                  => $row->{$default['field_name']},
                            'uuid'                  => $row->{$default['primary_key']},
                            'deleteFileEndpoint'    => base_url($default['delete_endpoint']),
                            'deleteFileParams'      => ['by' => $default['delete_by']]
                        ];
                    }
                } else {
                    $result[] = [
                        'success'               => true,
                        'thumbnailUrl'          => check_is_image_ext(base_url($default['upload_path'] . $row->{$default['field_name']})),
                        'id'                    => 0,
                        'name'                  => $row->{$default['field_name']},
                        'uuid'                  => $row->{$default['primary_key']},
                        'deleteFileEndpoint'    => base_url($default['delete_endpoint']),
                        'deleteFileParams'      => ['by' => $default['delete_by']]
                    ];
                }

                return json_encode($result);
            }
        }
    }
}


/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */
