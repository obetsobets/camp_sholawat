<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jamaah extends MY_Controller {	
	public function __construct(){
		parent::__construct();

		$this->vhome = 'admin/top_setoran';
		$this->model->tableName = "jamaah";
		$this->model->primaryId = "id_jamaah";
		$this->formPage = 'admin/form_jamaah';
		$this->listReferences = array(
			"id_provinsi" => array(
				"joinTableName" => "provinsi",
				"scope" => "left",
			)
		);
	}
	
}
