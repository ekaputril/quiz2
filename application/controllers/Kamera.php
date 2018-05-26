<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamera extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kamera_model');
        $this->load->model('Jenis_model');
        $this->load->library('pagination');

        // Konfigurasi Upload
        $config['upload_path']          = './assets/uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;

        $this->load->library('upload', $config);
    }

    public function index()
    {

        $data = [];
        $total = $this->Kamera_model->getTotal();
        if ($total > 0) {
            $limit = 2;
            $start = $this->uri->segment(3, 0);
            $config = [
                'base_url' => site_url() . '/kamera/index',
                'total_rows' => $total,
                'per_page' => $limit,
                'uri_segment' => 3,
                // Bootstrap 3 Pagination
                'first_link' => '&laquo;',
                'last_link' => '&raquo;',
                'next_link' => 'Next',
                'prev_link' => 'Prev',
                'full_tag_open' => '<ul class="pagination">',
                'full_tag_close' => '</ul>',
                'num_tag_open' => '<li>',
                'num_tag_close' => '</li>',
                'cur_tag_open' => '<li class="active"><span>',
                'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
                'next_tag_open' => '<li>',
                'next_tag_close' => '</li>',
                'prev_tag_open' => '<li>',
                'prev_tag_close' => '</li>',
                'first_tag_open' => '<li>',
                'first_tag_close' => '</li>',
                'last_tag_open' => '<li>',
                'last_tag_close' => '</li>',
            ];
            $this->pagination->initialize($config);
            $data = [
                'title' => 'Katalog kamera :: Data kamera',
                'kamera' => $this->Kamera_model->list($limit, $start),
                'links' => $this->pagination->create_links(),
            ];
        }

       
        $this->load->view('kamera/index', $data);
    }

    public function create($error='')
    {
        $jenis = $this->Jenis_model->list();
        $data = [
            'error' => $error,
            'data' => $jenis
        ];
        $this->load->view('kamera/create', $data);
    }

    public function show($id_kamera)
    {
        $kamera = $this->Kamera_model->show($id_kamera);
        $data = [
            'data' => $kamera
        ];
        $this->load->view('kamera/show', $data);
    }
    
    public function store()
    {
        // Ambil value 
        $nama = $this->input->post('nama');
        $jenis = $this->input->post('jenis');

        // Validasi 
        $dataval = $nama;
        $errorval = $this->validate($dataval);

        // Pesan Error atau Upload
        if ($errorval==false)
        {
            // Percobaan Upload
            if ( ! $this->upload->do_upload('foto'))
            {
                $error = $this->upload->display_errors();
                $this->create($error);
            }
            else
            {
                // Insert data
                $data = [
                    'nama' => $nama,
                    'id_jenis' => $jenis,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Kamera_model->insert($data);
                
                if ($result)
                {
                    redirect(kamera);
                }
                else
                {
                    $error = array('error' => 'Gagal');
                    $this->load->view('kamera/create', $error);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->create($error);
        }
    }

    public function edit($id_kamera,$error='')
    {
      // TODO: tampilkan view edit data
        $kamera = $this->Kamera_model->show($id_kamera);
        $jenis = $this->Jenis_model->list();
        $data = [
            'data' => $kamera,
            'datakat' => $jenis,
            'error' => $error
        ];
        $this->load->view('kamera/edit', $data);
      
    }

    public function update($id_kamera)
    {
        //Ambil Value
        $id_kamera=$this->input->post('id_kamera');
        $nama = $this->input->post('nama');
        $id_jenis=$this->input->post('id_jenis');

        // Validasi Nama dan Jabatan
        $dataval = [
            'nama' => $nama,
            'jenis' => $jenis
            ];
        $errorval = $this->validate($dataval);

        if ($errorval==false)
        {
            if ( ! $this->upload->do_upload('foto'))
            {
                $data = [
                    'nama' => $nama,  
                    'id_jenis' => $jenis
                    ];
                $result = $this->Kamera_model->update($id_kamera,$data);

                if ($result)
                {
                    redirect('kamera');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('kamera/edit', $data);
                }
            }
            else
            {
                $data = [
                    'nama' => $nama,
                    'id_jenis' => $jenis,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Kamera_model->update($id_kamera,$data);
                
                if ($result)
                {
                    redirect('kamera');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('kamera/edit', $data);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->edit($id_kamera,$error);
        }

        
    }

    public function destroy($id_kamera)
    {
        $kamera = $this->Kamera_model->show($id_kamera);

        unlink('./assets/uploads/'.$kamera->foto);
        
        $this->Kamera_model->delete($id_kamera);

        redirect('kamera');
    }

    public function validate($dataval)
    {
        // Validasi Nama dan Jabatan
        $rules = [
            [
                'field' => 'nama',
                'label' => 'nama',
                'rules' => 'trim|required'
            ]
          ];

        $this->form_validation->set_rules($rules);

        if (! $this->form_validation->run())
        { return true; }
        else
        { return false; }
    } 
}
/* End of file Controllername.php */