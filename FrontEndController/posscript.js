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
        break;
      }
    }
    total_update();
  }
  function clearall()
  {
    var table = document.getElementById('tbl_body');
    var i;
    var len = table.rows.length
    alert("len "+len);
    for(i=0;i<len;i++)
    {
      alert("i "+i);
      table.deleteRow(0);
      alert("ping");
    }
    total_update();
  }
  function total_update()
  {
    var table = document.getElementById('tbl_body');
    var total = 0;
    var i;
    var len = table.rows.length
    for(i=0;i<len;i++)
    {
      total=total+parseFloat(table.rows[i].cells[4].innerHTML);
    }
    document.getElementById('total_value').innerHTML = "<b>"+parseFloat(total).toFixed(2)+"</b>";
    document.getElementById('total_value').value = parseFloat(total).toFixed(2);
  }
  function saveall()
  {
    var table = document.getElementById('tbl_body');
    var totalP = parseFloat(document.getElementById('total_value').value).toFixed(2);
    var Today = getDateTime();
    //alert(Today);
    var i;
    var len = table.rows.length
    var transactionID = "";
    if(table.rows[0].cells[0].innerHTML!="")
    {
        $.ajax({
            url: "../PHP/BackEndController/POScontroller.php",
            type: "POST",
            data: {func: 3,totalprice:totalP,date:Today},
            success: function(resultdata)
            {
              //alert(resultdata);
                if($.trim(resultdata) != "")
                {
                    transactionID=$.trim(resultdata);
                    for(i=0;i<=len;i++)
                    {
                        if(table.rows[i].cells[0].innerHTML=="fees")
                        {
                          var fname = table.rows[i].cells[2].innerHTML;
                          var fprice = table.rows[i].cells[4].innerHTML;
                          //alert("transaction ID:"+transactionID);
                          $.ajax({
                              url: "../PHP/BackEndController/POScontroller.php",
                              type: "POST",
                              data: {func: 4,name:fname,amnt:fprice,salesid:transactionID},
                              success: function(resultdata)
                              {
                                  alert(resultdata);
                                  if($.trim(resultdata) != "")
                                  {

                                  }else
                                  {
                                      alert("Fee: Error ");
                                  }
                              }
                            });

                        }
                        else
                        {
                          

                        }
                    }
                }
                else
                {
                    alert("Error gayod!");
                }
            }
          });


    }
    else {
      alert("No transaction to be saved!");
    }
    location.reload();
  }
  function getDateTime()
  {
       var now     = new Date();
       var year    = now.getFullYear();
       var month   = now.getMonth()+1;
       var day     = now.getDate();
       var hour    = now.getHours();
       var minute  = now.getMinutes();
       var second  = now.getSeconds();
       if(month.toString().length == 1) {
           var month = '0'+month;
       }
       if(day.toString().length == 1) {
           var day = '0'+day;
       }
       if(hour.toString().length == 1) {
           var hour = '0'+hour;
       }
       if(minute.toString().length == 1) {
           var minute = '0'+minute;
       }
       if(second.toString().length == 1) {
           var second = '0'+second;
       }
       var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
        return dateTime;
  }
  $(".purchaseproductDropDown").dropdown({ fullTextSearch: true });
