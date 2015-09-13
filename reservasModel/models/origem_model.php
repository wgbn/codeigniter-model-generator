<?php

	class Origem_model extends Model{

		var $id;
		var $origem;
		var $descricao;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('origem');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('origem');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('origem',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('origem',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('origem');
		}

	}
