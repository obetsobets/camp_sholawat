<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	var $vhome;
	var $model;
	var $formPage;
	var $listReferences;

	public function __construct(){
		parent::__construct();
		$this->load->model(["CRUDModel"]);
		$this->model = $this->CRUDModel;
	}

	public function index()
	{
		$this->load->view($this->vhome);
	}
	public function viewForm()
	{
		@$id = $this->input->post($this->model->primaryId);

		if($id){ //not null
			$this->session->set_userdata($this->model->primaryId, $id);
			$this->session->set_userdata('status_simpan', 'update');
		}
		else{
			$this->session->set_userdata($this->model->primaryId, null);
			$this->session->set_userdata('status_simpan', 'insert');
		}

		$this->load->view($this->formPage);
	}

	public function getDataBySessionId(){
		$retval = array();
		$id = $this->session->userdata($this->model->primaryId);
		$data = $this->model->getDataById($id);

		$retval[$this->model->primaryId] = $id;
		$retval['data'] = $data;

		echo json_encode($retval);
	}

	public function getDataById(){
		$retval = array();
		@$id = $this->input->post($this->model->primaryId);
		$data = $this->model->getDataById($id);

		$retval[$this->model->primaryId] = $id;
		$retval['data'] = $data;

		echo json_encode($retval);
	}

	public function getListData(){
		$retval = array();		

		$listFilters = $this->input->post();

		$listData = array();
		$listData = $this->model->getListDatav2($this->listReferences,$listFilters);

		$retval['listData'] = $listData;

		echo json_encode($retval);
	}

	public function simpan(){
		$retval = array();
		$post_data = $this->input->post(); //CI
		$retval['post_data'] = $post_data;

		$id_provinsi = $this->session->userdata($this->model->primaryId);
		$status_simpan = $this->session->userdata('status_simpan');

		if($status_simpan=='insert'){
			$sukses = $this->model->insert($post_data) ? 1 : false;
		}
		else if('update'){
			$sukses = $this->model->update($id_provinsi, $post_data) ? 2 : false;
		}
		else{
			$sukses = false;
		}
		

		$retval['sukses'] = $sukses; //status simpan
		echo json_encode($retval);
	}

	public function hapus(){
		$retval = array();
		@$id = $this->input->post($this->model->primaryId);
		$data = $this->model->hapus($id);

		$retval[$this->model->primaryId] = $id;
		$retval['data'] = $data;

		echo json_encode($retval);
	}
	
}
