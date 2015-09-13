<?php

	class Usuario_acesso extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Usuario_acesso_model');
		}

		function index(){
		}
	}
