<?php

	class Origem extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Origem_model');
		}

		function index(){
		}
	}
