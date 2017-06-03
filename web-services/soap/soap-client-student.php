<?php

$options = array("location" => "http://localhost/ums/soap/soap-server-student.php",
    "uri" => "http://localhost/ums/soap");

try {
    $client = new SoapClient(null, $options);
    $students = $client->getStudents();
    //$students = $client->getStudentByNim("l200124021");
    echo json_encode($students);
} catch (SoapFault $e) {
    var_dump($e);
}
