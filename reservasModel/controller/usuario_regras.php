<?php

	class Usuario_regras extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Usuario_regras_model');
		}

		function index(){
		}
	}
