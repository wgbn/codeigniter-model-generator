<?php

	class Retorno extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Retorno_model');
		}

		function index(){
		}
	}
