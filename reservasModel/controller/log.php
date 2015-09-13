<?php

	class Log extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Log_model');
		}

		function index(){
		}
	}
