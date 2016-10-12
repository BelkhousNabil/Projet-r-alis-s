<?php

// get the environments number
  $sqlCountEv="select count(*) from environment";
  $resultrechCountEv = $dbh->query($sqlCountEv);
  $cptEv = $resultrechCountEv->fetch();

  // get the environments name
  $sqlNameEv="select name from environment";
  $resultrechNameEv = $dbh->query($sqlNameEv);

  ?>