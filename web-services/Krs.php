<?php
require_once('DatabaseConfig.php');
require_once('MysqliDb.php');

class Krs {
    private $db;

    public function Krs() {
        $this->db = new MysqliDb(HOST, USERNAME, PASSWORD, DATABASE);
    }

    public function getKrs() {
        $krs = $this->db->rawQuery('SELECT b.nim AS nim, b.name AS name, c.code AS code, c.title AS title, a.semester AS semester FROM krs AS a JOIN students AS b, subjects AS c WHERE a.student_id = b.id AND a.subject_id = c.id');
        return $krs;
    }

    public function getKrsByStudentNim($nim) {
        $krs = $this->db->rawQuery('SELECT c.code AS code, c.title AS title, a.semester AS semester FROM krs AS a JOIN students AS b, subjects AS c WHERE a.student_id = b.id AND a.subject_id = c.id AND b.nim = "' . $nim . '"');
        if ($krs == null) {
            return null;
        } else {
            return $krs;
        }
    }

    public function getAttendedList($code) {
        $attendedList = $this->db->rawQuery('SELECT b.nim AS nim, b.name AS name FROM krs AS a JOIN students AS b, subjects AS c WHERE a.student_id = b.id AND a.subject_id = c.id AND c.code = "' . $code . '"');
        if ($attendedList == null) {
            return null;
        } else {
            return $attendedList;
        }
    }
}
?>