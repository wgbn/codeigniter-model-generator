<?php

	class Afiliado_model extends Model{

		var $id;
		var $afiliado;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('afiliado');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('afiliado');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('afiliado',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('afiliado',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('afiliado');
		}

	}
