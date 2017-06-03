<?php

require('../Krs.php');

$options = array("uri" => "http://localhost/ums/soap/");

$server = new SoapServer(null, $options);
$server->setClass('Krs');
$server->handle();
?>