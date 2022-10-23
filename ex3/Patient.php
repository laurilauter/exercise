<?php
require_once('../connection/db_connection.php');
class Patient implements PatientRecordInterface{

  protected $_id;
  protected $pn;
  protected $first;
  protected $last;
  protected $dob;
  protected $insurance_records = array();

  function __construct($pn) {
    $this->pn = $pn;
    $this->setProperties($pn);
  }

  function get_id() {
    return $this->_id;
  }

  function get_pn() {
    return $this->pn;
  }

  function get_name() {
    return $this->first . " " . $this->last;
  }

  function get_insurance_records() {
    return $this->insurance_records;
  }

  function setProperties($pn) {
    global $conn;

    $result = mysqli_query($conn, "SELECT _id, first, last, dob FROM patient WHERE pn = $pn");

    $row = mysqli_fetch_assoc($result);
    $this->_id = $row['_id'];
    $this->first = $row['first'];
    $this->last = $row['last'];
    $this->dob = $row['dob'];
    //populate $insurance_records
    $insurance_result = mysqli_query($conn, "SELECT _id FROM insurance WHERE patient_id = $this->_id");
    while ($row=mysqli_fetch_assoc($insurance_result)){
      $this->insurance_records[] = new Insurance($row['_id']);
    }
    
  }

  function validate_insurance($date) {
    //include headers
    include_once('./validation_headers.php');
    $table_row = "";
    foreach ($this->insurance_records as $record){
        $obj_pn = $record->get_pn();
        $obj_iname = $record->get_iname();
        $obj_is_valid = $record->validate_insurance_by_date($date);
        $table_row .= "$obj_pn, $this->first $this->last, $obj_iname, $obj_is_valid \n";
    }
    return $table_row;

  }

}

?>