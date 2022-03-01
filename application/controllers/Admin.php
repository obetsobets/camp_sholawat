<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	var $vhome;
	
	public function __construct(){
		parent::__construct();
		$this->vhome = 'admin/home_admin';
	}

	public function index()
	{
		$this->load->view($this->vhome);
	}
	public function beranda()
	{
		$this->load->view('admin/beranda');
	}
	public function top_setoran()
	{
		$this->load->view('admin/top_setoran');
	}

	public function dashboard()
	{
		$this->load->view('admin/dashboard');
	}
	
}
