<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PegawaiModel extends CI_Model{
    private $table = 'pegawai';

    public $id_pegawai;
    public $nama_pegawai;
    public $tgl_lahir_pegawai;
    public $phone_pegawai;
    public $alamat_pegawai;
    public $jabatan;
    public $password;
    public $rule =[
        [
            'field' => 'nama',
            'label' => 'nama',
            'rules' => 'required|is_unique[pegawai.nama_pegawai|alpha'
        ],
        [
            'field' => 'tgl_lahir_pegawai',
            'label' => 'tgl_lahir_pegawai',
            'rules' => 'required'
        ],
        [
            'field' => 'phone_pegawai',
            'label' => 'phone_pegawai',
            'rules' => 'required|numeric|exact_length[12]'
        ],
        [
            'field' => 'alamat_pegawai',
            'label' => 'alamat_pegawai',
            'rules' => 'required'
        ],
        [
            'field' => 'jabatan',
            'label' => 'jabatan',
            'rules' => 'required'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required'
        ],
    ];
    public function Rules(){return $this->rule;}
    public function getall(){
        return $this->db->get('pegawai')->result();
    }
    public function store($request) { 
		$this->id_pegawai = $request->id_pegawai;
		$this->nama_pegawai = $request->nama_pegawai; 
		$this->tgl_lahir_pegawai = $request->tgl_lahir_pegawai;
		$this->phone_pegawai = $request->phone_pegawai;
        $this->alamat_pegawai = $request->alamat_pegawai;
        $this->jabatan = $request->jabatan;
        $this->password = password_hash($request->password, PASSWORD_BCRYPT); 
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = ['nama_pegawai' => $request->nama_pegawai, 'tgl_lahir_pegawai' =>$request->tgl_lahir_pegawai,
    'phone_pegawai'=>$request->phone_pegawai,'alamat_pegawai'=>$request->alamat_pegawai,'jabatan'=>$request->jabatan];
        if($this->db->where('id_pegawai',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function destroy($id){
        if (empty($this->db->select('*')->where(array('id_pegawai' => $id))->get($this->table)->row())) return ['msg'=>'Id tidak ditemukan','error'=>true];
        
        if($this->db->delete($this->table, array('id_pegawai' => $id))){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }

}
?>