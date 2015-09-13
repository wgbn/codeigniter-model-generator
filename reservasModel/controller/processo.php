<?php

	class Processo extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Processo_model');
		}

		function index(){
		}
	}
