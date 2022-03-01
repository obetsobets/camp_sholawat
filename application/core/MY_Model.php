<?php

class MY_Model extends CI_model{
	var $tableName;
	var $primaryId;

	public function getListData(){
		$query = "SELECT * FROM ".$this->tableName;
		$res = $this->db->query($query);

		return $res->result_array();
	}

	public function getListDatav2($listReferences,$listFilters){
		$this->db->select('*');
		$this->db->from($this->tableName);
		if($listReferences)
		foreach ($listReferences as $key => $value) {
			$this->db->join($value['joinTableName'], $value['joinTableName'].'.'.$key .' = '. $this->tableName.'.'.$key, $value['scope']);
		}

		if($listFilters)
		foreach ($listFilters as $key => $value) {
			$this->db->where($key, $value);
		}

		$res = $this->db->get();

		return $res->result_array();
	}	

	public function getDataById($id){
		$data = $this->db->get_where($this->tableName, array($this->primaryId => $id));
		return $data->row_array();
	}

	public function insert($data){
		$res = $this->db->insert($this->tableName,$data);
		return $res;
	}

	public function update($id, $data){
		$this->db->where($this->primaryId, $id);
		$res = $this->db->update($this->tableName, $data);
		return $res;
	}

	public function hapus($id){
		$data = $this->getDataById($id);

		$this->db->where($this->primaryId, $id);
		$res = $this->db->delete($this->tableName);

		if($res){
			return $data;
		}
		else{
			return false;
		}

	}
}

?>