<?php

  session_start();

  include("../Class/tempclass.php");


  switch ($_POST['func']) {

    case 1: //LOAD STOCKS TO CARDS

      $realignall = new TempClass();
      echo $realignall->realign();
      break;
    }
 ?>
