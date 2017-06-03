<?php

require('../Students.php');

$options = array("uri" => "http://localhost/ums/soap/");

$server = new SoapServer(null, $options);
$server->setClass('Students');
$server->handle();

