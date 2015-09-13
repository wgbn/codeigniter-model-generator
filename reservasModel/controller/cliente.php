<?php

	class Cliente extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Cliente_model');
		}

		function index(){
		}
	}
