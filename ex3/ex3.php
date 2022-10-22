<?php
require('../connection/db_connection.php');

interface PatientRecord {
    public function findId();

    public function findRecords();

  }



class Patient implements PatientRecord{
  //Properties
  public $_id;
  public $pn;
  public $first;
  public $last;
  public $dob;
  public $insurance_records = array();

  function __construct($pn) {
    $this->pn = $pn;
  }
  function get_id() {
    return $this->_id;
  }

  function get_pn() {
    return $this->pn;
  }

  function get_name() {
    $fullname = $this->first . " " . $this->last;
    return $fullname;
  }

  public function findId(){
    echo "getting id";
  }

  public function findRecords(){
    echo "getting records";
  }

  // Methods
//   function set_name($name) {
//     $this->name = $name;
//   }
}

$patient = new Patient(3);
$patient->findId();
$patient->findRecords();

$conn->close();
?>