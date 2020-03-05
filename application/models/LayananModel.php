<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LayananModel extends CI_Model{
    private $table='layanan';

    public $id_layanan;
    public $id_ukuran;
    public $id_pegawai;
    public $nama_layanan;
    public $harga_layanan;

    public $rule=[
        [
            'field'=>'id_ukuran',
            'label'=>'id_ukuran',
            'rules'=>'required'
        ],
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'nama_layanan',
            'label'=>'nama_layanan',
            'rules'=>'required|is_unique[layanan.nama_layanan]|alpha'
        ],
        [
            'field'=>'harga_layanan',
            'label'=>'harga_layanan',
            'rules'=>'required|numeric'
        ],
    ];
    public function Rules(){return $this->rule;}
    public function getall($id){
        if($id==null){
            $this->db->select('CONCAT(layanan.nama_layanan,'.',)');
            return $this->db->get($this->table)->result();
        }else{
            return $this->db->get_where($this->table, [ 'id_layanan' => $id] )->result();
        }
    }
    public function store($request) { 
        $this->id_pegawai = $request->id_pegawai;
        $this->layanan = $request->layanan;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = [
        'layanan' => $request->layanan,
        'id_pegawai'=>$request->id_pegawai];
        if($this->db->where('id_layanan',$id)->update($this->table, $updateData)){
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($time,$id){
        $delet=[
            'delete_at_layanan'=>$time
        ];
        if($this->db->where('id_layanan',$id)->update($this->table, $delet)){
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>