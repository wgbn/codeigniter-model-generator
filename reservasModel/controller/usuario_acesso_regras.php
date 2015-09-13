<?php

	class Usuario_acesso_regras extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Usuario_acesso_regras_model');
		}

		function index(){
		}
	}
