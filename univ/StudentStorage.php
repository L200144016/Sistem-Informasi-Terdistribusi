<?php
require_once('DbConfig.php');
require_once('MysqliDb.php');
require_once('Student.php');
class StudentStorage {
	private $db;
	protected $students;
	public function StudentStorage() {
        $this->db = new MysqliDb(HOST, USERNAME, PASSWORD, DATABASE);
		$cols = ['nim', 'name', 'address'];
        $students = $this->db->get('students', null, $cols);
		foreach ($students as $student) {
			$this->students[$student['nim']] = [
				"url" => $this->makeUrlFromIndex($student['nim']),
				"name" => $student['name'],
				"address" => $student['address']
			];
		}
		
	}
	public function create($data) {
		if (isset($data['name']) && isset($data['nim']) && isset($data['address'])) {
			$insert = $this->db->insert('students', $data);
			if ($insert) {
				$data['url'] = $this->makeUrlFromIndex($data['nim']);
				return $data;
			} else {
				throw new UnexpectedValueException("Could not create student, database query error");
			}
		}
		throw new UnexpectedValueException("Could not create student");
	}
	
	public function getAll() {
		return $this->students;
	}
	public function getOne($nim) {
		$this->db->where("nim", $nim);
        $student = $this->db->getOne("students");
        if ($student == null) {
            throw new Exception("Student not found");
        } else {
        	unset($student['id']);
			$student['url'] = $this->makeUrlFromIndex($student['nim']);
            return $student;
        }
	}
	protected function makeUrlFromIndex($nim)
	{
		return "http://localhost/univ/rest-student.php/students/" . $nim;
	}
	public function remove($nim) {
		$this->db->where('nim', $nim);
		if ($this->db->delete('students')) {
			return true;
		} else {
			return false;
		}
	}
	public function update($nim, $data) {
		$this->db->where('nim', $nim);
		$this->db->update('students', $data);
		$student = $this->getOne($nim);
		if ($student == null) {
			throw new UnexpectedValueException("Could not update student");
		} else {
			return $student;
		}
	}
}