<?php
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '0';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '0';

if ($startDate != '0' && $endDate !='0') {
	# code...
	header('Location: http://localhost/timekeeper/analyse.php?s='.$startDate.'&e='.$endDate.'');
	exit;
}
?>