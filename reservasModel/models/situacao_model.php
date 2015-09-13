<?php

	class Situacao_model extends Model{

		var $id;
		var $situacao;
		var $cor;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('situacao');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('situacao');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('situacao',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('situacao',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('situacao');
		}

	}
