<?php

	class Telefone extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Telefone_model');
		}

		function index(){
		}
	}
