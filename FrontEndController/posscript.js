  window.onload = loadDataOnload();

  document.getElementById('srchproductname').addEventListener("keyup",loadProductsToCards);


  function loadDataOnload(){

    loadProductsToDropBox();
    loadProductsToCards();

  }

function loadProductsToDropBox(){

    $.ajax({

      url:"../PHP/BackEndController/inventorycontroller.php",
      type:"POST",
      data:{func: 3},
      success: function(resultdata){

        $('#loadproductname').html(resultdata);

      }

    });

  }

  function loadProductsToCards(){

    var srch = document.getElementById('srchproductname').value;

    $.ajax({

      url:"../PHP/BackEndController/POScontroller.php",
      type:"POST",
      data:{func: 1,srch:srch},
      success: function(resultdata){

        $('#loadproductcards').html(resultdata);

      }

    });

  }
  function addFeetotable()
  {
    alert("fee");
  }
  function addCurrenttable(ID,name,qnty,pic,category,prcperunit,prunit,prprqnty)
  {
  //  alert("este "+ID+'|'+name+'|'+qnty+'|'+pic+'|'+category+'|'+prcperunit+'|'+prunit+"|");
    if(qnty<=0)
    {
      alert("This product needs to be Restocked");
    }
    else
    {
      $('#addtransactionModal').load('../Modal/addtransactionmodal.php',
      function()
      {
          $('#addtransactionModal').modal('show',
          function()
          {
            Loaddata(ID,name,qnty,pic,category,prcperunit,prunit,prprqnty);
          });
      });
    }
  }
  function remove_row(prodid,stockid)
  {

    var table = document.getElementById('tbl_body');
    var i;
    for(i=0;i<table.rows.length;i++)
    {

      if(table.rows[i].cells[0].innerHTML==prodid && table.rows[i].cells[1].innerHTML==stockid)
      {
        table.deleteRow(i);
      }
    }
  }
  $(".purchaseproductDropDown").dropdown({ fullTextSearch: true });
