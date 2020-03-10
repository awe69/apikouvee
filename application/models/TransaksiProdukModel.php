<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiProdukModel extends CI_Model{
    private $table='transaksi_produk';
    private $table2='detil_transaksi_produk';
    
    //id_transaksi_produk,id_pegawai= cs, peg_id_pegawai=kasir, id_hewan,status_transaksi_produk,tgl_transaksi_produk,subtotal_transaksi_produk
    //,total_transaksi_produk,diskon_produk

    public $id_transaksi_produk;
    public $id_pegawai;
    public $id_kasir;
    public $id_hewan;
    public $status_transaksi_produk;
    public $tgl_transaksi_produk;
    public $subtotal_transaksi_produk;
    public $total_transaksi_produk;
    public $diskon_produk;

    public $rule=[
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'nama_produk',
            'label'=>'nama_produk',
            'rules'=>'required|is_unique[produk.nama_produk]|alpha'
        ],
        [
            'field'=>'stock',
            'label'=>'stock',
            'rules'=>'required|numeric'
        ],
        [
            'field'=>'min_stock',
            'label'=>'min_stock',
            'rules'=>'required|numeric'
        ],
        [
            'field'=>'satuan_produk',
            'label'=>'satuan_produk',
            'rules'=>'required|alpha'
        ],
        [
            'field'=>'harga_beli',
            'label'=>'harga_beli',
            'rules'=>'required|numeric'
        ],
        [
            'field'=>'harga_jual',
            'label'=>'harga_jual',
            'rules'=>'required|numeric'
        ],
    ];
    public function Rules(){return $this->rule;}
    public function getall($id){
        if($id==null){
            return $this->db->get_where($this->table, [ 'delete_at_produk' => '0000-00-00 00:00:00'] )->result();
        }else{
            return $this->db->get_where($this->table, [ 'id_produk' => $id] )->result();
        }
    }
    public function store($request) { 
        $this->id_pegawai = $request->id_pegawai;
        $this->nama_produk = $request->nama_produk;
        $this->stock = $request->stock;
        $this->min_stock = $request->min_stock;
        $this->satuan_produk = $request->satuan_produk;
        $this->harga_beli = $request->harga_beli;
        $this->harga_jual = $request->harga_jual;
        $this->gambar = $request->gambar;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil Menbahkan Data','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = [
        'id_pegawai'=>$request->id_pegawai,
        'nama_produk' => $request->nama_produk,
        'stock' => $request->stock,
        'min_stock' => $request->min_stock,
        'satuan_produk' => $request->satuan_produk,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'gambar'=>$request->gambar];
        if($this->db->where('id_produk',$id)->update($this->table, $updateData)){
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($time,$id){
        $delet=[
            'delete_at_produk'=>$time
        ];
        if($this->db->where('id_produk',$id)->update($this->table, $delet)){
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>