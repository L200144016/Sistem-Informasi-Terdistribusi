<?php
/*TEST
http://localhost/ums/rpc/students.php?method=student
http://localhost/ums/rpc/students.php?method=student&nim=l200124021
END TEST*/

require "../Students.php";
if(isset($_GET['method'])) {
    switch($_GET['method']) {
        case "student":
            $students = new Students();
            if (isset($_GET['nim'])) {
                $data = $students->getStudentByNim($_GET['nim']);
            } else {
                $data = $students->getStudents();
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