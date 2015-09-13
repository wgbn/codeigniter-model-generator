<?php

	class Agendamento_model extends Model{

		var $id;
		var $registro;
		var $data;
		var $compareceu;
		var $cliente_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('agendamento');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('agendamento');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('agendamento',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('agendamento',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('agendamento');
		}

	}
