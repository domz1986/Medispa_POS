
  window.onload = loadDefaultOnload();

  $(".transactionDropDown").dropdown();


  function Loaddata(ID,name,qnty,pic,category,prcperunit,prunit,prprqnty)
  {
    var photo = document.getElementById('picture');
    photo.setAttribute('src','../UploadedProductPhoto/'+pic);
    $('#proname').text(name);
    document.getElementById('proname').value = ID;
    if(category=="")
      category='---';
    $('#procat').text(category);
    if(prcperunit=="")
      prcperunit='---';
    if(prunit=="")
      prunit='---';
    $('#proprice').text(prcperunit+" / "+prunit);
    document.getElementById('proprice').value = prcperunit;
    $('#procon').text(prprqnty+" "+prunit+" for each Content")
    document.getElementById('procon').value = prprqnty;
    var newqnty = document.getElementById('stockq'+ID);
    $('#proqnty').text(newqnty.innerHTML+" "+prunit);
    document.getElementById('proqnty').value = newqnty.innerHTML;

    $.ajax({

      url:"../PHP/BackEndController/POScontroller.php",
      type:"POST",
      data:{func: 2,productid:ID},
      success: function(resultdata){
      //  alert(resultdata);
        $('#tbl_stockbody').html(resultdata);

      }

    });


  }

  function check_type()
  {
    var type = $('#tran_type').dropdown('get value');
    var ind = document.getElementById('indi');
    var rep = document.getElementById('repack');
    if(type==1)
    {
        ind.setAttribute('style','visibility:visible');
        rep.setAttribute('style','display:none');
    }else {
        ind.setAttribute('style','display:none');
        rep.setAttribute('style','visibility:visible');
    }
  }

  function loadDefaultOnload(){


  }

  function check_request() //math shit
  {
    var type = $('#tran_type').dropdown('get value');
    var total = $('#proqnty').val();
    var content = $('#procon').val();
    var proprice = $('#proprice').val();
    var setprice = $('#Individual_price').val();
    if(type==1) //sold individually
    {
      var requestqnty = document.getElementById('procon').value;
      if(total>=content && setprice>=1)
      {
        check_stock(requestqnty,setprice);
      }
      else {
        alert("Stock of this product is not enough");
      }
    }else if(type==2)
    {
      var requestqnty = parseFloat(document.getElementById('Repack_quantity').value);
      if(total>=requestqnty)
      {
        check_stock(requestqnty,requestqnty*proprice);

      }
      else
      {
        alert("Stock of this product is not enough");
      }
    }
    else {
      {
        alert("Please insert Transaction Type");
      }
    }
  }
  function check_stock(requestqnty,price)
  {
  //  alert(requestqnty);
    var table = document.getElementById('tbl_stockbody');
    var total=0;
    var stockid = "";
    var i;
    var checkbox;
    for(i=0;i<table.rows.length;i++)
    {
      if(document.getElementById('check'+i).checked)
      {
        total=total+parseFloat(table.rows[i].cells[2].innerHTML);
        stockid = stockid+document.getElementById('check'+i).value+"=";
      }
      else
      {
      }
    }

    var ptable = document.getElementById('tbl_body');
    if(stockid!="" && total>=requestqnty)
    {
          var row = ptable.insertRow(ptable.rows.length);
          var x = row.insertCell();
          x.setAttribute("style","display:none");
          x.innerHTML=document.getElementById('proname').value;
          var y = row.insertCell();
          y.setAttribute("style","display:none");
          y.innerHTML=stockid;
          var productname = document.getElementById('proname');
          var z = row.insertCell();
          z.innerHTML=productname.innerHTML;
          z.setAttribute("style","cursor:pointer;");
          z.setAttribute("onclick","remove_row('"+x.innerHTML+"','"+y.innerHTML+"')");
          row.insertCell().innerHTML=parseFloat(requestqnty).toFixed(2);
          row.insertCell().innerHTML=parseFloat(price).toFixed(2);
          check_quantity(x.innerHTML,parseFloat(requestqnty).toFixed(2));
          var z1 = row.insertCell();
          z1.setAttribute("style","display:none");
          var productQntyperUnit = document.getElementById('procon').innerHTML.split(' ');
          var qntyy = productQntyperUnit[0];
          z1.innerHTML=qntyy;


          $('#addtransactionModal').modal('hide');
    }
    else
    {
        alert("Please check/select enough Stocks");
    }
    total_update();
  }

  function check_quantity(productID,requestqnty)
  {
      var qnty =document.getElementById('stockq'+productID);
      var Orignalqnty = qnty.innerHTML;
      qnty.innerHTML = Orignalqnty - requestqnty;

  }
