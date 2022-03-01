<?php

class M_Setoran extends CI_model{
	public function getListDatav3($listFilters){
		$this->db->select('jamaah.*, provinsi.*, komunitas.*');
		$this->db->select('IFNULL(count(setoran.jumlah),0) as frekuensi');
		$this->db->select('IFNULL(avg(setoran.jumlah),0) as rerata');
		$this->db->select('IFNULL(sum(setoran.jumlah),0) as total');
		$this->db->from('jamaah');
		$this->db->join('provinsi', 'provinsi.id_provinsi = jamaah.id_provinsi', 'left');
		$this->db->join('komunitas', 'komunitas.id_komunitas = jamaah.id_komunitas', 'left');
		$this->db->join('setoran', 'setoran.id_jamaah = jamaah.id_jamaah', 'left');
		$this->db->group_by('setoran.id_jamaah');

		$this->db->order_by('sum(setoran.jumlah)', 'DESC');

		if($listFilters){
			if(!$listFilters['gender']==""){
				$this->db->where('gender',$listFilters['gender']);
			}
		}
		
		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getListDataByIdJamaah($id_jamaah){
		$this->db->select('*');
		$this->db->from('jamaah');
		$this->db->join('provinsi', 'provinsi.id_provinsi = jamaah.id_provinsi', 'left');
		$this->db->join('komunitas', 'komunitas.id_komunitas = jamaah.id_komunitas', 'left');
		$this->db->join('setoran', 'setoran.id_jamaah = jamaah.id_jamaah', 'left');
		$this->db->where('setoran.id_jamaah',$id_jamaah);
		$this->db->order_by('setoran.tanggal_masehi', 'ASC');

		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getSebaranDataBySessionIdJamaahByGender(){
		$this->db->select('setoran.tanggal_masehi');
		$this->db->select('sum(if(jamaah.gender="IKHWAN",setoran.jumlah,0)) as IKHWAN');
		$this->db->select('sum(if(jamaah.gender="AKHWAT",setoran.jumlah,0)) as AKHWAT');
		$this->db->select('avg(if(jamaah.gender="IKHWAN",setoran.jumlah,0)) as rerata_ikhwan');
		$this->db->select('avg(if(jamaah.gender="AKHWAT",setoran.jumlah,0)) as rerata_akhwat');
		$this->db->from('setoran');
		$this->db->join('jamaah', 'jamaah.id_jamaah = setoran.id_jamaah');
		$this->db->group_by('setoran.tanggal_masehi');
		$this->db->order_by('setoran.tanggal_masehi', 'ASC');

		$res = $this->db->get();

		return $res->result_array();
	}	
}

?>