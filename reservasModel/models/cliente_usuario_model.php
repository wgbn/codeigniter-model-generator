<?php

	class Cliente_usuario_model extends Model{

		var $cliente_id;
		var $usuario_id;
		var $inicial;
		var $preparador;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('cliente_usuario');
			return $query->result();
		}

		function get_by_id($usuario_id){
			$this->db->where('usuario_id',$usuario_id);
			$query = $this->db->get('cliente_usuario');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('cliente_usuario',$data);
		}

		function update($usuario_id,$data){
			$this->db->where('usuario_id', $usuario_id);
			$this->db->update('cliente_usuario',$data);
		}

		function delete($usuario_id){
			$this->db->where('usuario_id', $usuario_id);
			$this->db->delete('cliente_usuario');
		}

	}
