<?php
/*TEST
http://localhost/ums/rpc/subjects.php?method=subject
http://localhost/ums/rpc/subjects.php?method=subject&code=TIF61733
END TEST*/

require "../Subjects.php";
if(isset($_GET['method'])) {
    switch($_GET['method']) {
        case "subject":
            $subjects = new Subjects();
            if (isset($_GET['code'])) {
                $data = $subjects->getSubjectByCode($_GET['code']);
            } else {
                $data = $subjects->getSubjects();  
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