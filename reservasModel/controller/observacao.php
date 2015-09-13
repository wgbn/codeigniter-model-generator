<?php

	class Observacao extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Observacao_model');
		}

		function index(){
		}
	}
