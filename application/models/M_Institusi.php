<?php

class M_Institusi extends CI_model{
	public function getListData(){
		$query = "SELECT * FROM institusi";
		$res = $this->db->query($query);

		return $res->result_array();
	}

	public function getListDatav2(){
		$this->db->select('institusi.*');
		$this->db->from('institusi');
		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getListDatav3(){
		$this->db->select('institusi.*, provinsi.nama as nama_provinsi');
		$this->db->from('institusi');
		$this->db->join('provinsi', 'provinsi.id_provinsi = institusi.id_provinsi', 'left');
		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getDataById($id){
		$data = $this->db->get_where('institusi', array('id_institusi' => $id));
		return $data->row_array();
	}

	public function insert($data){
		$res = $this->db->insert('institusi',$data);
		return $res;
	}

	public function update($id, $data){
		$this->db->where('id_institusi', $id);
		$res = $this->db->update('institusi', $data);
		return $res;
	}

	public function hapus($id){
		$data = $this->getDataById($id);

		$this->db->where('id_institusi', $id);
		$res = $this->db->delete('institusi');

		if($res){
			return $data;
		}
		else{
			return false;
		}

	}
}

?>