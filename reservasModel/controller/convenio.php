<?php

	class Convenio extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Convenio_model');
		}

		function index(){
		}
	}
