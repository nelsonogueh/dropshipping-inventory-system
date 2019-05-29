<?php
// This file links all the classes and methods together
if (!isset($_SESSION)) {
    session_start();
}
include_once('DB_Helper.php'); // database-related methods

$db = new DB_Helper();

/*if($db->conn){
    echo "Connected to database!";
}
else{
    echo "Could not connect to database";
}*/


//include_once('all_validations.php');  // validates all inputs
?>