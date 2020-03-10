<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class TransaksiProduk extends RestController{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('TransaksiProdukModel');
        $this->load->library('form_validation');
    }

    // public function index_get($id_produk = null){
    //     $produk = $this->TransaksiProdukModel->getall($id_produk);
    //     if($produk == null){
    //         $this->response(['Message'=>'Data Tidak Ditemukan','Error'=>true],404);
    //     }else{
    //         if($id_produk==null){
    //             $this->response(['Data'=>$produk,'Error'=>false],200);
    //         }
    //         else{
    //             $this->response(['Data'=>$produk,'Error'=>false],200);
    //         }
    //     }
    // }
    public function index_post($id_produk = null){
        //id_transaksi_produk,id_pegawai= cs, peg_id_pegawai=kasir, id_hewan,status_transaksi_produk,tgl_transaksi_produk,subtotal_transaksi_produk
        //,total_transaksi_produk,diskon_produk
        $validation = $this->form_validation;
        $rule = $this->TransaksiProdukModel->Rules();
        $validation->set_rules($rule);
        if (!$validation->run()) {
			return $this->returnData($this->form_validation->error_array(), true,400);
        }else{
            $TransaksiProduk = new dataTransaksiProduk();
            $TransaksiProduk->id_pegawai = $this->post('id_pegawai');
            $TransaksiProduk->nama_produk = $this->post('nama_produk');
            $TransaksiProduk->stock = $this->post('stock');
            $TransaksiProduk->min_stock = $this->post('min_stock');
            $TransaksiProduk->satuan_produk = $this->post('satuan_produk');
            $TransaksiProduk->harga_beli = $this->post('harga_beli');
            $TransaksiProduk->harga_jual = $this->post('harga_jual');
            if($id_produk==null){
                $TransaksiProduk->gambar = $this->_uploadImage();
                $response = $this->TransaksiProdukModel->store($TransaksiProduk);
                $this->response(['Message'=>$response['msg'],'Error'=>$response['error']],200);
            }
            else{
                $response = $this->TransaksiProdukModel->update($TransaksiProduk,$id_produk);
                $this->response(['Message'=>$response['msg'],'Error'=>$response['error']],200);
            }
        }
    }
    
    public function index_delete($id_produk){
        // $id_produk = $this->put('id_produk');
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $response = $this->TransaksiProdukModel->delete($now,$id_produk);
        $this->response(['Message'=>$response['msg'],'Error'=>$response['error']],200);
    }

    public function returnData($msg,$error,$sts){
        $response['message']=$msg;
        $response['error']=$error;
        return $this->response($response,$sts);
    }
    private function _uploadImage()
    {
        $config['upload_path']          = './upload/produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->post('nama_produk');
        $config['overwrite']			= true;
        $config['max_size']             = 1024;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar')) {
            return $this->upload->data("file_name");
        }
        
        return "default.jpg";
    }

}
class dataTransaksiProduk{
    public $id_produk;
    public $id_pegawai;
    public $nama_produk;
    public $stock;
    public $min_stock;
    public $satuan_produk;
    public $harga_beli;
    public $harga_jual;
    public $gambar;
}
?>