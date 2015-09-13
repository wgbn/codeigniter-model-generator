<?php

	class Usuario_acesso_regras_model extends Model{

		var $usuario_acesso_id;
		var $usuario_regras_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('usuario_acesso_regras');
			return $query->result();
		}

		function get_by_id($usuario_regras_id){
			$this->db->where('usuario_regras_id',$usuario_regras_id);
			$query = $this->db->get('usuario_acesso_regras');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('usuario_acesso_regras',$data);
		}

		function update($usuario_regras_id,$data){
			$this->db->where('usuario_regras_id', $usuario_regras_id);
			$this->db->update('usuario_acesso_regras',$data);
		}

		function delete($usuario_regras_id){
			$this->db->where('usuario_regras_id', $usuario_regras_id);
			$this->db->delete('usuario_acesso_regras');
		}

	}
