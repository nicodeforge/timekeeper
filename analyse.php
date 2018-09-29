<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$startDate = isset($_GET['s']) ? $_GET['s'] : '2018-01-01';
$endDate = isset($_GET['e']) ? $_GET['e'] : '2018-12-31';

?>
<!DOCTYPE html>
  <!--To track somethin : add class 'project' and give it a label as its id-->
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <title>WIP</title>
     </head>
        <body>
      <!-- Content goes here-->
        <div class="container-fluid" style="margin-bottom: 50px;">
          <nav>
            <div class="nav-wrapper orange">
              <a href="#!" class="brand-logo center-align">Timekeeper</a>
              <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
              <ul class="right hide-on-med-and-down orange">
                <li><a href="index.php">Track</a></li>
                <li><a href="analyse.php">Analyse</a></li>
              </ul>
            </div>
          </nav>

          <ul class="sidenav" id="mobile-demo">
            <li><a href="index.php">Track</a></li>
            <li><a href="analyse.php">Analyse</a></li>
          </ul>
        </div>
        <div class="container">
        	<div class="row">
        		<div class="col s12">
        			<form class="col s12" action="functions/select_date.php" method="POST">
        			  <div class="row">
        			    <div class="input-field col s5">
        			      <input id="startDate" name="startDate" type="text" value="<?php echo $startDate ?>" class="datepicker">
        			      <label for="startDate">Début</label>
        			    </div>
        			    <div class="input-field col s5">
        			      <input id="endDate" name="endDate" type="text" value="<?php echo $endDate ?>" class="datepicker">
        			      <label for="endDate">Fin</label>
        			    </div>
        			    <div class="input-field col s2">
        			    	<input class="btn" type="submit" />
        			    </div>
        			  </div>
        			  
        			</form>

        			 
        		</div>
        	</div>
        </div>
        <div class="container">
         <div class="row">
           <div class="col s12 center-align">
           		<?php 

           		include '/var/www/html/timekeeper/functions/db.inc.php';

           		$sql = "SELECT p.priority,p.title as project, SEC_TO_TIME(SUM(TIME_TO_SEC(l.length))) as length,(TIME_TO_SEC(l.length)/(SELECT SUM(TIME_TO_SEC(length)) FROM log))*100 AS percent FROM projects p INNER JOIN log l ON p.project_id=l.project_id WHERE DATE(l.date_added) BETWEEN '".$startDate."' AND '".$endDate."' GROUP BY p.title,p.priority,percent ORDER BY percent DESC;";

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
           		    	
           		    	 	?>
           		    	 	<table>
           		    	 		<thead>
           		    	 			<td>Prio</td>
           		    	 			<td>Item</td>
           		    	 			<td>Temps passé</td>
           		    	 			<td>%</td>
           		    	 		</thead>
           		    	 	<?php
           		    	 	while ($row = mysqli_fetch_assoc($result)) {
           		    	 	
           		    			
           		    			echo "<tr><td>".$row['priority']."</td><td>".$row['project']."</td><td>".$row['length']."</td><td>".$row['percent']."</td></tr>";
           		    			
           		    	 }
           		    	 	?>
           		    	 </table>
           		    	 <?php
           		    	 }

           		    	
           		    	 $result->close();
           		    	 $mysqli->close();


           		}
           		?>
			</div>
		</div>
		</div>
<!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <!-- Compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
      <script type="text/javascript">
      	$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
      </script>
  </body>
</html>

