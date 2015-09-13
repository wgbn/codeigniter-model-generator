<?php

	class Agendamento extends Controller{

		function __construct(){
			parent::Controller();
			$this->load->model('Agendamento_model');
		}

		function index(){
		}
	}
