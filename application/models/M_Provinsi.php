<?php

class M_Provinsi extends CI_model{
	public function getListData(){
		$query = "SELECT * FROM provinsi";
		$res = $this->db->query($query);

		return $res->result_array();
	}

	public function getListDatav2(){
		$this->db->select('provinsi.*');
		$this->db->from('provinsi');
		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getDataById($id){
		$data = $this->db->get_where('provinsi', array('id_provinsi' => $id));
		return $data->row_array();
	}

	public function insert($data){
		$res = $this->db->insert('provinsi',$data);
		return $res;
	}

	public function update($id, $data){
		$this->db->where('id_provinsi', $id);
		$res = $this->db->update('provinsi', $data);
		return $res;
	}

	public function hapus($id){
		$data = $this->getDataById($id);

		$this->db->where('id_provinsi', $id);
		$res = $this->db->delete('provinsi');

		if($res){
			return $data;
		}
		else{
			return false;
		}

	}
}

?>