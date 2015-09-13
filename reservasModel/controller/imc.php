<?php

	class Imc extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Imc_model');
		}

		function index(){
		}
	}
