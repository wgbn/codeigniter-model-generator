<?php

	class Indicacao extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Indicacao_model');
		}

		function index(){
		}
	}
