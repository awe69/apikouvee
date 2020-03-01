<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pegawai extends RestController{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }
    public function index_get($id_pegawai = null){
        if($id_pegawai == null){
            return $this->returnData($this->db->get('PEGAWAI')->result(),false);
        }else{
            if($this->db->get_where('PEGAWAI', [ 'ID_PEGAWAI' => $id_pegawai] )->result() == NULL){
                return $this->returnData('gagal', 502);
            }
            else{
                return $this->returnData($this->db->get_where('PEGAWAI', [ 'ID_PEGAWAI' => $id_pegawai] )->result(), 200);
            }
        }
    }
    public function index_post($id_pegawai = null){
        $pegawai = new dataPegawai();
        $pegawai->id_pegawai = $this->post('id_pegawai');
        $pegawai->nama_pegawai = $this->post('nama_pegawai');
        $pegawai->tgl_lahir_pegawai = $this->post('tgl_lahir_pegawai');
        $pegawai->phone_pegawai = $this->post('phone_pegawai');
        $pegawai->alamat_pegawai = $this->post('alamat_pegawai');
        $pegawai->jabatan = $this->post('jabatan');
        $pegawai->password = $this->post('password');
        if($id_pegawai == null){
            $response = $this->PegawaiModel->store($pegawai);
        }else{
            $response = $this->PegawaiModel->update($pegawai,$id_pegawai);
        }

    }
    public function index_delete($id_pegawai = null){
        if($id_pegawai == null){
			return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->PegawaiModel->destroy($id_pegawai);
        return $this->returnData($response['message'], $response['error']);
    }
    public function returnData($msg,$error){
        $response['message']=$msg;
        $response['error']=$error;
        $response['status']=200;
        return $this->response($response,200);
	}
}
class dataPegawai{
    public $id_pegawai;
    public $nama_pegawai;
    public $tgl_lahir_pegawai;
    public $phone_pegawai;
    public $alamat_pegawai;
    public $jabatan;
    public $password;
}
?>