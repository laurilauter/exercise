<?php
require_once('../connection/db_connection.php');
class Insurance implements PatientRecordInterface{

  protected $_id;
  protected $patient_id;
  protected $pn;
  protected $iname;
  protected $from_date;
  protected $to_date;

  function __construct($_id) {
    $this->$_id = $_id;
    $this->setProperties($_id);
    $this->setPn();
  }

  function get_id() {
    return $this->_id;
  }

  function get_pn() {
    return $this->pn;
  }

  function get_iname() {
    return $this->iname;
  }

  function setProperties($_id) {
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM insurance WHERE _id = $_id");

    $row = mysqli_fetch_assoc($result);
    $this->_id = $row['_id'];
    $this->patient_id = $row['patient_id'];
    $this->iname = $row['iname'];
    $this->from_date = $row['from_date'];
    $this->to_date = $row['to_date'];
    
  }

  function setPn() {
    global $conn;
    $result = mysqli_query($conn, "SELECT pn FROM patient WHERE _id = $this->patient_id");
    $row = mysqli_fetch_assoc($result);
    $this->pn = $row['pn'];
  }

  function validate_insurance_by_date($date){
    //format incoming date
    $date_fragments = explode("-", $date);
    $years = "";
    if($date_fragments[2] > date("Y")-1970){
      $years = '19' . $date_fragments[2];
    } else {
      $years = '20' . $date_fragments[2];
    }

    //format potential empty to_date
    empty($this->to_date) ? $this->to_date = date("Y-m-d") + 999 : $this->to_date ;
    $is_valid = False;
    $normalized_date = $years."-".$date_fragments[0]."-".$date_fragments[1]; 
    if(strtotime($this->from_date) <= strtotime($normalized_date) &&  strtotime($normalized_date) <= strtotime($this->to_date)){

    $is_valid = True;
    }
    return $is_valid ? 'Yes' : 'No';

  }

}

?>