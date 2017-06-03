<?php

require('../Subjects.php');

$options = array("uri" => "http://localhost/ums/soap/");

$server = new SoapServer(null, $options);
$server->setClass('Subjects');
$server->handle();

