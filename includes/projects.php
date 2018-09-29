<?php 

include '/var/www/html/timekeeper/functions/db.inc.php';

$sql = "SELECT * FROM projects WHERE project_id";

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

/* "Create table" ne retournera aucun jeu de résultats */
if ($mysqli->query($sql) === TRUE) {
    printf("Requete succes.\n");
}

/* Requête "Select" retourne un jeu de résultats */
if ($result = $mysqli->query($sql)) {
    if ($result -> num_rows > 0){
    	while ($row = mysqli_fetch_assoc($result)) {
   		
   		echo "<div class=\"col s12 m4 center-align\"><a class=\"grey darken-1 waves-effect waves-light btn btn-large project\" value=\"0\" id=\"projet-".$row['project_id']."\">".$row['title']."</a></div>";
    }
    }
    

   

		
            
	
    /* Libération du jeu de résultats */
    $result->close();
    $mysqli->close();


}
?>