<?php

  session_start();


  include("../Class/consultationclass.php");
  include("../Class/patientclass.php");


  switch ($_POST['func']) {

    case 1: //LOAD PATIENTS TO THE TABLE

      $loadpatient = new PatientClass();
      echo $loadpatient->loadPatientTable();

      break;

    case 2: //LOAD CONSULTATION TO TABLE

      $loadconsultation = new ConsultationClass();
      echo $loadconsultation->loadConsultationTable($_POST['id']);

      break;

    case 3: //SAVE NEW CONSULTATION RECORD

      //  echo "THIS IS THE ID ".$_SESSION['updatePatientID'];

      $saveconsultation = new ConsultationClass();

      $file_name = basename($_FILES['con_pic']['name']);
      $target_dir = "../../UploadedConsultationPhoto/";
      $target_file = $target_dir . $file_name;

      if (move_uploaded_file($_FILES['con_pic']['tmp_name'], $target_file)){

        $saveconsultation->setconsultHxPhyEx($_POST['con_PhysEx']);
        $saveconsultation->setconsultDx($_POST['con_Dx']);
        $saveconsultation->setconsultMgtTx($_POST['con_Mgt']);
        $saveconsultation->setpatientID($_SESSION['updatePatientID']);
        $saveconsultation->setconPic($file_name);
        echo $saveconsultation->SaveNewConsultation();

      }
      else {

        $saveconsultation->setconsultHxPhyEx($_POST['con_PhysEx']);
        $saveconsultation->setconsultDx($_POST['con_Dx']);
        $saveconsultation->setconsultMgtTx($_POST['con_Mgt']);
        $saveconsultation->setpatientID($_SESSION['updatePatientID']);
        echo $saveconsultation->SaveNewConsultation();

      }

      break;

    case 4: //EDIT CONSULTATION

      $editconsultation = new ConsultationClass();
      $editconsultation->setconsultDate($_POST['editconsultdate1']);
      $editconsultation->setconsultHxPhyEx($_POST['con_PhysEx1']);
      $editconsultation->setconsultDx($_POST['con_Dx1']);
      $editconsultation->setconsultMgtTx($_POST['con_Mgt1']);
      echo $editconsultation->editConsultation($_SESSION['conID']);

      break;

    case 5: //LOAD CONSULTATION

      $loadconsultation = new Consultationclass();
      $loadconsultation->loadDataModal($_SESSION['updatedPatientID']);

      break;

    case 6: //SAVE NEW PATIENT

      $saveNewPatient = new PatientClass();

      $file_name = basename($_FILES['p_pic']['name']);
      $target_dir = "../../UploadedPatientPhoto/";
      $target_file = $target_dir . $file_name;

      if (move_uploaded_file($_FILES['p_pic']['tmp_name'], $target_file)){

    		$saveNewPatient->setPatientLastName($_POST['p_lname']);
    		$saveNewPatient->setPatientFirstName($_POST['p_fname']);
    		$saveNewPatient->setPatientAge($_POST['p_age']);
    		$saveNewPatient->setPatientSex($_POST['p_sex']);
    		$saveNewPatient->setPatientStatus($_POST['p_status']);
    		$saveNewPatient->setPatientAddress($_POST['p_address']);
    		$saveNewPatient->setPatientCellNo($_POST['p_cpnum']);
    		$saveNewPatient->setPatientAddress($_POST['p_address']);
    		$saveNewPatient->setPatientPager($_POST['p_pagernum']);
    		$saveNewPatient->setPatientOffTelNo($_POST['p_offnum']);
    		$saveNewPatient->setPatientResTelNo($_POST['p_restelnum']);
    		$saveNewPatient->setPatientFamHx($_POST['p_fhx']);
    		$saveNewPatient->setPatientAllergy($_POST['p_all']);
    		$saveNewPatient->setPatientPastMedHx($_POST['p_medhx']);
    		$saveNewPatient->setPatientSoap($_POST['p_soap']);
    		$saveNewPatient->setPatientShaToo($_POST['p_shatoo']);
    		$saveNewPatient->setPatientCosPer($_POST['p_cosperf']);
    		$saveNewPatient->setPatientPrevMed($_POST['p_prevmed']);
    		$saveNewPatient->setPatientPresMed($_POST['p_presmed']);
    		$saveNewPatient->setPatientOccu($_POST['p_occu']);
    		$saveNewPatient->setPatientReferredBy($_POST['p_referal']);
        $saveNewPatient->setPatientActive('1');
        $saveNewPatient->setPatientPhoto($file_name);
        echo $saveNewPatient->savePatientToRecord();
        $_SESSION['insertedPatientID'] = $saveNewPatient->getPatientID();

      }else {

        $saveNewPatient->setPatientLastName($_POST['p_lname']);
    		$saveNewPatient->setPatientFirstName($_POST['p_fname']);
    		$saveNewPatient->setPatientAge($_POST['p_age']);
    		$saveNewPatient->setPatientSex($_POST['p_sex']);
    		$saveNewPatient->setPatientStatus($_POST['p_status']);
    		$saveNewPatient->setPatientAddress($_POST['p_address']);
    		$saveNewPatient->setPatientCellNo($_POST['p_cpnum']);
    		$saveNewPatient->setPatientAddress($_POST['p_address']);
    		$saveNewPatient->setPatientPager($_POST['p_pagernum']);
    		$saveNewPatient->setPatientOffTelNo($_POST['p_offnum']);
    		$saveNewPatient->setPatientResTelNo($_POST['p_restelnum']);
    		$saveNewPatient->setPatientFamHx($_POST['p_fhx']);
    		$saveNewPatient->setPatientAllergy($_POST['p_all']);
    		$saveNewPatient->setPatientPastMedHx($_POST['p_medhx']);
    		$saveNewPatient->setPatientSoap($_POST['p_soap']);
    		$saveNewPatient->setPatientShaToo($_POST['p_shatoo']);
    		$saveNewPatient->setPatientCosPer($_POST['p_cosperf']);
    		$saveNewPatient->setPatientPrevMed($_POST['p_prevmed']);
    		$saveNewPatient->setPatientPresMed($_POST['p_presmed']);
    		$saveNewPatient->setPatientOccu($_POST['p_occu']);
    		$saveNewPatient->setPatientReferredBy($_POST['p_referal']);
        $saveNewPatient->setPatientActive('1');
        $saveNewPatient->setPatientPhoto('');
        echo $saveNewPatient->savePatientToRecord();

      }

      break;

    case 7: //SAVE EDITTED PATIENT RECORD

       $upPatient = new PatientClass();

      $file_name = basename($_FILES['p_pic']['name']);
      $target_dir = "../../UploadedPatientPhoto/";
      $target_file = $target_dir . $file_name;

      if($file_name!=null){

    		if (move_uploaded_file($_FILES['p_pic']['tmp_name'], $target_file)){

          $upPatient->setPatientID($_SESSION["updatePatientID"]);
    			$upPatient->setPatientLastName($_POST['p_lname']);
    			$upPatient->setPatientFirstName($_POST['p_fname']);
    			$upPatient->setPatientAge($_POST['p_age']);
    			$upPatient->setPatientSex($_POST['p_sex']);
    			$upPatient->setPatientStatus($_POST['p_status']);
    			$upPatient->setPatientAddress($_POST['p_address']);
    			$upPatient->setPatientCellNo($_POST['p_cpnum']);
    			$upPatient->setPatientAddress($_POST['p_address']);
    			$upPatient->setPatientPager($_POST['p_pagernum']);
    			$upPatient->setPatientOffTelNo($_POST['p_offnum']);
    			$upPatient->setPatientResTelNo($_POST['p_restelnum']);
    			$upPatient->setPatientFamHx($_POST['p_fhx']);
    			$upPatient->setPatientAllergy($_POST['p_all']);
    			$upPatient->setPatientPastMedHx($_POST['p_medhx']);
    			$upPatient->setPatientSoap($_POST['p_soap']);
    			$upPatient->setPatientShaToo($_POST['p_shatoo']);
    			$upPatient->setPatientCosPer($_POST['p_cosperf']);
    			$upPatient->setPatientPrevMed($_POST['p_prevmed']);
    			$upPatient->setPatientPresMed($_POST['p_presmed']);
    			$upPatient->setPatientOccu($_POST['p_occu']);
    			$upPatient->setPatientReferredBy($_POST['p_referal']);
    			$upPatient->setPatientPhoto($file_name);
    			echo $upPatient->updatePatientRecord();

         //   $_SESSION['insertedPatientID'] = $upPatient->getPatientID();
    		}

      }

      else {

          $upPatient->setPatientID($_SESSION["updatePatientID"]);
    			$upPatient->setPatientLastName($_POST['p_lname']);
    			$upPatient->setPatientFirstName($_POST['p_fname']);
    			$upPatient->setPatientAge($_POST['p_age']);
    			$upPatient->setPatientSex($_POST['p_sex']);
    			$upPatient->setPatientStatus($_POST['p_status']);
    			$upPatient->setPatientAddress($_POST['p_address']);
    			$upPatient->setPatientCellNo($_POST['p_cpnum']);
    			$upPatient->setPatientAddress($_POST['p_address']);
    			$upPatient->setPatientPager($_POST['p_pagernum']);
    			$upPatient->setPatientOffTelNo($_POST['p_offnum']);
    			$upPatient->setPatientResTelNo($_POST['p_restelnum']);
    			$upPatient->setPatientFamHx($_POST['p_fhx']);
    			$upPatient->setPatientAllergy($_POST['p_all']);
    			$upPatient->setPatientPastMedHx($_POST['p_medhx']);
    			$upPatient->setPatientSoap($_POST['p_soap']);
    			$upPatient->setPatientShaToo($_POST['p_shatoo']);
    			$upPatient->setPatientCosPer($_POST['p_cosperf']);
    			$upPatient->setPatientPrevMed($_POST['p_prevmed']);
    			$upPatient->setPatientPresMed($_POST['p_presmed']);
    			$upPatient->setPatientOccu($_POST['p_occu']);
    			$upPatient->setPatientReferredBy($_POST['p_referal']);
    			echo $upPatient->updatePatientRecord();

          }

      break;

    case 8: //DELETE CONSULTATION

      $deleteConsultation = new ConsultationClass();
      echo $deleteConsultation->deleteconsultation($_POST['consultationid']);

      break;

    case 9: //SET PATIENT ID TO SESSION FOR UPDATE

      $_SESSION['updatePatientID'] = $_POST['id'];
      echo $_SESSION['updatePatientID'];

      break;

    case 10: //GET PATIENT INFO

      $getpatientinfo = new PatientClass();
      $getpatientinfo->setPatientID($_SESSION['updatePatientID']);
      echo $getpatientinfo->getPatientInfo();

      break;

    case 11: //DELETE PATIENT

      $deletepatient = new PatientClass();
      $deletepatient->setPatientID($_POST['patientid']);
      echo $deletepatient->deletePatient();

      break;

    case 12: //UPDATE PRODUCT INFO

      $_SESSION['conID'] = $_POST['id'];
      echo $_SESSION['conID'];

      break;

    case 13: //GET CONSULTATION DATA

      $getconsultationdata = new consultationclass();
      echo $getconsultationdata->loadDataModal($_SESSION['conID']);

      break;

  }

 ?>
