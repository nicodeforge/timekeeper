<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
 
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
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <style type="text/css">

        .project{
          margin: 15px auto;
        }
        textarea{
          height: 300px;
          overflow: scroll;
        }

        #active{
          height: 50px;
          width: 200px;
          overflow: hidden;
          font-size: 22px;
          font-weight: 900;
          font-family: 'Roboto','sans-serif';
        }
      </style>
    </head>

    <body>
      <!-- Content goes here-->
        <div class="container-fluid" style="margin-bottom: 50px;">
          <nav>
            <div class="nav-wrapper orange">
              <a href="#!" class="brand-logo">Timekeeper</a>
              <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
              <ul class="right hide-on-med-and-down orange">
                <li><a href="index.php">Track</a></li>
                <li><a href="analyse.php">Analyse</a></li>
                <li><a class="grey-text" oncick="recoverLog()">Recovery</a></li>
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
           <div class="col s12 center-align">
             <h2 id="time"></h2>
           </div>
         </div>  
         <div class="row">
         <?php
          include '/var/www/html/timekeeper/includes/projects.php'; 
         ?>
         </div>
          


          <a class="waves-effect waves-light btn grey lighten-2 black-text modal-trigger hide" href="#addform">+</a>
            
        </div>

        <div class="container">
          <div class="row">
            <div class="col s12 center-align">
              <a class="col s12 center-align waves-effect btn btn-large green text-white" value="0" onclick="saveLog()" id="save">Save</a><br>
            </div>
          </div>  
        </div>
        <div class="container">
          <div class="row">
            <div class="col s12" id="log-recovery"></div>
          </div>
        </div>

        

        <div id="addform" class="modal">
            <div class="modal-content">
              <h4>Add Project</h4>
              <div class="row">
                  <form class="col s12" action="functions/add_project.php">
                    <div class="row">
                      <div class="input-field col s6">
                        <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                        <label for="first_name">First Name</label>
                      </div>
                    </div>
                    <input class="btn" type="submit" />
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
          </div>
          <!--
          <div class="fixed-action-btn">
          <a class="btn-floating btn-large red">
            <i class="large material-icons">pause</i>
          </a>
          <ul>
            <li><a class="btn-floating project grey darken-1" id="pause" value="0"><i class="material-icons">pause</i></a></li>
            <li><a class="btn-floating project grey darken-1 " id="tel" value="0"><i class="material-icons">phone</i></a></li>
            <li><a class="btn-floating project grey darken-1" id="collegue" value="0"><i class="material-icons">child_care</i></a></li>

          </ul>
        </div>-->
      <!-- End of content-->
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <!-- Compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

      <script type="text/javascript">
        var timeMap = [],
            active = 0;

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        function millisToMinutesAndSeconds(ms) {
          var seconds = ms / 1000;
              // 2- Extract hours:
              var hours = parseInt( seconds / 3600 ); // 3,600 seconds in 1 hour
              seconds = seconds % 3600; // seconds remaining after extracting hours
              // 3- Extract minutes:
              var minutes = parseInt( seconds / 60 ); // 60 seconds in 1 minute
              // 4- Keep only seconds not extracted to minutes:
              seconds = seconds % 60;
              return hours+":"+minutes+":"+seconds;
        }
        
        $(document).ready(function(){
          var feedback = getUrlParameter('q');
          if (feedback == "success") {
            M.toast({html: '<span class="green-text text-lighten-2">Sauvegarde réussie !</span>'});
           // reboot();
          }

          $('#addForm').modal();
          $('.sidenav').sidenav();
          $('.fixed-action-btn').floatingActionButton();
          //$('#projet-10').hide();
          //$('#projet-11').hide();
          //$('#projet-12').hide();
          
          function checkTime(i) {
            if (i < 10) {
              i = "0" + i;
            }
            return i;
          }

          function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
            t = setTimeout(function() {
              startTime()
            }, 500);
          }


          
          $('.project').click(function(e){
            e.preventDefault;
            var clickedProject = $(this).attr('id');
            clickedProject = $('#'+clickedProject);

            if (clickedProject.hasClass("active green")) {
              clickedProject.removeClass("active green");
              clickedProject.addClass("grey");
              console.log("Project "+clickedProject+" stopped.");
            } else {
              if (!clickedProject.hasClass("active")) {
                
                resetActiveProjects();

                clickedProject.removeClass("grey");
                clickedProject.addClass("active green");
                console.log("Project "+clickedProject.attr('id')+" starts.");
              }
            }

            //console.log(clickedProject);
            //timeMap = {timer_name:clickedProject,timer_content:{duration:duration_active}};
            //console.log(timeMap);
            //timeMap.push({duration_active:new Date()});
          });

          startTime();
          //keepAlive();
        });

        function resetActiveProjects(){
          $('.active').removeClass("green");
          $('.active').addClass("grey");
          $('.active').removeClass("active");
        }

        function setTimeMap (){
          $('.project').each(function(){
              var proj = $(this).attr('id');
              var duration = $(this).attr('value');
              item = {};
              item ["project"] = proj;
              item ["duration"] = duration;
              timeMap.push(item);
                    
          });
        }
        setTimeMap();

        //Ok, c'est un peu bazooka, et utilise probablement trop de ressources, mais je calcule le temps passé en incrémentant 1, chaque seconde, à la valeur du projet actif.
        setInterval(function() {
                   // your code goes here...
                   if($('.active').length > 0){
                    //There is an active element on the page
                    var duration_active_string = $('.active').attr('value'),
                        duration_active = parseInt(duration_active_string);

                    active = (duration_active + 1);
                    $('.active').attr('value',active);// Sets the value of active project element in seconds. Refreshes every 1 second.
                    //console.log(active);
                   }
               }, 1 * 1000);

      //  keepAlive();
        setInterval(function() {
                   // Timemap construction needs huge improvements
                //if (timeMap.length > 0) {
                  //
                    $('.project').each(function(index){
                        var proj = $(this).attr('id');
                        var duration = $(this).attr('value');
                        for (var i = 0; i < timeMap.length; i++) {
                          if (timeMap[index].project === proj) {
                            timeMap[index].duration = duration;
                          
                        } break;
                      }
                    });
                    //break;
                  //}
                  
                //}
                if (typeof(Storage) !== "undefined") {
                              // Code for localStorage/sessionStorage.
                                localStorage.setItem("time-map",JSON.stringify(timeMap));
                                console.log("Inserted "+JSON.stringify(timeMap)+" in local storage");
                              
                          } else {
                              console.log('Sorry! No Web Storage support..');
                          }
                  //updateTimeMap();
                  console.log("timeMap vaut : \n"+JSON.stringify(timeMap));
                  

               }, 5 * 1000);

        

        function millisToMinutesAndSeconds(ms) {
          var seconds = ms / 1000;
              // 2- Extract hours:
              var hours = parseInt( seconds / 3600 ); // 3,600 seconds in 1 hour
              seconds = seconds % 3600; // seconds remaining after extracting hours
              // 3- Extract minutes:
              var minutes = parseInt( seconds / 60 ); // 60 seconds in 1 minute
              // 4- Keep only seconds not extracted to minutes:
              seconds = seconds % 60;
              return hours+":"+minutes+":"+seconds;
        }

        function saveLog () {
          resetActiveProjects();

          //for (var i = 0; i < timeMap.length; i++) {
            var theLog = "";
            $('.project').each(function(index){
                var proj = $(this).attr('id');
                var duration = $(this).attr('value')*1000;
                duration = millisToMinutesAndSeconds(duration);
                var i = index+1;
                theLog += i+"="+duration+"&";
                //theLog.push(duration)   
                // 1=0&n=x&16=4568
            });
            var query_length = theLog.length - 1,
                query = "?"+theLog.slice(0,query_length);
            //console.log(query);
            window.open("./functions/logger.php"+query);
          //}

          
        }

       /* function reboot () {
          $('.project').each(function(index){
            $(this).attr('value') = 0;
          });
        }*/
        
      </script>
              
    </body>
  </html>