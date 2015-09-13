<?php

	class Situacao extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Situacao_model');
		}

		function index(){
		}
	}
