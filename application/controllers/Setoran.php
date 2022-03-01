<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setoran extends MY_Controller {	
	public function __construct(){
		parent::__construct();

		$this->vhome = 'index';
		$this->model->tableName = "setoran";
		$this->model->primaryId = "id_setoran";
		$this->formPage = 'admin/form_setoran';
		$this->listReferences = array(
			"id_jamaah" => array(
				"joinTableName" => "jamaah",
				"scope" => "left",
			),
			"id_komunitas" => array(
				"joinTableName" => "komunitas",
				"scope" => "left",
			)
		);

		$this->load->model("M_Setoran");
	}
	
	public function getListDataSetoran(){
		$retval = array();		

		$listFilters = $this->input->post();

		$listData = array();
		$listData = $this->M_Setoran->getListDatav3($listFilters);

		$retval['listData'] = $listData;
		$retval['listFilters'] = $listFilters;

		echo json_encode($retval);
	}

	public function viewProgress()
	{
		@$id = $this->input->post('id_jamaah');
		$this->session->set_userdata('id_jamaah_progres', $id);

		$this->load->view('progress_setoran');
	}

	public function viewDashboard_1()
	{
		$this->load->view('dashboard_1');
	}

	public function getListDataBySessionIdJamaah(){
		$retval = array();		

		$id_jamaah = $this->session->userdata('id_jamaah_progres');
		//$id_jamaah = 'N101';

		$listData = array();
		$listData = $this->M_Setoran->getListDataByIdJamaah($id_jamaah);

		$retval['listData'] = $listData;
		$retval['id_jamaah'] = $id_jamaah;

		echo json_encode($retval);
	}

	public function getSebaranDataBySessionIdJamaahByGender(){
		$retval = array();		

		$listData = array();
		$listData = $this->M_Setoran->getSebaranDataBySessionIdJamaahByGender();

		$retval['listData'] = $listData;
	
		echo json_encode($retval);
	}
}
