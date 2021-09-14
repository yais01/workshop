<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_uji extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->output->enable_profiler(TRUE);
        $this->load->model("m_login");
        $this->load->model("m_data_latih");
        $this->load->model("m_data_uji");
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

        $data['page_name'] = "Data Uji";
        $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'))[0];
        $data['files'] = $this->m_data_uji->read();
        $data['data_latih']  = $this->m_data_latih->read(); 

        $this->load->view("_admin/_template/header");
        $this->load->view("_admin/_template/sidebar_menu");
        $this->load->view("_admin/data_uji/View_list", $data);
        $this->load->view("_admin/_template/footer");
    }


    public function create()
    {
        $data['page_name'] = "Tambah Data Uji";
        $inpust =  ($this->input->post('area[]') == null) ? array() : $this->input->post('area[]');
        // echo var_dump( $inpust );
        foreach ($inpust as $ind => $val) {
            if (!empty($this->input->post('area')[$ind])) {
                $this->form_validation->set_rules('area[' . $ind . ']', 'area', 'trim|required');
                $this->form_validation->set_rules('perimeter[' . $ind . ']', 'perimeter', 'trim|required');
                $this->form_validation->set_rules('metric[' . $ind . ']', 'metric', 'trim|required');
                $this->form_validation->set_rules('eccentricity[' . $ind . ']', 'eccentricity', 'trim|required');
                $this->form_validation->set_rules('major_axis[' . $ind . ']', 'major_axis', 'trim|required');
                $this->form_validation->set_rules('minor_axis[' . $ind . ']', 'minor_axis', 'trim|required');
                $this->form_validation->set_rules('diametermetric[' . $ind . ']', 'diametermetric', 'trim|required');
                $this->form_validation->set_rules('jenis[' . $ind . ']', 'jenis', 'trim|required');
            }
        }



        if ($this->form_validation->run() == true) {
            $data_uji = array();
            $inpust =  ($this->input->post('area[]') == null) ? array() : $this->input->post('area[]');
            foreach ($inpust as $ind => $val) {
                $data = array();
                if (!empty($this->input->post('area')[$ind])) {
                    $data_test["area"] = $this->input->post('area')[$ind];
                    $data_test["perimeter"] = $this->input->post('perimeter')[$ind];
                    $data_test["metric"] = $this->input->post('metric')[$ind];
                    $data_test["eccentricity"] = $this->input->post('eccentricity')[$ind];
                    $data_test["major_axis"] = $this->input->post('major_axis')[$ind];
                    $data_test["minor_axis"] = $this->input->post('minor_axis')[$ind];
                    $data_test["diameter"] = $this->input->post('diameter')[$ind];
                    $data_test["jenis"] = $this->input->post('jenis')[$ind];

                    array_push($data_uji, $data_test);
                }
            }

            // echo var_dump( $data_testing );
            if ($this->m_data_uji->create($data_uji)) {
                $this->session->set_flashdata('info', array(
                    'from' => 1,
                    'message' =>  'item berhasil ditambah'
                ));
                redirect(site_url('admin/data_uji'));
                return;
            }
            $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
            redirect(site_url('admin/data_uji'));
        } else {
            $data['files'] = $this->m_data_uji->read();
            $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
            $this->load->view("_admin/_template/header");
            $this->load->view("_admin/_template/sidebar_menu");
            $this->load->view("_admin/data_uji/View_create", $data);
            $this->load->view("_admin/_template/footer");
        }
    }

    public function import()
    {
        $data['page_name'] = "import Data uji";
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
            $__data_uji = array();
            $numrow = 1;
            foreach ($sheet as $row) {
                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 1 &&  !empty($row['A'])) {
                    $data_uji["id_uji"] = $row['A'];
                    $data_uji["jenis"] = -1;
                    $data_uji["area"] = $row['B'];
                    $data_uji["perimeter"] = $row['C'];
                    $data_uji["metric"] = $row['D'];
                    $data_uji["eccentricity"] = $row['E'];
                    $data_uji["major_axis"] = $row['F'];
                    $data_uji["minor_axis"] = $row['G'];
                    $data_uji["diameter"] = $row['H'];

                    
                    array_push($__data_uji, $data_uji);
                }

                $numrow++; // Tambah 1 setiap kali looping
            }

            // echo json_encode( $__data_uji );
            // return;
            if ($this->m_data_uji->create($__data_uji)) {
                $this->session->set_flashdata('info', array(
                    'from' => 1,
                    'message' =>  'item berhasil diimport'
                ));
                redirect(site_url('admin/data_uji'));
                return;
            }
            $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
            redirect(site_url('admin/user_management'));
        } else {
            // echo  $this->upload->display_errors();
            $this->load->view("_admin/_template/header");
            $this->load->view("_admin/_template/sidebar_menu");
            $this->load->view("_admin/data_uji/View_import", $data);
            $this->load->view("_admin/_template/footer");
        }
    }


    public function uji()
    {
        if (!($_POST)) redirect(site_url('admin/data_uji'));

        $id_uji = $this->input->post('id_uji');
        $data_uji = $this->m_data_uji->readuji($id_uji, "array");
        $data_latih = $this->m_data_latih->readuji(-1, "array");

        
        
        if (empty($data_uji) || empty($data_latih)) {
            redirect(site_url('admin/data_uji'));
            return;
        }

        if (empty($data_uji)) {
            redirect(site_url('/data_uji'));
            return;
        }
        $DISTANCES = array();
        //prosedur mencari tetangga terdekat
        for ($i = 0; $i < count($data_uji); $i++) {
            $DISTANCES = array();
            for ($j = 0; $j < count($data_latih); $j++) {
                $dist['distance'] = $this->distance($data_uji[$i], $data_latih[$j]);
                $dist['jenis'] = $data_latih[$j]['jenis'];
                $dist['id_uji'] = $data_latih[$j]['id_latih'];

                array_push($DISTANCES, $dist);
            }
            sort($DISTANCES); //mengurutkan distance dari terdekat

            $K_VALUE = $this->input->post('k_value');
            $NEIGHBOUR = array();
            for ($k = 0; $k < $K_VALUE; $k++) //memetakan tetangga
            {
                if (!isset($NEIGHBOUR[$DISTANCES[$k]['jenis']]))
                    $NEIGHBOUR[$DISTANCES[$k]['jenis']] = array();

                array_push($NEIGHBOUR[$DISTANCES[$k]['jenis']], $DISTANCES[$k]);
            }

            $terbesar =  array(); //mencari tetangga terbanyak
            foreach (array_keys($NEIGHBOUR) as $paramName) {

                if (count($NEIGHBOUR[$paramName])  > count($terbesar)) {
                    $terbesar = $NEIGHBOUR[$paramName];
                }
            }

            $data_uji[$i]['jenis'] = $terbesar[0]['jenis'];
        }


        $data["K_VALUE"] = $K_VALUE;
        $data["NEIGHBOURS"] = $NEIGHBOUR;
        $data["distances"] = $DISTANCES;
        //ubah ke array object
        foreach ($data["distances"]  as  $ind => $val) {
        }
        $data["data_uji"] = $data_uji;
        //ubah ke array object
        foreach ($data["data_uji"]  as  $ind => $val) {
            $data["data_uji"][$ind] = (object) $data_uji[$ind];
        }
        // echo json_encode( $data_uji ).'<br>' ;

        // update data uji
        $this->m_data_uji->_update_batch($data_uji);

        $data['page_name'] = "Hasil Data Uji";
        $this->load->view("_admin/_template/header");
        $this->load->view("_admin/_template/sidebar_menu");
        $this->load->view("_admin/data_uji/View_detail_uji", $data);
        $this->load->view("_admin/_template/footer");
    }


    public function uji_batch_2()
    {
        if (!($_POST)) redirect(site_url('admin/data_uji'));
        
        $data_uji = $this->m_data_uji->readuji(-1, "array");
        $data_latih = $this->m_data_latih->readuji(-1, "array");

        if (empty($data_uji) || empty($data_latih)) {
            redirect(site_url('admin/data_uji'));
            return;
        }

        for ($i = 0; $i < count($data_uji); $i++) {
            $DISTANCES = array();
            for ($j = 0; $j < count($data_latih); $j++) {
                $dist['distances'] = $this->distance($data_uji[$i], $data_latih[$j]);
                $dist['jenis'] = $data_latih[$j]['jenis'];
                $dist['id_uji'] = $data_latih[$j]['id_latih'];
                // echo json_encode( $dist ).'<br>' ;

                array_push($DISTANCES, $dist);
            }
            sort($DISTANCES); //mengurutkan distance dari terdekat
            // echo "DISTANCES".json_encode( $DISTANCES ).'<br>' ;

            $K_VALUE = $this->input->post('k_value');
            $NEIGHBOUR = array();
            for ($k = 0; $k < $K_VALUE; $k++) //memetakan tetangga
            {
                if (!isset($NEIGHBOUR[$DISTANCES[$k]['jenis']]))
                    $NEIGHBOUR[$DISTANCES[$k]['jenis']] = array();

                array_push($NEIGHBOUR[$DISTANCES[$k]['jenis']], $DISTANCES[$k]);
            }

            $terbesar =  array();
            foreach (array_keys($NEIGHBOUR) as $paramName) {

                if (count($NEIGHBOUR[$paramName])  > count($terbesar)) {
                    $terbesar = $NEIGHBOUR[$paramName];
                }
            }
            
            $data_uji[$i]['jenis']        = $terbesar[0]['jenis']; 
            $data_uji[$i]['K_VALUE']           = $K_VALUE;
            $data_uji[$i]['distances']         = $DISTANCES;
            $data_uji[$i]['NEIGHBOURS']        = $NEIGHBOUR;

            $data_uji_param['id_uji'] = $data_uji[$i]['id_uji'];
            $this->m_data_uji->updateall($data_uji[$i], $data_uji_param);
        }

    
        $data['files']  = $this->m_data_uji->rangking();
        $data['page_name'] = "Hasil Data Uji";
        $this->load->view("_admin/_template/header");
        $this->load->view("_admin/_template/sidebar_menu");
        $this->load->view("_admin/data_uji/View_detail_uji_batch", $data);
        $this->load->view("_admin/_template/footer");
    }

    function hapus(){
		$this->m_data_uji->hapus_data();
		redirect(site_url('admin/data_uji'));
	}

    //   fungsi untuk menghitung jarak
    private function distance($data_uji, $data_latih)
    {
        $attrs = array(
            'area', 'perimeter', 'metric', 'eccentricity',
            'major_axis', 'minor_axis', 'diameter'
        );
        $value = 0;
        foreach ($attrs as $attr) {
            $value += pow(($data_latih[$attr] - $data_uji[$attr]), 2);
        }
        
        return round(sqrt($value), 6);
    }

}
