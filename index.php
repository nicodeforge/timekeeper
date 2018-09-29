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
              <a class="col s12 center-align waves-effect btn green text-white" onclick="saveLog()" id="save">Save</a><br>
            </div>
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

          <div class="fixed-action-btn">
          <a class="btn-floating btn-large red">
            <i class="large material-icons">pause</i>
          </a>
          <ul>
            <li><a class="btn-floating project grey darken-1" id="pause" value="0"><i class="material-icons">pause</i></a></li>
            <li><a class="btn-floating project grey darken-1 " id="tel" value="0"><i class="material-icons">phone</i></a></li>
            <li><a class="btn-floating project grey darken-1" id="collegue" value="0"><i class="material-icons">child_care</i></a></li>

          </ul>
        </div>
      <!-- End of content-->
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <!-- Compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

      <script type="text/javascript">
        
        
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
        var currentProject="",
            timeMap = {},
            currentTime = new Date(),
            startsAt = currentTime.toUTCString();


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
          $('#addForm').modal();
          $('.sidenav').sidenav();
          $('.fixed-action-btn').floatingActionButton();

          $('#projet-10').hide();
          $('#projet-11').hide();
          $('#projet-12').hide();

          var feedback = getUrlParameter('q');
          if (feedback == "success") {
            M.toast({html: '<span class="green-text text-lighten-2">Sauvegarde réussie !</span>'})
         
          }
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
          startTime();

        });
        $('.project').click(function(e){
          e.preventDefault();
          var d = new Date(),
              cTime = d.toUTCString(),
              project = $(this).attr('id'),
              projectLength = $(this).attr('value');

          if (project != currentProject){
            if(currentProject!=""){
              $('#'+currentProject).addClass('grey darken-1');
              $('#'+currentProject).removeClass('current green');
              var length = d-currentTime;
              
              var currentLength = projectLength + length;
              currentLength=millisToMinutesAndSeconds(currentLength);
              $('#'+currentProject).attr("value",currentLength);
             
              var log = "\""+currentProject+"\""+",\"stops\","+"\""+cTime+"\""+","+"\""+length+"\"";
              //sendLine();
              $('#log').text($('#log').text()+'\n'+log);
                            
            }
            currentProject = project;
            startsAt = cTime;
            $('#'+currentProject).removeClass('grey darken-1');
            $('#'+currentProject).addClass('current green');
            var log = "\""+project+"\""+",\"starts\","+"\""+cTime+"\"";
            $('#log').text($('#log').text()+'\n'+log);

          }
        });

        function copyText(){
          var theLog = document.getElementById('log'),
          returnMessage = document.getElementById('return-message');
          theLog.select();
          document.execCommand("copy");
          $('#copier').removeClass('red').addClass('green');
        }
      
        function saveLog () {
          console.log("enter saveLog");
          
          timeMap = {
            '1' : $('#projet-1').attr('value'),
            '2' : $('#projet-2').attr('value'),
            '3' : $('#projet-3').attr('value'),
            '4' : $('#projet-4').attr('value'),
            '5' : $('#projet-5').attr('value'),
            '6' : $('#projet-6').attr('value'),
            '7' : $('#projet-7').attr('value'),
            '8' : $('#projet-8').attr('value'),
            '9' : $('#projet-9').attr('value'),
            '10' : $('#pause').attr('value'),
            '11' : $('#tel').attr('value'),
            '12' : $('#collegue').attr('value')
          };
          console.log(timeMap);
          var theLog = "?1="+timeMap['1']+"&2="+timeMap['2']+"&3="+timeMap['3']+"&4="+timeMap['4']+"&5="+timeMap['5']+"&6="+timeMap['6']+"&7="+timeMap['7']+"&8="+timeMap['8']+"&9="+timeMap['9']+"&10="+timeMap['10']+"&11="+timeMap['11']+"&12="+timeMap['12'];
         window.open("/timekeeper/functions/logger.php"+theLog);
          // $.get("/timekeeper/functions/logger.php",{theLog});
          //var theLog = document.getElementById('log');
          //theLog.select();

         // $.get("/functions/logger.php",{theLog});
          //return false
        }
        
        
      </script>
              
    </body>
  </html>