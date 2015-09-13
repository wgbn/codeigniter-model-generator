<?php

	class Afiliado extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Afiliado_model');
		}

		function index(){
		}
	}
