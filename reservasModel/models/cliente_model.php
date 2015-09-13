<?php

	class Cliente_model extends Model{

		var $id;
		var $nome;
		var $email;
		var $peso;
		var $altura;
		var $nascimento;
		var $transporte;
		var $registro;
		var $convenio_id;
		var $origem_id;
		var $situacao_id;
		var $indicacao_id;
		var $retorno_id;

		function __construct(){
			parent::Model();
		}

		function get_all(){
			$query = $this->db->get('cliente');
			return $query->result();
		}

		function get_by_id($id){
			$this->db->where('id',$id);
			$query = $this->db->get('cliente');
			return $query->row();
		}

		function insert($data){
			$this->db->insert('cliente',$data);
		}

		function update($id,$data){
			$this->db->where('id', $id);
			$this->db->update('cliente',$data);
		}

		function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('cliente');
		}

	}
