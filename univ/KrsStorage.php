<?php
require_once('DbConfig.php');
require_once('MysqliDb.php');
require_once('Krs.php');
class KrsStorage {
	private $db;
	private $krs;
	protected $krss;
	public function KrsStorage() {
        $this->db = new MysqliDb(HOST, USERNAME, PASSWORD, DATABASE);
        $this->krs = new Krs();
        $krss = $this->krs->getKrs();
		foreach ($krss as $krs) {
			$this->krss[] = [
				"url" => $this->makeUrlFromIndex($krs['code']),
				"name" => $krs['name'],
				"nim" => $krs['nim'],
				"code" => $krs['code'],
				"title" => $krs['title'],
				"semester" => $krs['semester'],
			];
		}
	}
	public function create($data) {
		if (isset($data['nim']) && isset($data['code']) && isset($data['semester'])) {
			$this->db->where('nim', $data['nim']);
			$student = $this->db->getOne('students');
			$this->db->where('code', $data['code']);
			$subject = $this->db->getOne('subjects');
			if ($student == null) {
				throw new UnexpectedValueException("Could not create krs, student not found");
			} elseif ($subject == null) {
				throw new UnexpectedValueException("Could not create krs, subject not found");
			} else {
				$data2 = [
					'subject_id' => $subject['id'],
					'student_id' => $student['id'],
					'semester' => $data['semester']
				];
				$insert = $this->db->insert('krs', $data2);
				if ($insert) {
					$data['url'] = $this->makeUrlFromIndex($data['code']);
					return $data;
				} else {
					throw new UnexpectedValueException("Could not create krs, database query error");
				}
			}
		}
		throw new UnexpectedValueException("Could not create krs");
	}
	public function getAll() {
		return $this->krss;
	}
	public function get($id) {
		$student = $this->getByNim($id);
		$subject = $this->getByCode($id);
		if ($student != null) {
			return $student;
		} elseif ($subject != null) {
			return $subject;
		} else {
			if ($student == null) {
				throw new UnexpectedValueException("Could not get krs, student not found");
			}
			if ($subject == null) {
				throw new UnexpectedValueException("Could not get krs, subject not found");
			}
		}
	}
	public function getByStudentId($id) {
		$this->db->where("id", $id);
        $student = $this->db->getOne("students");
        if ($student == null) {
            return null;
        } else {
	        $krs = $this->krs->getKrsByStudentNim($student['nim']);
	        if ($krs == null) {
	            throw new Exception("Krs not found");
	        } else {
				$krs['url'] = $this->makeUrlFromIndex($krs['nim']);
	            return $krs;
	        }
	    }
	}
	public function getBySubjectId($id) {
		$this->db->where("id", $id);
        $subject = $this->db->getOne("subjects");
        if ($subject == null) {
            return null;
        } else {
	        $krs = $this->krs->getAttendedList($subject['code']);
	        if ($krs == null) {
	            return null;
	        } else {
				$krs['url'] = $this->makeUrlFromIndex($krs['code']);
	            return $krs;
	        }
	    }
	}
	public function getByNim($nim) {
        $krss = $this->krs->getKrsByStudentNim($nim);
        if ($krss == null) {
            return null;
        } else {
        	foreach ($krss as $key => $krs) {
				$krss[$key]['url'] = $this->makeUrlFromIndex($krs['code']);
        	}
            return $krss;
        }
	}
	public function getByCode($code) {
        $krss = $this->krs->getAttendedList($code);
        if ($krss == null) {
            return null;
        } else {
        	foreach ($krss as $key => $krs) {
				$krss[$key]['url'] = $this->makeUrlFromIndex($krs['nim']);
        	}
            return $krss;
        }
	}
	protected function makeUrlFromIndex($code)
	{
		return "http://localhost/univ/rest-krs.php/krs/" . $code;
	}
	public function remove($id) {
		$this->db->where('nim', $id);
		$student = $this->db->getOne('students');
		$this->db->where('code', $id);
		$subject = $this->db->getOne('subjects');
		if ($student != null) {
			$this->removeByNim($student['id']);
		} elseif ($subject != null) {
			$this->removeByCode($subject['id']);
		} else {
			if ($student == null) {
				throw new UnexpectedValueException("Could not remove krs, student not found");
			}
			if ($subject == null) {
				throw new UnexpectedValueException("Could not remove krs, subject not found");
			}
		}
	}
	public function removeByNim($id) {
		$this->db->where('student_id', $id);
		if ($this->db->delete('krs')) {
			return true;
		} else {
			return false;
		}
	}
	public function removeByCode($id) {
		$this->db->where('subject_id', $id);
		if ($this->db->delete('krs')) {
			return true;
		} else {
			return false;
		}
	}
	public function update($id, $data) {
		$this->db->where('nim', $id);
		$student = $this->db->getOne('students');
		$this->db->where('code', $id);
		$subject = $this->db->getOne('subjects');
		if ($student != null) {
			$this->updateByStudentId($student['id'], $data);
		} elseif ($subject != null) {
			$this->updateBySubjectId($subject['id'], $data);
		} else {
			if ($student == null) {
				throw new UnexpectedValueException("Could not update krs, student not found");
			}
			if ($subject == null) {
				throw new UnexpectedValueException("Could not update krs, subject not found");
			}
		}
	}
	public function updateByStudentId($id, $data) {
		$this->db->where('code', $data['code']);
		$subject = $this->db->getOne('subjects');
		if ($subject == null) {
			throw new UnexpectedValueException("Could not update krs, subject not found");
		} else {
			$data2 = [];
			if (isset($data['code'])) {
				$data2 = [
					'subject_id' => $subject['id'],
				];
			}
			if (isset($data['semester'])) {
				$data2 = [
					'semester' => $data['semester'],
				];
			}
			$this->db->where('student_id', $id);
			$this->db->update('krs', $data2);
			$krs = $this->getByCode($subject['code']);
			if ($krs == null) {
				throw new UnexpectedValueException("Could not update krs");
			} else {
				return $krs;
			}
		}
	}
	public function updateBySubjectId($id, $data) {
		$this->db->where('nim', $data['nim']);
		$student = $this->db->getOne('students');
		if ($student == null) {
			throw new UnexpectedValueException("Could not update krs, student not found");
		} else {
			$data2 = [];
			if (isset($data['code'])) {
				$data2 = [
					'subject_id' => $subject['id'],
				];
			}
			if (isset($data['semester'])) {
				$data2 = [
					'semester' => $data['semester'],
				];
			}
			$this->db->where('subject_id', $id);
			$this->db->update('krs', $data2);
			$krs = $this->getByNim($student['nim']);
			if ($krs == null) {
				throw new UnexpectedValueException("Could not update krs");
			} else {
				return $krs;
			}
		}
	}
}