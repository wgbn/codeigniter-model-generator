<?php

	class Processo_model extends Model{

		var $id;
		var $codigo;
		var $descricao;
		var $cliente_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('processo');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('processo');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('processo',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('processo',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('processo');
		}

	}
