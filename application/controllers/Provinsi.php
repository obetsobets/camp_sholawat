<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->vhome = 'admin/provinsi';
		$this->model->tableName = "provinsi";
		$this->model->primaryId = "id_provinsi";
		$this->formPage = 'admin/form_provinsi';
	}



}
