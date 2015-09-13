<?php

	class Usuario extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Usuario_model');
		}

		function index(){
		}
	}
