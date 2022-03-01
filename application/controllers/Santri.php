<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Santri extends CI_Controller {
	var $vhome;
	var $model;
	
	public function __construct(){
		parent::__construct();
		$this->vhome = 'santri/home_v2';

		//$this->load->library('session');
	}

	public function index()
	{
		$this->load->view($this->vhome);
	}

	public function login(){
		$retval = array();
		$post_data = $this->input->post(); //CI
		$retval['post_data'] = $post_data;

		$email = $post_data['email'];
		$password = $post_data['password'];

		$emailDefault = "obets@gmail.com";
		$passwordDefault = "1234";

		if($email==$emailDefault && $password==$passwordDefault){
			$status_login = 1;
		}
		else{
			$status_login = 0;
		}

		$retval['status_login'] = $status_login;

		echo json_encode($retval);
		
	}

	public function getParam(){
		$param = $this->session->userdata('menu_param');
		echo json_encode($param);
	}

	public function home(){
		$post_data = $this->input->post();
		$param = $post_data['param'];
		$this->session->set_userdata('menu_param', $param);
		//process param 

		$this->load->view('santri/home_v3');
	}

	public function profile(){
		$post_data = $this->input->post();
		$param = $post_data['param'];
		$this->session->set_userdata('menu_param', $param);

		$this->load->view('santri/profile');
	}

	public function gallery(){
		$post_data = $this->input->post();
		$param = $post_data['param'];
		$this->session->set_userdata('menu_param', $param);

		$this->load->view('santri/gallery');
	}


	public function hello()
	{
		echo ('welcome_message');
	}

	public function getListData(){
		$retval = array();
		//$post_data = $_POST;
		$post_data = $this->input->post(); //CI
		$retval['post_data'] = $post_data;

		$filter_bulan = $post_data['filter_bulan'];
		
		$listData = array();
		$santri1 = array(
			"nis" => "001", 
			"nama" => "Erji", 
			"tanggal_lahir" => "2005-02-01"
		);

		$santri2 = array(
			"nis" => "002", 
			"nama" => "Qory", 
			"tanggal_lahir" => "2005-01-03"
		);

		$santri3 = array(
			"nis" => "003", 
			"nama" => "Ageng", 
			"tanggal_lahir" => "2005-01-04"
		);

		array_push($listData, $santri1);
		array_push($listData, $santri2);
		array_push($listData, $santri3);

		$retval['listData'] = $listData;

		echo json_encode($retval);
	}

	public function listConvertData(){
		$listData = array();

		$santri1 = array(
			"nis" => "001", 
			"nama" => "Erji", 
			"tanggal_lahir" => "2005-01-02"
		);

		$santri2 = array(
			"nis" => "002", 
			"nama" => "Qory", 
			"tanggal_lahir" => "2005-01-03"
		);

		$santri3 = array(
			"nis" => "003", 
			"nama" => "Ageng", 
			"tanggal_lahir" => "2005-01-04"
		);

		array_push($listData, $santri1);
		array_push($listData, $santri2);
		array_push($listData, $santri3);

		$listDatav2 = array();
		foreach ($listData as $key => $value) {
			$fullDate = $this->convertShortDateToFullDate($value['tanggal_lahir']);
			$value['tanggal_lahir'] = $fullDate;
			array_push($listDatav2, $value);
		}

		echo json_encode($listDatav2);
	}

	private function convertShortDateToFullDate($shortDate){
		$fullDate = ''; //Tanggal Bulan Tahun
		$namaBulan = array(
			1 => "Januari", 
			2 => "Februari", 
			3 => "Maret",
			4 => "April",
			5 => "Mei",
			6 => "Juni",
			7 => "Juli",
			8 => "Agustus",
			9 => "September",
			10 => "Oktober",
			11 => "November",
			12 => "Desember",
		);

		$splitDate = explode('-', $shortDate);
		$hari = (int)$splitDate[2];
		$bulan = (int)$splitDate[1];
		$tahun = (int)$splitDate[0];
		
		$fullDate = $hari." ".$namaBulan[$bulan]." ".$tahun;

		return $fullDate;
	}

	public function getListData2($nim='', $kota='Jakarta'){
		/*$nama = "Mahmud";
		echo "Apa kabar ".$nama.", bagaimana kota ".$kota."?";
		echo "NIM : ".$nim;*/

		$listData = array();
		array_push($listData, 'Apel');
		array_push($listData, 'Jambu');
		array_push($listData, 'Mangga');

		$listData['lokasi'] = 'Palembang';
		$listData['penerima'] = 'Ka Gudang';
		$listData['biaya'] = 2000;

		/*for ($i=0; $i < count($listData); $i++) { 
			echo $listData[$i];
		}*/

		//print_r($listData);

		foreach ($listData as $key => $value) {
			echo $key. " ".$value;
		}
	}

	/*public function listData(){
		$this->getListData('09090901');
	}*/
}
