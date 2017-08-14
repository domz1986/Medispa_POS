
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
    $('#proqnty').text(qnty+" "+prunit);
    document.getElementById('proqnty').value = qnty;
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
    var setprice = $('#Individual_price').val();
    if(type==1) //sold individually
    {
      if(total>=content && setprice>=1)
      {
        $('#selectstockModal').load('../Modal/selectionstockmodal.php', function()
        {
            $('#selectstockModal').modal('show',function(e)
            {
              var id = document.getElementById('proname').value;
              loaddata(id,content,setprice);
            });
        });
      }
      else {
        alert("Stock of this product is not enough");
      }
    }else
    {
      var requestqnty = document.getElementById('Repack_quantity').value;
      if(total>=requestqnty&&requestqnty!='')
      {
        $('#selectstockModal').load('../Modal/selectionstockmodal.php', function()
        {
            $('#selectstockModal').modal('show',function(e)
            {
              var id = document.getElementById('proname').value;
              var price = document.getElementById('proprice').value * requestqnty;
              loaddata(id,requestqnty,price);
            });
        });
      }
      else
      {
        alert("Stock of this product is not enough");
      }
    }
  }
