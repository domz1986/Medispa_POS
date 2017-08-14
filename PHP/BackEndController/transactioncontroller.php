<?php

  session_start();

  include("../Class/transactionclass.php");

  switch ($_POST['func']) {

    case 1:

      $transactionsummary = new TransactionClass();
      $transactionsummary->getDailyTransaction();
      $transactionsummary->getMonthlyTransaction();
      echo $transactionsummary->returnDailyAndMonthlyTransaction();

      break;

    case 2:

      $loadtransactiontotable = new TransactionClass();
      $loadtransactiontotable->setSalesID($_POST['id']);
      $loadtransactiontotable->setDateStart($_POST['start']);
      $loadtransactiontotable->setDateEnd($_POST['end']);
      $loadtransactiontotable->setQuery();
      echo $loadtransactiontotable->loadTransactionToTable();

      $_SESSION['srch_trid'] = $_POST['id'];
      $_SESSION['srch_trds'] = $_POST['start'];
      $_SESSION['srch_trde'] = $_POST['end'];

      break;

    case 3:

      $_SESSION['setForTransactionView'] = $_POST['id'];
      echo $_SESSION['setForTransactionView'];
      break;

    case 4:

      $getTransactionData = new TransactionClass();
      $getTransactionData->setSalesID($_SESSION['setForTransactionView']);
      echo $getTransactionData->getTransactionData();
      break;

    case 5:

      $getTransactionProducts = new TransactionClass();
      $getTransactionProducts->setSalesID($_SESSION['setForTransactionView']);
      echo $getTransactionProducts->loadTransactionProducts();
      break;

    case 6:

      $getTransactionFees = new TransactionClass();
      $getTransactionFees->setSalesID($_SESSION['setForTransactionView']);
      echo $getTransactionFees->loadTransactionFees();
      break;

    case 7:

      $loadtransactiontotable = new TransactionClass();
      $loadtransactiontotable->setSalesID($_SESSION['srch_trid']);
      $loadtransactiontotable->setDateStart($_SESSION['srch_trds']);
      $loadtransactiontotable->setDateEnd($_SESSION['srch_trde']);
      $loadtransactiontotable->setQuery();
      echo $loadtransactiontotable->loadTransactionToTableToPrint();

      break;

  }

 ?>
