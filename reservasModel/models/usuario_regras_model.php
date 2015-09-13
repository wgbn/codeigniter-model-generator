<?php

	class Usuario_regras_model extends Model{

		var $id;
		var $regra;
		var $descricao;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('usuario_regras');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('usuario_regras');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('usuario_regras',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('usuario_regras',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('usuario_regras');
		}

	}
