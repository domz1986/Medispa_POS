
  window.onload = loadDefaultOnload();

  $(".transactionDropDown").dropdown();


  function Loaddata(ID,qnty,price)
  {
    $('#Qnty').val() = qnty;
    $('#Price').val() = price;
    $.ajax({

      url:"../PHP/BackEndController/POScontroller.php",
      type:"POST",
      data:{func: 1,srch:srch},
      success: function(resultdata){

        $('#loadproductcards').html(resultdata);

      }

    });
  }


  function loadDefaultOnload(){


  }
