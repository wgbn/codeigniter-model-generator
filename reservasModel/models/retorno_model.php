<?php

	class Retorno_model extends Model{

		var $id;
		var $retorno;
		var $descricao;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('retorno');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('retorno');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('retorno',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('retorno',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('retorno');
		}

	}
