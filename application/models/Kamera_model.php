<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamera_model extends CI_Model {

    public function list($limit, $start)
    {        
        $this->db->select('*');
        $this->db->from('kamera'); 
        $this->db->join('jenis', 'pegawai.id_jenis=jenis.id_jenis');

        $query = $this->db->get('kamera',$limit, $start);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function insert($data = [])
    {
        $result = $this->db->insert('kamera', $data);
        return $result;
    }

    public function getTotal()
    {
        return $this->db->count_all('kamera');
    }

    public function show($id_kamera)
    {
        $this->db->select('*');
        $this->db->from('kamera'); 
        $this->db->join('jenis', 'kamera.id_jenis=jenis.id_jenis');
        $this->db->where('id_kamera',$id_kamera);     
        $query = $this->db->get();
        return $query->row();
    }

    public function update($id_kamera, $data = [])
    {
        // TODO: set data yang akan di update
        $this->db->where('id_kamera', $id_kamera);
        $this->db->update('kamera', $data);
        return result;
    }
    
    public function delete($id_kamera)
    {
        // TODO: tambahkan logic penghapusan data
        $this->db->where('id_kamera', $id_kamera);

        $this->db->delete('kamera');
    }
}

/* End of file ModelName.php */