<?php

	class Telefone_model extends Model{

		var $telefone;
		var $cliente_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('telefone');
			return $query->result();
		}

		function get_by_id($telefone){
			$this->db->where('telefone',$telefone);
			$query = $this->db->get('telefone');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('telefone',$data);
		}

		function update($telefone,$data){
			$this->db->where('telefone', $telefone);
			$this->db->update('telefone',$data);
		}

		function delete($telefone){
			$this->db->where('telefone', $telefone);
			$this->db->delete('telefone');
		}

	}
