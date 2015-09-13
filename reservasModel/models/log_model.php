<?php

	class Log_model extends Model{

		var $id;
		var $registro;
		var $descricao;
		var $usuario_id;
		var $cliente_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('log');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('log');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('log',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('log',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('log');
		}

	}
