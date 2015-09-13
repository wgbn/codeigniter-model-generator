<?php

	class Usuario_acesso_model extends Model{

		var $id;
		var $acesso;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('usuario_acesso');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('usuario_acesso');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('usuario_acesso',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('usuario_acesso',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('usuario_acesso');
		}

	}
