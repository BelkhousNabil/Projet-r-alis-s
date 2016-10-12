<?php
    
    /**
        statistics.php 
            description --> This page gives somes statistics informations
            Controllers --> None
            Model --> None
    **/

    // Include the connexion of the DB in oreder to acces into the application
    require_once 'Config/BD_Conn.php';

    // Show error details
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlFlwPROD="select count(*) from flows where name like '%_PROD%' and name not like '%_PREPROD%'";
    $resultFlwPROD = $dbh->query($sqlFlwPROD);
    $numberFlwPROD = $resultFlwPROD->fetch();

    $sqlMiddPROD="select count(*) from middleware where name like '%_PROD%' and name not like '%_PREPROD%'";
    $resultMiddPROD = $dbh->query($sqlMiddPROD);
    $numberMiddPROD = $resultMiddPROD->fetch();

    $sqlPartPROD="select count(*) from partner where name like'%_PROD%' and name not like '%_PREPROD%'";
    $resultPartPROD = $dbh->query($sqlPartPROD);
    $numberPartPROD = $resultPartPROD->fetch();

    $sqlCompPROD="select count(*) from component where name like'%_PROD%' and name not like '%_PREPROD%'";
    $resultCompPROD = $dbh->query($sqlCompPROD);
    $numberCompPROD = $resultCompPROD->fetch();

    $sqlMiddCl="select distinct client, count(*) as nb from middleware where name like '%_PROD%' and name not like '%_PREPROD%' GROUP BY client";
    $resultMiddCl = $dbh->query($sqlMiddCl);
    
    $sqlMiddSer="select distinct service, count(*) as nb from middleware where name like '%_PROD%' and name not like '%_PREPROD%' GROUP BY service";
    $resultMiddSer = $dbh->query($sqlMiddSer);

    $sqlFlwMidd="select count(*) as nb, middleware from flows where name like '%_PROD%' and name not like '%_PREPROD%' GROUP BY middleware ";
    $resultFlwMidd = $dbh->query($sqlFlwMidd);

    $resultFlwMidd2 = $dbh->query($sqlFlwMidd);

    $flwMid='';
    while($numberMiddFlw = $resultFlwMidd2->fetch()){
        $flwMid=$flwMid.'{"label":"'.$numberMiddFlw[1].'","value": "'.$numberMiddFlw[0].'"},';   
    }
    $flwMid = substr($flwMid, 0,strlen($flwMid)-1);

    $sqlPartMidd="select count(distinct source),count(distinct destination),source,destination,middleware from flows where middleware like '%_PROD%' and middleware not like '%_PREPROD%' GROUP BY middleware ";
    $resultPartMidd = $dbh->query($sqlPartMidd);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/stat.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">
    <title>Flows</title>
    <!-- Including the icon of the page -->
    <link rel="icon" type="image/png" href="assets/img/2.png" />

    <link href='http://fonts.googleapis.com/css?family=Montserrat+Alternates:400,700' rel='stylesheet' type='text/css'>
    
    <script type="text/javascript" src="assets/js/fusioncharts.js"></script>
    <script type="text/javascript" src="assets/js/fusioncharts.charts.js"></script>
    <script type="text/javascript" src="assets/js/fusioncharts.theme.ocean.js"></script>
    <script type="text/javascript" src="assets/js/fusioncharts.theme.fint.js"></script>

    <script type="text/javascript">
      FusionCharts.ready(function () {
        var ageGroupChart = new FusionCharts({
        type: 'doughnut3d',
        renderAt: 'chart-container',
        width: '850',
        height: '400',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                
                "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000,#ee75c2,#1fff5d,#ccc500,black,#ee35ff,#aa0fd2,#adefff",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "use3DLighting": "0",
                "showShadow": "0",
                "enableSmartLabels": "0",
                "startingAngle": "0",
                "showPercentValues": "1",
                "showPercentInTooltip": "0",
                "decimals": "1",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5",
                "showHoverEffect":"1",
                "showLegend": "1",
                "legendBgColor": "#ffffff",
                "legendBorderAlpha": '0',
                "legendShadow": '0',
                "legendItemFontSize": '10',
                "legendItemFontColor": '#666666'
            },
            "data": [
                <?php echo($flwMid); ?>
            ]
        }
    }).render();
});

    </script>

