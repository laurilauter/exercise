<?php
require('../connection/db_connection.php');

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS hospital_db";
if ($conn->query($sql) === TRUE) {

    echo "Database created > ";
    $conn->select_db("hospital_db");

    //create patient table
    $sql_patient = "CREATE TABLE IF NOT EXISTS `patient` (
        `_id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
        `pn` VARCHAR(11) DEFAULT NULL,
        `first` VARCHAR(15) DEFAULT NULL,
        `last` VARCHAR(25) DEFAULT NULL,
        `dob` DATE DEFAULT NULL,
        PRIMARY KEY (`_id`)
    )";


    if ($conn->query($sql_patient) === TRUE) {
        echo "Table patient created > ";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    //insert data into patient table
    $sql_patient_data = "INSERT INTO `patient` (pn, first, last, dob)
    VALUES ('000000001', 'John', 'Doe', '1990-11-22'),
    ('000000002', 'Jane', 'Smith', '1991-12-23'),
    ('000000003', 'Amy', 'Johnson', '1955-5-13'),
    ('000000004', 'Mary', 'Sanders', '1967-1-3'),
    ('000000005', 'Bob', 'Waters', '1934-7-10'),
    ('000000006', 'Cody', 'Woods', '2001-10-23')";


    if ($conn->query($sql_patient_data) === TRUE) {
        echo "Table patient populated > ";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    //create insurance table
    $sql_insurance = "CREATE TABLE IF NOT EXISTS `insurance` (
        `_id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
        `patient_id` INT(10) unsigned,
        `iname` VARCHAR(40) DEFAULT NULL,
        `from_date` DATE DEFAULT NULL,
        `to_date` DATE DEFAULT NULL,
        PRIMARY KEY (`_id`),
        CONSTRAINT fk_patient_id
        FOREIGN KEY (patient_id) 
        REFERENCES patient(_id)
    )";

    if ($conn->query($sql_insurance) === TRUE) {
        echo "Table content created > ";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    //insert data into insurance table
    $sql_insurance_data = "INSERT INTO `insurance` (patient_id, iname, from_date, to_date)
    VALUES ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'John' 
        AND last = 'Doe'
        AND pn = '000000001'), 'Medicare', '1980-10-22', '2025-12-20'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'John' 
        AND last = 'Doe'
        AND pn = '000000001'), 'Blue Cross', '1980-1-2', '2020-12-20'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Jane' 
        AND last = 'Smith'
        AND pn = '000000002'), 'Medicare', '1990-5-30', '2025-2-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Jane' 
        AND last = 'Smith'
        AND pn = '000000002'), 'National Care', '1990-7-30', '2025-12-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Amy' 
        AND last = 'Johnson'
        AND pn = '000000003'), 'Medicare', '1997-5-30', '2021-2-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Amy' 
        AND last = 'Johnson'
        AND pn = '000000003'), 'Blue Cross', '1998-5-30', '2022-12-12'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Mary' 
        AND last = 'Sanders'
        AND pn = '000000004'), 'Green Cross', '2006-5-30', '2030-2-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Mary' 
        AND last = 'Sanders'
        AND pn = '000000004'), 'Blue Cross', '2009-5-30', '2030-2-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Bob' 
        AND last = 'Waters'
        AND pn = '000000005'), 'New Life', '2006-5-30', '2030-2-2'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Bob' 
        AND last = 'Waters'
        AND pn = '000000005'), 'Kaiser Permanente', '2005-5-29', '2030-2-22'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Cody' 
        AND last = 'Woods'
        AND pn = '000000006'), 'Kaiser Permanente', '2004-5-30', '2030-5-12'),
        ((
        SELECT _id
        AS patient_id 
        FROM patient 
        WHERE first = 'Cody' 
        AND last = 'Woods'
        AND pn = '000000006'), 'Elevance Health', '2004-5-25', '2030-5-11')";


    if ($conn->query($sql_insurance_data) === TRUE) {
        echo "Table insurance populated > ";
    } else {
        echo "Error creating table: " . $conn->error;
    }



} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();


?>