<?php

$options = array("location" => "http://localhost/ums/soap/soap-server-subject.php",
    "uri" => "http://localhost/ums/soap");

try {
    $client = new SoapClient(null, $options);
    $subjects = $client->getSubjects();
    //$subjects = $client->getSubjectByCode("TIF80843");
    echo json_encode($subjects);
} catch (SoapFault $e) {
    var_dump($e);
}
