<?php

	class Observacao_model extends Model{

		var $id;
		var $observacao;
		var $cliente_id;
		var $usuario_id;
		var $registro;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('observacao');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('observacao');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('observacao',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('observacao',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('observacao');
		}

	}
