<?php

use chriskacerguis\RestServer\RestController;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		//memberi limit pada penggunaan apikey
		$this->methods['index_get']['limit'] = 5;
		$this->methods['index_delete']['limit'] = 5;
		$this->methods['index_post']['limit'] = 5;
		$this->methods['index_put']['limit'] = 5;
	}

	public function index_get()
	{
		$id = $this->get('id');
		$mahasiswa = $this->Mahasiswa_model->getAllMahasiswa();

		if($id === null)
		{
			$mahasiswa = $this->Mahasiswa_model->getAllMahasiswa();
		} else {
			$mahasiswa = $this->Mahasiswa_model->getMahasiswaById($id);
		}
		
		if($mahasiswa)
		{
			$this->response([
				'status' => true,
				'data' => $mahasiswa
			], REST_Controller::HTTP_OK); 
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Data Tidak Ditemukan'
			], REST_Controller::HTTP_NOT_FOUND); 
		}
	}

	public function index_delete()
	{
		$id = $this->delete('id');

		//cek ada id yang dikirim atau engga
		if($id === null)
		{
			$this->response([
				'status' => FALSE,
				'message' => 'Butuh Sebuah Id'
			], REST_Controller::HTTP_BAD_REQUEST); 
		} else {
			//cek id ada di database atau engga
			if($this->Mahasiswa_model->delete_mahasiswa($id) > 0)
			{
				//oke
				$this->response([
					'status' => true,
					'id' => $id,
					'message' => 'Data terhapus'
				], REST_Controller::HTTP_NO_CONTENT); 
			} else {
				//false id gaada di database
				$this->response([
					'status' => FALSE,
					'message' => 'Data Tidak Ditemukan'
				], REST_Controller::HTTP_NOT_FOUND); 
			}
		}
	}

	public function index_post()
	{
		$data = [
			'nrp' => $this->post('nrp'),	
			'nama' => $this->post('nama'),
			'email' => $this->post('email'),
			'jurusan' => $this->post('jurusan')			
		];

		if($this->Mahasiswa_model->tambahMahasiswa($data) > 0)
		{
			$this->response([
				'status' => true,
				'message' => 'Data Mahasiswa Ditambah'
			], REST_Controller::HTTP_CREATED); 
		} else {
			//false id gaada di database
			$this->response([
				'status' => FALSE,
				'message' => 'Gagal Menambahkan data'
			], REST_Controller::HTTP_NOT_FOUND); 
		}
	}

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'nrp' => $this->put('nrp'),	
			'nama' => $this->put('nama'),
			'email' => $this->put('email'),
			'jurusan' => $this->put('jurusan')			
		];

		if($this->Mahasiswa_model->ubahMahasiswa($data, $id) > 0)
		{
			$this->response([
				'status' => true,
				'message' => 'Data Mahasiswa Diubah'
			], REST_Controller::HTTP_NO_CONTENT); 
		} else {
			//false id gaada di database
			$this->response([
				'status' => FALSE,
				'message' => 'Gagal Mengubah data'
			], REST_Controller::HTTP_NOT_FOUND); 
		}
	}
}	
?>
