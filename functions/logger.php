<?php 

include '/var/www/html/timekeeper/functions/db.inc.php';

//$project = isset($_GET['project']) ? $_GET['project'] : "empty";
//$endTime = isset($_GET['endTime']) ? $_GET['endTime'] : "empty";
//$event = isset($_GET['event']) ? $_GET['event'] : "empty";

 $project1 = isset($_GET['1']) ? $_GET['1'] : '0';
 $project2 = isset($_GET['2']) ? $_GET['2'] : '0';
 $project3 = isset($_GET['3']) ? $_GET['3'] : '0';
 $project4 = isset($_GET['4']) ? $_GET['4'] : '0';
 $project5 = isset($_GET['5']) ? $_GET['5'] : '0';
 $project6 = isset($_GET['6']) ? $_GET['6'] : '0';
 $project7 = isset($_GET['7']) ? $_GET['7'] : '0';
 $project8 = isset($_GET['8']) ? $_GET['8'] : '0';
 $project9 = isset($_GET['9']) ? $_GET['9'] : '0';
 $project10 = isset($_GET['10']) ? $_GET['10'] : '0';
 $project11 = isset($_GET['11']) ? $_GET['11'] : '0';
 $project12 = isset($_GET['12']) ? $_GET['12'] : '0';


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
// Attempt insert query execution
$sql = "INSERT INTO log (project_id, length,date_added) VALUES
            ('1', '".$project1."',NOW()),
            ('2', '".$project2."',NOW()),
            ('3', '".$project3."',NOW()),
            ('4', '".$project4."',NOW()),
            ('5', '".$project5."',NOW()),
            ('6', '".$project6."',NOW()),
            ('7', '".$project7."',NOW()),
            ('8', '".$project8."',NOW()),
            ('9', '".$project9."',NOW()),
            ('10', '".$project10."',NOW()),
            ('11', '".$project11."',NOW()),
            ('12', '".$project12."',NOW())";
if($mysqli->query($sql) === true){
	header('Location: http://localhost/timekeeper/?q=success');
	exit;
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

// Close connection
$mysqli->close();
?>