<?php

	class Convenio_model extends Model{

		var $id;
		var $convenio;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('convenio');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('convenio');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('convenio',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('convenio',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('convenio');
		}

	}
