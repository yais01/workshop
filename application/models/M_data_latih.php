<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_data_latih extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function create($data_latih)
    {
        return $this->db->insert_batch('data_latih', $data_latih);
    }

    public function readuji($id_latih = -1, $mode = "object")
    {
        $sql = "
            SELECT * from data_latih
        ";
        if ($id_latih != -1) {
            $sql .= "
                where id_latih = '$id_latih'
            ";
        }
        if ($mode == "array")
            return $query = $this->db->query($sql)->result_array();
        else
            return $query = $this->db->query($sql)->result();
    }

    public function read($id_latih = -1)
    {
        $sql = "
            SELECT * from data_latih
        ";
        if ($id_latih != -1) {
            $sql .= "
                where id_latih = '$id_latih'
            ";
        }
        return $query = $this->db->query($sql)->result();
    }

    function edit_latih($where,$table){    
        return $this->db->get_where($table,$where);
        }

        function update_data($where,$data){
            $this->db->where($where);
            $this->db->update('data_latih',$data);
        
        
          } 

    public function update($data_latih, $data_latih_param)
    {
        return  $this->db->update('data_latih', $data_latih, $data_latih_param);
    }

    public function delete($data_latih_param)
    {
        return $this->db->delete("data_latih", $data_latih_param);
    }

    function hapus_data(){
        $this->db->empty_table('data_latih');
    }

    public function count()
    {
        return $this->db->count_all("data_latih");
    }

}
