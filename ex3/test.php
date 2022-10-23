<?php
require('PatientRecordInterface.php');
require('Patient.php');
require('Insurance.php');

//Testing classes
$today = date("m-d-y");
echo "Testing Patient features\n";
$result_patient = mysqli_query($conn, "SELECT * FROM patient ORDER BY pn ASC LIMIT 20");
while ($row = mysqli_fetch_assoc($result_patient)){
  $patient = new Patient($row['pn']);
  echo $patient->validate_insurance($today);
}

?>