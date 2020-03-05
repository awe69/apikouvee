<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UkuranModel extends CI_Model{
    private $table='ukuran';

    public $id_ukuran;
    public $id_pegawai;
    public $ukuran;

    public $rule=[
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'ukuran',
            'label'=>'ukuran',
            'rules'=>'required|is_unique[ukuran.ukuran]|alpha'
        ]
    ];
    public function Rules(){return $this->rule;}
    public function getall($id){
        if($id==null){
            return $this->db->get($this->table)->result();
        }else{
            return $this->db->get_where($this->table, [ 'id_ukuran' => $id] )->result();
        }
    }
    public function store($request) { 
        $this->id_pegawai = $request->id_pegawai;
        $this->ukuran = $request->ukuran;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = [
        'ukuran' => $request->ukuran,
        'id_pegawai'=>$request->id_pegawai];
        if($this->db->where('id_ukuran',$id)->update($this->table, $updateData)){
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($time,$id){
        $delet=[
            'delete_at_ukuran'=>$time
        ];
        if($this->db->where('id_ukuran',$id)->update($this->table, $delet)){
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>