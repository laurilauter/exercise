<?php
require('../connection/db_connection.php');


$sql = "SELECT
patient.pn,
patient.last,
patient.first,
insurance.from_date,
insurance.to_date
FROM
patient
INNER JOIN insurance ON patient._id = insurance.patient_id
ORDER BY insurance.from_date, patient.last";

$result = mysqli_query($conn, $sql);

foreach($result as $row) {
    echo $row['pn'] . ',';
    echo $row['last'] . ',';
    echo $row['first'] . ',';
    echo date('m-d-y', strtotime($row["from_date"])) . ',';
    echo date('m-d-y', strtotime($row["to_date"]));
    echo "\r\n";
}


$sql = "SELECT
last,
first
FROM
patient";

$result = mysqli_query($conn, $sql);

$names = array();

foreach($result as $row) {
    array_push($names, $row['last'], $row['first']);
}

echo "\n";

//a string of character from names
$names_characters = str_replace(',', '',strtoupper(implode(",", $names)));

//order characters
$names_characters_split_arr = str_split($names_characters, 1);
sort($names_characters_split_arr);
$names_characters_sorted = implode('', $names_characters_split_arr);
//remove duplicates
$names_characters_unique = count_chars( $names_characters_sorted, 3);

//total amount of characters
$character_amount = strlen($names_characters);
//total amount of unique characters
$character_amount_unique = strlen($names_characters_unique);


//generate name characters info
for ($i = 0; $i <= $character_amount_unique - 1; $i++) {
  //insert characters
  $nth_character = mb_substr($names_characters_unique, $i, 1);
  echo $nth_character . "\t";
  //insert character count
  $character_count = substr_count($names_characters_sorted, $nth_character);
  echo $character_count . "\t";
  //insert %
  $percentage_of_characters = 100 * $character_count / $character_amount; 
  echo round($percentage_of_characters, 2) . " % \n";
}


?>