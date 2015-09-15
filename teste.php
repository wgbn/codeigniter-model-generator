<?php
error_reporting( E_ALL );
ini_set('display_errors', 1);

require_once('CIModelGenerator.php');

echo "inicia...<br>";
$models = new CIModelGenerator('localhost', 'root', 'vivasalute', 'reservasModel');
$models->criaModels();
//$models->teste();