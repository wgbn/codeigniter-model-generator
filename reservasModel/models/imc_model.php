<?php

	class Imc_model extends Model{

		var $id;
		var $imc_inicial;
		var $imc_final;
		var $categoria;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('imc');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('imc');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('imc',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('imc',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('imc');
		}

	}
