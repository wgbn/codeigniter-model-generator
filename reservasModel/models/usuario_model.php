<?php

	class Usuario_model extends Model{

		var $id;
		var $nome;
		var $email;
		var $senha;
		var $usuario_regras_id;
		var $afiliado_id;
		var $registro;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('usuario');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('usuario');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('usuario',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('usuario',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('usuario');
		}

	}
