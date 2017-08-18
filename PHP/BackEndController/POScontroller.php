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
      break;

    case 3: //save transaction sales

      $savesales = new InventoryClass();
      $savesales->setsalesTotalPrice($_POST['totalprice']);
      $savesales->setsalesDate($_POST['date']);
      echo $savesales->savesales();
      break;

    case 4: //save fees

      $savefees = new InventoryClass();
      $savefees->setsfeeName($_POST['name']);
      $savefees->setsfeeAmnt($_POST['amnt']);
      $savefees->setsalesID($_POST['salesid']);
      echo $savefees->savefees();
      break;

    case 5: //save product

      $saveproduct = new InventoryClass();
      $saveproduct->setsalesID($_POST['salesid']);
      $saveproduct->setproductID($_POST['proid']);
      $saveproduct->setspQnty($_POST['spqnty']);
      $saveproduct->setspAmnt($_POST['spamnt']);
      echo $saveproduct->saveproduct();
      break;

    case 6: //reduce stocks of products
      $reducestock = new InventoryClass();
      $reducestock->setstockID($_POST['stockid']);
      $reducestock->setspQnty($_POST['spqnty']);
      echo $reducestock->reducestockqnty();
      break;

  }

 ?>
