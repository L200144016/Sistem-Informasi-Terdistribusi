<?php

$options = array("location" => "http://localhost/ums/soap/soap-server-krs.php",
    "uri" => "http://localhost/ums/soap");

try {
    $client = new SoapClient(null, $options);
    $krs = $client->getKrs();
    //$krs = $client->getKrsByStudentNim("l200124021");
    //$krs = $client->getAttendedList("TIF20833");
    echo json_encode($krs);
} catch (SoapFault $e) {
    var_dump($e);
}
?>