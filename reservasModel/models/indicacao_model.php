<?php

	class Indicacao_model extends Model{

		var $id;
		var $indicacao;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('indicacao');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('indicacao');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('indicacao',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('indicacao',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('indicacao');
		}

	}
