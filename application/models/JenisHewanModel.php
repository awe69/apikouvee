<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisHewanModel extends CI_Model{
    private $table='jenis_hewan';

    public $id_jenishewan;
    public $id_pegawai;
    public $jenishewan;

    public $rule=[
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'jenishewan',
            'label'=>'jenishewan',
            'rules'=>'required|is_unique[jenis_hewan.jenishewan]|alpha'
        ]
    ];
    public function Rules(){return $this->rule;}
    public function getall($id){
        if($id==null){
            return $this->db->get_where($this->table, [ 'delete_at_jhewan' => '0000-00-00 00:00:00'] )->result();
        }else{
            return $this->db->get_where($this->table, [ 'id_jenishewan' => $id] )->result();
        }
    }
    public function store($request) { 
        $this->id_pegawai = $request->id_pegawai;
        $this->jenishewan = $request->jenishewan;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = [
        'jenishewan' => $request->jenishewan,
        'id_pegawai'=>$request->id_pegawai];
        if($this->db->where('id_jenishewan',$id)->update($this->table, $updateData)){
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($time,$id){
        $delet=[
            'delete_at_jhewan'=>$time
        ];
        if($this->db->where('id_jenishewan',$id)->update($this->table, $delet)){
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>