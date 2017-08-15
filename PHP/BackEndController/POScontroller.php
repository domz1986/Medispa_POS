<?php

  session_start();

  include("../Class/inventoryclass.php");
  include("../Class/inventorystockclass.php");

  switch ($_POST['func']) {

    case 1: //LOAD STOCKS TO CARDS

      $loadproducttocards = new InventoryClass();
      echo $loadproducttocards->loadProductListToCards($_POST['srch']);
      break;

    case 2: //LOAD STOCKS

      $loadstocks = new InventoryClass();
      $loadstocks->setProductID($_POST['productid']);
      echo $loadstocks->loadstocks();
  }

 ?>
