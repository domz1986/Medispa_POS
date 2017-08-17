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
    $('#addfeeModal').load('../Modal/addfeesmodal.php',
    function()
    {
      $('#addfeeModal').modal('show');
    });
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
      if(table.rows[i].cells[0].innerHTML==prodid && table.rows[i].cells[1].innerHTML==stockid && prodid!="fees")
      {
        var qnty =document.getElementById('stockq'+prodid);
        qnty.innerHTML = parseFloat(qnty.innerHTML) + parseFloat(table.rows[i].cells[3].innerHTML);
        table.deleteRow(i);
      }
      else if (table.rows[i].cells[0].innerHTML=="fees" && table.rows[i].cells[1].innerHTML == stockid)
      {
        table.deleteRow(i);
      }
    }
  }
  function clearall()
  {
    var table = document.getElementById('tbl_body');
    var i;
    var len = table.rows.length
    for(i=0;i<=len;i++)
    {
        table.deleteRow(0);
    }
  }
  function saveall()
  {
    var table = document.getElementById('tbl_body');
    var i;
    var len = table.rows.length
    for(i=0;i<=len;i++)
    {
        table.deleteRow(0);
    }
  }
  $(".purchaseproductDropDown").dropdown({ fullTextSearch: true });
