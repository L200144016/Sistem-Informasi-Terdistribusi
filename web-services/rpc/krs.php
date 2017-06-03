<?php
/*TEST
http://localhost/ums/rpc/krs.php?method=krs
http://localhost/ums/rpc/krs.php?method=krs&nim=l200124021
http://localhost/ums/rpc/krs.php?method=krs&code=TIF20833
END TEST*/

require "../Krs.php";
if(isset($_GET['method'])) {
    switch($_GET['method']) {
        case "krs":
            $krs = new Krs();
            if (isset($_GET['nim'])) {
                $data = $krs->getKrsByStudentNim($_GET['nim']);
            } elseif (isset($_GET['code'])) {
                $data = $krs->getAttendedList($_GET['code']);
            } else {
                $data = $krs->getKrs();
            }
            break;
        default:
            http_response_code(400);
            $data = array("error" => "bad request");
            break;
    }
} else {
    http_response_code(400);
    $data = array("error" => "bad request");
}
header("Content-Type: application/json");
echo json_encode($data);