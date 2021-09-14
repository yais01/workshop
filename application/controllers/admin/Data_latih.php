<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_latih extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->output->enable_profiler(TRUE);
        $this->load->model("m_login");
        $this->load->model("m_data_latih");
        $this->load->model("m_register");
        $this->load->model("m_admin");
        $this->load->model("m_user");
        $this->load->model("m_log");
        $this->load->helper('array');
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $log['log_datetime'] = date("Y-m-d H:i:s");
        $log['log_message'] = "HOMEPAGE :  user => " . $this->session->userdata('user_username') . "( id = " . $this->session->userdata('user_id') . ") ; result => ";
        $log['user_id'] = $this->session->userdata('user_id');
        $log['log_message'] .= "true";
        $this->m_log->inserLog($log);
        //   $data=$this->m_kost->getData( $this->session->userdata('user_id') );
        //   $data['files'] = $data;
        $data['page_name'] = "Data Latih";
        $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'))[0];
        $data['files'] = $this->m_data_latih->read();
        $this->load->view("_admin/_template/header");
        $this->load->view("_admin/_template/sidebar_menu");
        $this->load->view("_admin/data_latih/View_list", $data);
        $this->load->view("_admin/_template/footer");
    }
    
    public function editlatih($id_latih)
    {
        $where = array('id_latih' => $id_latih);
        $data['latihedit'] = $this->m_data_latih->edit_latih($where, 'data_latih')->result();
        $data['page_name'] = "Edit Data latih";
        
            $this->load->view("_admin/_template/header");
            $this->load->view("_admin/_template/sidebar_menu");
            $this->load->view("_admin/data_latih/View_edit",$data);
            $this->load->view("_admin/_template/footer"); 
    }  
    public function updatelatih()
    {
        $id_latih = $this->input->post('id_latih');
        $jenis = $this->input->post('jenis');
        $area = $this->input->post('area');
        $perimeter = $this->input->post('perimeter');
        $metric = $this->input->post('metric');
        $eccentricity = $this->input->post('eccentricity');
        $major_axis = $this->input->post('major_axis');
        $minor_axis = $this->input->post('minor_axis');
        $diameter = $this->input->post('diameter');
        
        $where = array('id_latih' => $id_latih);
        
        $data = array(
            'id_latih' => $id_latih,
            'jenis' => $jenis,
            'area' => $area,
            'perimeter' => $perimeter,
            'metric' => $metric,
            'eccentricity' => $eccentricity,
            'major_axis' => $major_axis,
            'minor_axis' => $minor_axis,
            'diameter' => $diameter,
        );
        
        $this->m_data_latih->update_data($where, $data);
        redirect('admin/data_latih');
    }

    public function create()
    {
        $data['page_name'] = "Tambah Data Testing";
        $inpust =  ($this->input->post('area[]') == null) ? array() : $this->input->post('area[]');
        // echo var_dump( $inpust );
        foreach ($inpust as $ind => $val) {
            if (!empty($this->input->post('area')[$ind])) {
                $this->form_validation->set_rules('area[' . $ind . ']', 'area', 'trim|required');
                $this->form_validation->set_rules('perimeter[' . $ind . ']', 'perimeter', 'trim|required');
                $this->form_validation->set_rules('metric[' . $ind . 'metric', 'trim|required');
                $this->form_validation->set_rules('eccentricity[' . $ind . ']', 'eccentricity', 'trim|required');
                $this->form_validation->set_rules('major_axis[' . $ind . ']', 'major_axis', 'trim|required');
                $this->form_validation->set_rules('minor_axis[' . $ind . ']', 'minor_axis', 'trim|required');
                $this->form_validation->set_rules('diameter[' . $ind . ']', 'diameter', 'trim|required');
                $this->form_validation->set_rules('jenis[' . $ind . ']', 'jenis', 'trim|required');
            }
        }

        if ($this->form_validation->run() == true) {
            $data_latih = array();
            $inpust =  ($this->input->post('area[]') == null) ? array() : $this->input->post('area[]');
            foreach ($inpust as $ind => $val) {
                $data = array();
                if (!empty($this->input->post('area')[$ind])) {
                    $data_train["area"] = $this->input->post('area')[$ind];
                    $data_train["perimeter"] = $this->input->post('perimeter')[$ind];
                    $data_train["metric"] = $this->input->post('metric')[$ind];
                    $data_train["eccentricity"] = $this->input->post('eccentricity')[$ind];
                    $data_train["major_axis"] = $this->input->post('major_axis')[$ind];
                    $data_train["minor_axis"] = $this->input->post('minor_axis')[$ind];
                    $data_train["diameter"] = $this->input->post('diameter')[$ind];
                    $data_train["jenis"] = $this->input->post('jenis')[$ind];

                    array_push($data_latih, $data_train);
                }
            }

            // echo var_dump( $data_testing );
            if ($this->m_data_latih->create($data_latih)) {
                $this->session->set_flashdata('info', array(
                    'from' => 1,
                    'message' =>  'item berhasil ditambah'
                ));
                redirect(site_url('admin/data_latih'));
                return;
            }
            $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
            redirect(site_url('admin/data_latih'));
        } else {
            $data['files'] = $this->m_data_latih->read();
            $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
            $this->load->view("_admin/_template/header");
            $this->load->view("_admin/_template/sidebar_menu");
            $this->load->view("_admin/data_latih/View_create", $data);
            $this->load->view("_admin/_template/footer");
        }
    }

    public function import()
    {
        $data['page_name'] = "import Data latih";
        // if( !($_POST) ) redirect(site_url(''));  

        $this->load->library('upload'); // Load librari upload
        $filename = "excel";
        $config['upload_path'] = './upload/datatestingexcel/';
        $config['allowed_types'] = "xls|xlsx";
        $config['overwrite'] = "true";
        $config['max_size'] = "2048";
        $config['file_name'] = '' . $filename;
        $this->upload->initialize($config);

        if ($this->upload->do_upload("document_file")) {
            $filename = $this->upload->data()["file_name"];
            // echo $filename;
            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel.php';

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('upload/datatestingexcel/' . $filename); // Load file yang telah diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            // Buat sebuah vari
            $data_latih = array();
            $numrow = 1;
            foreach ($sheet as $row) {
                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 1 &&  !empty($row['A'])) {
                    $data_train["id_latih"] = $row['A'];
                    $data_train["jenis"] = $row['B'];
                    $data_train["area"] = $row['C'];
                    $data_train["perimeter"] = $row['D'];
                    $data_train["metric"] = $row['E'];
                    $data_train["eccentricity"] = $row['F'];
                    $data_train["major_axis"] = $row['G'];
                    $data_train["minor_axis"] = $row['H'];
                    $data_train["diameter"] = $row['I'];

                    // Kita push (add) array data ke variabel data
                    array_push($data_latih, $data_train);
                }

                $numrow++; // Tambah 1 setiap kali looping
            }

            // echo var_dump( $data_testing );
            if ($this->m_data_latih->create($data_latih)) {
                $this->session->set_flashdata('info', array(
                    'from' => 1,
                    'message' =>  'item berhasil diimport'
                ));
                redirect(site_url('admin/data_latih'));
                return;
            }
            $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
            redirect(site_url('admin/data_testing'));
        } else {
            echo  $this->upload->display_errors();
            $this->load->view("_admin/_template/header");
            $this->load->view("_admin/_template/sidebar_menu");
            $this->load->view("_admin/data_latih/View_import", $data);
            $this->load->view("_admin/_template/footer");
        }
    }

   
    public function delete($id_latih = null)
    {
        if ($id_latih == null) redirect(site_url('admin/data_latih'));

        $data_param['id_latih'] = $id_latih;
        if ($this->m_data_latih->delete($data_param)) {
            $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'item berhasil diubah'
            ));
            redirect(site_url('admin/data_latih'));
            return;
        }
        $this->session->set_flashdata('info', array(
            'from' => 0,
            'message' =>  'terjadi kesalahan saat mengirim data'
        ));
        redirect(site_url('admin/data_latih'));
    }
    
    function hapusall(){
		$this->m_data_latih->hapus_data();
		redirect(site_url('admin/data_latih'));
	}
}