</head>

<body data-spy="scroll" data-target="#navbar" data-offset="0" >
    <header id="header" role="banner">
        <div class="container" style="width: 500%; margin:0; padding:0;">
            <div id="navbar" class="navbar navbar-default" style="width: 150%;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://www.engie.com/" target="_blank"></a>
                </div>
                <div class="collapse navbar-collapse" >
                    <ul class="nav navbar-nav" style="margin-left:12%;">
                        <li class="active" ><a href="index.php"><i class="icon-home"></i></a></li>
                        <li><a href="index.php?#services">Description</a></li>
                        <li><a href="#statistics">Statistics</a></li>
                        <li><a href="View/search.php">Search</a></li>
                        <!--<li><a href="graphe/graphics/halfviz/schema_Client.php">Graphic</a></li>-->
                        <li><a href="View/connection.php">Login</a></li>
                    </ul>

                    <div class='flows' style='margin-left:30%;'>
                        <span>Flows</span>      
                    </div>

                </div>
            </div>
        </div>
    </header>

    <section id="main-slider" class="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h1></h1>
                        <p class="lead"><br></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1></h1>
                        <p class="lead"><br></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="portfolio">
        <div class="container">
            <div class="box">
                
            </div>
        </div>
    </section>

    <section id="statistics">
        <div class="container">
            <div class="box first">
                <div class="row">
                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:-4%;'>
                        <div class="center">
                            <i class="icon-md icon-color1"></i>
                            <h4>Number of flows PROD</h4>
                            
                            <p>
                                <?php echo("Total: ".$numberFlwPROD[0]); ?>
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:-10%;'>
                        <div class="center">
                            <i class="icon-md icon-color2"></i>
                            <h4>Number of middlewaresPROD</h4>
                            <p>
                                <?php echo("Total: ".$numberMiddPROD[0]); ?>
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:-10%;'>
                        <div class="center">
                            <i class="icon-md icon-color3"></i>
                            <h4>Number of partners PROD</h4>
                                    
                                <p>
                                    <?php echo("Total: ".$numberPartPROD[0]); ?>
                                </p>
                            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:-10%;'>
                        <div class="center">
                            <i class="icon-md icon-color4"></i>
                            <h4>Number of components PROD</h4>
                                <p>
                                    <?php echo("Total: ".$numberCompPROD[0]); ?>
                                </p>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:33%;'>
                        <div class="center">
                            <i class="icon-md icon-color7"></i>
                            <h4>Number of flows per middleware PROD</h4>
                            <p>
                                <table style='border:solid 1px;width:70%;margin-left:15%;'>
                                    <tr style='border:solid 1px;'>
                                        <th style='border:solid 1px;text-align:center;'>Middleware</th>
                                        <th style='border:solid 1px;text-align:center;'>Number</th>
                                    </tr>
                                    
                                    <?php
                                        while($numberFlwMidd = $resultFlwMidd->fetch()){
                                            echo("<tr style='border:solid 1px;'>");
                                                echo("<td style='border:solid 1px;'>".$numberFlwMidd[1]."</td>");
                                                echo("<td style='border:solid 1px;'>".$numberFlwMidd[0]."</td>");
                                            echo("</tr style='border:solid 1px;'>");
                                        }

                                    ?>
                                </table>
                            </p>

                        </div>
                        <div id="chart-container" style='margin-left:-75%;'></div>
                    </div>

                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:10%;'>
                        <div class="center">
                            <i class="icon-md icon-color5"></i>
                            <h4 style='margin-bottom:28px;'>Number of middleware PROD per client</h4>
                            <p>
                                <table style='border:solid 1px;width:70%;margin-left:15%;'>
                                    <tr style='border:solid 1px;'>
                                        <th style='border:solid 1px;text-align:center;'>Client</th>
                                        <th style='border:solid 1px;text-align:center;'>Number</th>
                                    </tr>
                                    <?php
                                        while($numberMiddCl = $resultMiddCl->fetch()){
                                            echo("<tr style='border:solid 1px;'>");
                                                echo("<td style='border:solid 1px;text-align:center;'>".$numberMiddCl[0]."</td>");
                                                echo("<td style='border:solid 1px;text-align:center;'>".$numberMiddCl[1]."</td>");
                                            echo("</tr style='border:solid 1px;'>");
                                        }

                                    ?>
                                </table>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:10%;'>
                        <div class="center">
                            <i class="icon-md icon-color6"></i>
                            <h4>Number of middleware PROD per service level offerting</h4>
                            <p>
                                <table style='border:solid 1px;width:70%;margin-left:15%;'>
                                    <tr style='border:solid 1px;'>
                                        <th style='border:solid 1px;text-align:center;'>Service Level offerting</th>
                                        <th style='border:solid 1px;text-align:center;'>Number</th>
                                    </tr>
                                    
                                    <?php
                                        while($numberMiddSer = $resultMiddSer->fetch()){
                                            echo("<tr style='border:solid 1px;'>");
                                                echo("<td style='border:solid 1px;'>".$numberMiddSer[0]."</td>");
                                                echo("<td style='border:solid 1px;'>".$numberMiddSer[1]."</td>");
                                            echo("</tr style='border:solid 1px;'>");
                                        }
                                    ?>
                                </table>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6" style='margin-bottom:3%;margin-left:33%; width:90%;'>
                        <div class="center">
                            <i class="icon-md icon-color7" style='margin-left:-60%;'></i>
                            <h4 style='margin-left:-60%;'>Number of partner per Middleware PROD</h4>
                            <p>
                                <table style='border:solid 1px;width:90%;margin-left:-27%;'>
                                    <tr style='border:solid 1px;'>
                                        <th style='border:solid 1px;text-align:center;'>Middleware PROD</th>
                                        <th style='border:solid 1px;text-align:center;'>Sources</th>
                                        <th style='border:solid 1px;text-align:center;'>Destinations</th>
                                        <th style='border:solid 1px;text-align:center;'>Total</th>
                                    </tr>
                                    
                                    <?php
                                        
                                        while($numberPartMidd = $resultPartMidd->fetch()){
                                            $total=0;
                                            //$total=$numberPartMidd[0]+$numberPartMidd[1];

                                            $sql="select distinct (source) from flows where middleware like '".$numberPartMidd[4]."'";
                                            $result = $dbh->query($sql);

                                                $str='</br>';
                                                $str2='</br>';
                                                while($n = $result->fetch()){
                                                    $str=$str.$n[0]."<hr style='border-color:#999;margin-top:2px;margin-bottom:2px;'>";
                                                    $total++;
                                                }

                                                $sql2="select distinct (destination) from flows where middleware like '".$numberPartMidd[4]."'";
                                                $result2 = $dbh->query($sql2);
 
                                                while($n2 = $result2->fetch()){
                                                    $str2=$str2.$n2[0]."<hr style='border-color:#999;margin-top:2px;margin-bottom:2px;'>";
                                                    if(strpos($str, $n2[0]) == false){
                                                        $total++;
                                                    }
                                                }

                                            $str = substr($str, 0,strlen($str)-64);
                                            $str2 = substr($str2, 0,strlen($str2)-64);

                                            echo("<tr style='border:solid 1px;'>");
                                                echo("<td style='border:solid 1px;'>".$numberPartMidd[4]."</td>");
                                                echo("<td style='border:solid 1px;'>".$str."</td>");
                                                echo("<td style='border:solid 1px;'>".$str2."</td>");
                                                echo("<td style='border:solid 1px;'>".$total."</td>");
                                            echo("</tr style='border:solid 1px;'>");
                                        }

                                    ?>
                                </table>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- The footer of the page that containt the engie corporation -->
    <footer>
        <div class='bas'>
            <div id='corp' style='display: inline;'> </br>
                <p><b>© 2016 ENGIE IT Corion. All Rights Reserved</b></p> 
                <a href='mailto:mehdi.mtougui@engie.com'> <img src='assets/img/outlook.png' alt='Contact' /></a> <a class='contact' href='mailto:mehdi.mtougui@engie.com'></b>Contact</b></a>
            </div>
            <img src='assets/img/flux.PNG'>
        </div>
    </footer>
</br>
</body>
</html>








