<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Institusi extends MY_Controller {	
	public function __construct(){
		parent::__construct();

		$this->vhome = 'admin/institusi';
		$this->model->tableName = "institusi";
		$this->model->primaryId = "id_institusi";
		$this->formPage = 'admin/form_institusi';
		$this->listReferences = array(
			"id_provinsi" => array(
				"joinTableName" => "provinsi",
				"scope" => "left",
			)
		);
	}
	
}
