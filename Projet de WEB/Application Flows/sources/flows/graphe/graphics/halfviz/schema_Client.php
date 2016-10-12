<?php

/**
        shema.php 
            description --> This page permit to display the flows as graph
            Controllers --> None
            Model --> None
    **/

  
  // Include the connexion of the DB in oreder to acces into the application
  require_once '../../../Config/BD_Conn.php';

  // Show error details
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<title>Flows</title>

	<link rel="stylesheet" href="style/halfviz.css" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

  <script type="text/javascript" src="src/script.js"></script>

  <!-- Including the icon of the page -->
  <link rel="icon" type="image/png" href="style/img/2.PNG" />
</head>

  <script type="text/javascript">
    $(document).keyup(function(e) {
       if (e.keyCode == 27) {    
          $('#mid_list_id').hide();
      }
    });
  </script>
<body>
  <!-- Header of the the page that containt the logo of engie and the name of the application and the menu -->
        <header>            
            <div class='menuItems'>
                <img class='logo' src="style/img/logo-scroll.png" alt="engie">
                <h2 style='margin-left:38%;'>Flows</h2>
                </br>
            </div>  
            
            <li style='float:right;margin-top:-55px;'><a href="../../../index.php"> <img src='style/img/home.png' alt='Welcome' /></a></li>
        </header>
    </br></br></br>

  <div id="halfviz">
    <canvas id="viewport" width="100%" height="100%"></canvas>
    <div id="editor">
      <div class="io" style='height:64px;padding-top:10px;padding-bottom:10px;'>
        <div class="ctrl" ><a href="#" class="new" style='margin-left:40%;margin-top:20%;'><img src="style/img/graph.png" alt='Generate Graphic'></a></div>
      </div>
      <form method='POST' action='#'>
          <input type='text' name='middleware' id='middleware' placeholder='Middleware' required onkeyup="autocomplet()" style='width:90%;height:20px;margin-left:5%;margin-right:5%; margin-top:2%;border-radius:5px;'>
          <ul id="mid_list_id" style='list-style-type:none;color:gray;cursor:pointer;'></ul>
          <input type='submit' name='validate' id='validate' style='width:20%;margin-left:40%;margin-right:40%; margin-top:2%;border-radius:5px;padding:5px;background:#0078BE; border-color:#0078BE;color:white;'>
      </form>

      <ul id="legend">
          <li style='color:red;'>Source</li>
          <li style='color:black;'>Destination</li>
          <li style='color:indigo;'>Components</li>
          <li style='color:green;'>Middleware</li>
      </ul>
      

      <textarea id="code" >
          
      </textarea>  
    </div>
    <div id="grabber"></div>
  </div>  

  <div id="dashboard" style='display:none;'>
    <a href="#" class="about active"><div class="popup"><img src="style/nub.png">About</div>about halfviz</a>
    <a href="#" class="help">syntax help</a>
    <ul class="controls">
      <li class="stiffness">spring tension <span class="frob">10,000</span></li>
      <li class="repulsion">node repulsion <span class="frob">10,000</span></li>
      <li class="friction">friction <span class="frob">20%</span></li>
      <li class="gravity">gravity <span class="toggle">.</span></li>
    </ul>
  </div>


  <script src="../_/jquery-1.6.1.min.js"></script>
  <script src="../_/jquery.address-1.4.min.js"></script>
  <script src="../../lib/arbor.js"></script>
  <script src="../_/graphics.js"></script>

  <!-- the halfviz source, broken out one ‘class’ per file -->
  <script src="src/dashboard.js"></script>
  <script src="src/help.js"></script>
  <script src="src/io.js"></script>
  <script src="src/parseur.js"></script>
  <script src="src/renderer.js"></script>
  

  <?php
    if ( isset( $_POST['validate'] ) ){

        $midd= trim($_POST['middleware']);
        $sq="select source,component_1,middleware,component_2,destination from flows where middleware='".$midd."'";
        $ros = $dbh->query($sq);

        $string='';

        while($row=$ros->fetch()){

          if($row[1]=='' and $row[3]==''){ 
            $string= $string.$row[0]." {color:red}\\n".$row[2]." {color:green}\\n".$row[4]." {color:black}\\n".$row[0]."->".$row[2]."{color:green}\\n".$row[2]."->".$row[4]."{color:green}\\n";
          }

          if($row[1]!='' and $row[3]!=''){
            $string= $string.$row[0]." {color:red}\\n".$row[1]." {color:indigo}\\n".$row[2]." {color:green}\\n".$row[3]." {color:indigo}\\n".$row[4]." {color:black}\\n".$row[0]."->".$row[1]."{color:navy}\\n".$row[1]."->".$row[2]."{color:navy}\\n".$row[2]."->".$row[3]."{color:navy}\\n".$row[3]."->".$row[4]."{color:navy}\\n";
          }

          if($row[1]!='' and $row[3]==''){
            $string= $string.$row[0]." {color:red}\\n".$row[1]." {color:indigo}\\n".$row[2]." {color:green}\\n".$row[4]." {color:black}\\n".$row[4]." {color:black}\\n".$row[0]."->".$row[1]."{color:aqua}\\n".$row[1]."->".$row[2]."{color:aqua}\\n".$row[2]."->".$row[4]."{color:aqua}\\n";
          }

          if($row[1]=='' and $row[3]!=''){
            $string= $string.$row[0]." {color:red}\\n".$row[2]." {color:green}\\n".$row[3]." {color:indigo}\\n".$row[4]." {color:black}\\n".$row[4]." {color:black}\\n".$row[0]."->".$row[2]."{color:red}\\n".$row[2]."->".$row[3]."{color:red}\\n".$row[3]."->".$row[4]."{color:red}\\n";
          }
        }
  ?>

  <script type="text/javascript">
      var lorem = '<?php echo $string ;?>';
      //alert(lorem);
  </script>

  <?php
    }
  ?>

  <script src="src/halfviz.js"></script> 

</body>
</html>
