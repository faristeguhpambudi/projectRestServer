<?php 

class Mahasiswa_model extends CI_Model{
	public function getAllMahasiswa()
	{
		return $this->db->get('mahasiswa')->result_array();
	}

	public function getMahasiswaById($id)
	{
		return $this->db->get_where('mahasiswa', array('id' => $id))->result_array();
	}

	public function delete_mahasiswa($id)
	{
		//query delete
		$this->db->delete('mahasiswa', ['id' => $id]);
		//mengembalikan nilai
		return $this->db->affected_rows();
	}

	public function tambahMahasiswa($data)
	{
		$this->db->insert('mahasiswa', $data);
		return $this->db->affected_rows();
	}

	public function ubahMahasiswa($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('mahasiswa', $data);
		return $this->db->affected_rows();
	}
}
?>
