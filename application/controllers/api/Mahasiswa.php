<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller{

    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get(){
        $data = $this->model->getMahasiswa();
        $data2 = $this->model->getMahasiswa();
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data' => $data,
            'datakhusus' => $data2,
        ], REST_Controller:: HTTP_OK);
        
    }

    public function sendmail_post(){
        $from_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('info.ikanpaus@salahjurusan.com', 'salahjurusan');
        $this->email->to($from_email);
        $this->email->subject('Informasi Penting!');
        $this->email->message("
            <center>
                <h1 style='color: #FF5555;'>WELCOME TO SALAH JURUSAN</h1>
                <p>Kami siap melayani Anda!</p>
            </center>
        ");

        if($this->email->send()){
            $this->set_response([
                   'status' => TRUE,
                   'code' => 200,
                   'message'=> 'Email informasi penting berhasil dikirim, silahkan periksa inbox email Anda'
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'status' => FALSE,
                'code' => 404
                'message' => 'Gagal mengirimkan email informasi!'
            ], REST_Controller::HTTP_NOT_FOUND
        );
        }
    }
}