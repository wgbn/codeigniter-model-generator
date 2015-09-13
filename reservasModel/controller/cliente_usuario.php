<?php

	class Cliente_usuario extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Cliente_usuario_model');
		}

		function index(){
		}
	}
